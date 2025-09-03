<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\MpesaService;
use App\Models\MpesaPayment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Initiate membership renewal via M-Pesa STK Push
     */
    public function renewMembership(Request $request, MpesaService $mpesa)
    {
        try {
            $request->validate([
                'phone' => 'required|digits_between:10,12',
                'email' => 'required|email',
            ]);

            $phone = $this->normalizePhone($request->phone);
            $email = $request->email;

            if (!$phone) {
                return back()->with('error', 'Invalid phone number. Use format 2547XXXXXXXX.');
            }

            $user = User::where('EMAIL', $email)->first();
            if (!$user) {
                return back()->with('error', 'No account found for this email. Please register first.');
            }

            $amount = config('kesa.renewal_fee', 1);
            $accountRef = 'RENEW-' . now('UTC')->format('YmdHis');

            Log::info('Initiating STK push for renewal', [
                'user_id' => $user->ID,
                'email'   => $email,
                'phone'   => $phone,
                'amount'  => $amount
            ]);

            $stk = $mpesa->stkPush($phone, (float)$amount, $accountRef, 'Membership Renewal');

            if (!isset($stk['ResponseCode']) || $stk['ResponseCode'] !== '0') {
                Log::error('STK initiate failed', ['phone' => $phone, 'response' => $stk]);
                return back()->with('error', 'Failed to initiate M-Pesa payment. Please try again.');
            }

            MpesaPayment::create([
                'user_id'             => $user->ID,
                'phone'               => $phone,
                'email'               => $email,
                'amount'              => $amount,
                'account_reference'   => $accountRef,
                'description'         => 'Membership Renewal',
                'merchant_request_id' => $stk['MerchantRequestID'] ?? null,
                'checkout_request_id' => $stk['CheckoutRequestID'] ?? null,
                'status'              => 'pending',
                'purpose'             => 'renewal',
            ]);

            return back()->with('success', 'Payment request sent! Check your phone and enter your M-Pesa PIN to complete the renewal.');

        } catch (\Exception $e) {
            Log::error('Renew membership error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'An error occurred while processing your request. Please try again.');
        }
    }

    /**
     * Handle M-Pesa STK Push callback
     */
    public function stkCallback(Request $request)
    {
        DB::beginTransaction();

        try {
            $payload = $request->all();
            Log::info('MPESA Callback Received', $payload);

            $cb = data_get($payload, 'Body.stkCallback', []);
            $resultCode = (int) data_get($cb, 'ResultCode', -1);
            $checkoutId = data_get($cb, 'CheckoutRequestID');
            $merchantRequestId = data_get($cb, 'MerchantRequestID');

            $items = data_get($cb, 'CallbackMetadata.Item', []);
            $meta = collect($items)->mapWithKeys(fn($i) => [($i['Name'] ?? '') => ($i['Value'] ?? null)]);

            $receipt = $meta->get('MpesaReceiptNumber');
            $txnDate = $meta->get('TransactionDate');
            $paidAt = $txnDate
                ? Carbon::createFromFormat('YmdHis', $txnDate, 'Africa/Nairobi')->setTimezone('UTC')
                : now('UTC');

            // Find the payment
            $payment = MpesaPayment::where('checkout_request_id', $checkoutId)
                ->orWhere('merchant_request_id', $merchantRequestId)
                ->latest()
                ->first();

            if (!$payment) {
                Log::error('Payment not found in callback', [
                    'checkoutId'        => $checkoutId,
                    'merchantRequestId' => $merchantRequestId
                ]);
                DB::rollBack();
                return response()->json([
                    'ResultCode' => 1,
                    'ResultDesc' => 'Payment record not found'
                ]);
            }

            if ($payment->status === 'successful') {
                DB::commit();
                return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Already processed']);
            }

            // Update payment record
            $payment->result_code          = $resultCode;
            $payment->result_desc          = data_get($cb, 'ResultDesc');
            $payment->mpesa_receipt_number = $receipt;
            $payment->transaction_date     = $paidAt;
            $payment->callback_metadata    = $meta->toArray();
            $payment->status               = $resultCode === 0 ? 'successful' : 'failed';
            $payment->processed_at         = now('UTC');
            $payment->save();

            if ($resultCode !== 0) {
                DB::commit();
                return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Payment failed recorded']);
            }

            // Process successful payment - Extend membership
            $user = User::find($payment->user_id);

            if (!$user) {
                DB::rollBack();
                return response()->json([
                    'ResultCode' => 1,
                    'ResultDesc' => 'User account not found'
                ]);
            }

            $currentExpiry = $user->membership_expiry
                ? Carbon::parse($user->membership_expiry)
                : now('UTC');

            $newExpiry = $currentExpiry->greaterThan(now('UTC'))
                ? $currentExpiry->copy()->addYear()
                : now('UTC')->addYear();

            $user->update([
                'membership_expiry' => $newExpiry,
                'payment_status'    => 'successful',
                'mpesa_receipt'     => $receipt,
                'amount_paid'       => $payment->amount,
                'payment_date'      => $paidAt,
            ]);

            DB::commit();
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('STK Callback Error: ' . $e->getMessage(), [
                'trace'   => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'System error processing payment'
            ]);
        }
    }

    /**
     * Batch process unprocessed renewals
     */
    public function processRenewals()
    {
        try {
            $payments = MpesaPayment::where('purpose', 'renewal')
                ->where('status', 'successful')
                ->whereNull('processed_at')
                ->get();

            foreach ($payments as $payment) {
                $user = User::find($payment->user_id);

                if ($user) {
                    $currentExpiry = $user->membership_expiry
                        ? Carbon::parse($user->membership_expiry)
                        : now('UTC');

                    $newExpiry = $currentExpiry->greaterThan(now('UTC'))
                        ? $currentExpiry->copy()->addYear()
                        : now('UTC')->addYear();

                    $user->update([
                        'membership_expiry' => $newExpiry,
                        'payment_status'    => 'successful',
                        'mpesa_receipt'     => $payment->mpesa_receipt_number,
                        'amount_paid'       => $payment->amount,
                        'payment_date'      => $payment->transaction_date,
                    ]);

                    $payment->update(['processed_at' => now('UTC')]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($payments) . ' renewals processed successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing renewals: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Normalize phone number to 254XXXXXXXXX format
     */
    private function normalizePhone($p)
    {
        if (!$p) return null;
        $p = preg_replace('/\D+/', '', (string)$p);
        if (str_starts_with($p, '0')) return '254' . substr($p, 1);
        if (str_starts_with($p, '7')) return '254' . $p;
        if (str_starts_with($p, '254')) return $p;
        if (str_starts_with($p, '+')) return ltrim($p, '+');
        return $p;
    }
}
