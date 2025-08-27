<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\MembershipCredentialsMail;
use App\Models\User;
use Carbon\Carbon;

class MpesaWebhookController extends Controller
{
    public function registrationCallback(Request $request)
    {
        $payload = $request->all();
        $cb = data_get($payload, 'Body.stkCallback');
        $resultCode = (int) data_get($cb, 'ResultCode');
        $resultDesc = data_get($cb, 'ResultDesc');
        $checkoutId = data_get($cb, 'CheckoutRequestID');

        // Map metadata
        $meta = collect(data_get($cb, 'CallbackMetadata.Item', []))
            ->mapWithKeys(fn($i) => [$i['Name'] => $i['Value'] ?? null]);

        $amount = $meta->get('Amount');
        $receipt = $meta->get('MpesaReceiptNumber');
        $phone   = $meta->get('PhoneNumber');
        $txnDate = $meta->get('TransactionDate');
        $paidAt  = $txnDate ? Carbon::createFromFormat('YmdHis', $txnDate, 'Africa/Nairobi') : now('Africa/Nairobi');

        // Update payment record
        $payment = DB::table('mpesa_payments')->where('checkout_request_id', $checkoutId)->first();
        if ($payment) {
            DB::table('mpesa_payments')->where('id', $payment->id)->update([
                'result_code' => $resultCode,
                'result_desc' => $resultDesc,
                'mpesa_receipt_number' => $receipt,
                'transaction_date' => $paidAt,
                'callback_metadata' => json_encode($meta),
                'status' => $resultCode === 0 ? 'successful' : 'failed',
                'updated_at' => now(),
            ]);
        }

        if ($resultCode !== 0) {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Recorded fail']);
        }

        // Fetch pending registration
        $pending = DB::table('pending_registrations')->where('checkout_request_id', $checkoutId)->first();
        if (!$pending) {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'No pending found']);
        }

        $data = json_decode($pending->data, true);

        // Normalize phone number
        $phoneNormalized = preg_replace('/\s+/', '', $data['PHONE_NUMBER']);
        if (str_starts_with($phoneNormalized, '0')) $phoneNormalized = '254' . substr($phoneNormalized, 1);
        if (str_starts_with($phoneNormalized, '+')) $phoneNormalized = ltrim($phoneNormalized, '+');

        // Prevent duplicate users
        if (User::where('EMAIL', $data['EMAIL'])
            ->orWhere('PHONE_NUMBER', $phoneNormalized)
            ->orWhere('NATIONAL_ID_NUMBER', $data['NATIONAL_ID_NUMBER'])->exists()) {

            DB::transaction(function() use ($pending) {
                // Delete temp photo if exists
                if (!empty($pending->passport_photo_tmp)) {
                    $tmpAbs = public_path($pending->passport_photo_tmp);
                    if (file_exists($tmpAbs)) @unlink($tmpAbs);
                }
                // Delete pending registration
                DB::table('pending_registrations')->where('id', $pending->id)->delete();
            });

            \Log::info('Duplicate registration prevented', [
                'email' => $data['EMAIL'],
                'phone' => $phoneNormalized,
                'national_id' => $data['NATIONAL_ID_NUMBER'],
            ]);

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Duplicate prevented']);
        }

        // === Proceed to create user ===
        $plainPassword = Str::random(10);
        $data['PASSWORD_HASH'] = Hash::make($plainPassword);
        $data['must_change_password'] = $data['must_change_password'] ?? true;

        $year = now('Africa/Nairobi')->format('y');
        $idSuffix = substr($data['NATIONAL_ID_NUMBER'], -2);
        $count = User::count() + 1;
        $regNumber = str_pad($count, 4, '0', STR_PAD_LEFT);
        $membershipNumber = $year . $idSuffix . $regNumber;
        $data['MEMBERSHIP_NUMBER'] = $membershipNumber;

        // Move passport photo
        $finalRelativePhoto = null;
        if (!empty($pending->passport_photo_tmp)) {
            $tmpAbs = public_path($pending->passport_photo_tmp);
            if (file_exists($tmpAbs)) {
                $destDir = public_path('passport_photo');
                if (!is_dir($destDir)) mkdir($destDir, 0755, true);

                $fileName = basename($tmpAbs);
                $destAbs = $destDir . DIRECTORY_SEPARATOR . $fileName;
                @rename($tmpAbs, $destAbs);

                if (file_exists($destAbs)) $finalRelativePhoto = 'passport_photo/' . $fileName;
                $data['PASSPORT_PHOTO'] = $finalRelativePhoto;
            }
        }

        // QR code
        $qrDir = public_path('qrcodes');
        if (!is_dir($qrDir)) mkdir($qrDir, 0775, true);
        $qrPathRel = 'qrcodes/' . $membershipNumber . '.png';
        $qrUrl = route('verify.member', ['membership' => $membershipNumber]);
        QrCode::format('png')->size(200)->generate($qrUrl, public_path($qrPathRel));

        // Membership Card PDF
        $pdfDir = public_path('membership_cards');
        if (!is_dir($pdfDir)) mkdir($pdfDir, 0775, true);
        $pdfPath = $pdfDir . '/' . $membershipNumber . '.pdf';

        $photoPath = $finalRelativePhoto ? public_path($finalRelativePhoto) : '';
        $pdf = Pdf::loadView('pdf.membership_card', [
            'name' => $data['FIRST_NAME'],
            'email' => $data['EMAIL'],
            'membershipNumber' => $membershipNumber,
            'SCHOOL_NAME' => $data['SCHOOL_NAME'] ?? '',
            'photo' => (is_string($photoPath) && file_exists($photoPath))
                        ? $photoPath
                        : public_path('pictures/default.png'),
            'logo' => public_path('pictures/logo.jpg'),
            'qrCode' => public_path($qrPathRel),
        ]);
        $pdf->save($pdfPath);

        // Create user
        $user = User::create(array_merge($data, [
            'membership_expiry' => $paidAt->copy()->addYear()->toDateString(),
            'mpesa_receipt'     => $receipt,
            'amount_paid'       => $amount,
            'payment_date'      => $paidAt,
            'payment_status'    => 'successful',
        ]));

        // Update payment & cleanup pending registration
        DB::transaction(function() use ($payment, $pending, $user) {
            DB::table('mpesa_payments')->where('id', $payment->id ?? 0)->update([
                'user_id' => $user->ID ?? $user->id,
                'updated_at' => now(),
            ]);
            DB::table('pending_registrations')->where('id', $pending->id)->delete();
        });

        // Send credentials email
        Mail::to($user->EMAIL)->send(new MembershipCredentialsMail(
            $user->EMAIL,
            $plainPassword,
            $user->FIRST_NAME,
            $user->MEMBERSHIP_NUMBER,
            $user->PHONE_NUMBER,
            $pdfPath
        ));

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Registered Successfully']);
    }
}
