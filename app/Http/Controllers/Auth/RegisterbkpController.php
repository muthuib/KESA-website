<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\services\MpesaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Normalize Kenyan phone number to 2547XXXXXXXX
     */
 private function normalizePhone(?string $phone): ?string
    {
        if (!$phone) return null;

        // keep digits only
        $digits = preg_replace('/\D/', '', $phone);

        if (strlen($digits) === 10 && $digits[0] === '0') {
            // 07XXXXXXXX or 01XXXXXXXX → 2547XXXXXXXX / 2541XXXXXXXX
            return '254' . substr($digits, 1);
        } elseif (strlen($digits) === 9 && in_array($digits[0], ['7', '1'])) {
            // 7XXXXXXXX or 1XXXXXXXX → 2547XXXXXXXX / 2541XXXXXXXX
            return '254' . $digits;
        } elseif (strlen($digits) === 12 && substr($digits, 0, 3) === '254') {
            // Already normalized (2547XXXXXXXX or 2541XXXXXXXX)
            return $digits;
        }

        return null; // invalid format
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request, MpesaService $mpesa)
    {
        // Validate request
        $validated = $request->validate([
            'FIRST_NAME' => 'required|string|max:255',
            'LAST_NAME' => 'nullable|string|max:255',
            'EMAIL' => 'required|email|unique:users,EMAIL',
            'GENDER' => 'required|in:Male,Female,Other',
            'PHONE_NUMBER' => 'required|string|max:20|unique:users,PHONE_NUMBER',
            'ALTERNATIVE_PHONE_NUMBER' => 'required|string|max:20',
            'NATIONAL_ID_NUMBER' => 'required|string|max:50|unique:users,NATIONAL_ID_NUMBER',
            'DISABILITY_STATUS' => 'required|in:Yes,No',
            'DISABILITY_TYPE' => 'nullable|string|required_if:DISABILITY_STATUS,Yes',
            'HIGHEST_LEVEL_SCHOOL_ATTENDING' => 'nullable|required_if:CURRENTLY_IN_SCHOOL,Yes|in:TVET,College,University',
            'SCHOOL_NAME' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'PROGRAM_OF_STUDY' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'SCHOOL_REGISTRATION_NUMBER' => 'nullable|string|required_if:CURRENTLY_IN_SCHOOL,Yes',
            'HIGHEST_LEVEL_SCHOOL_ATTENDED' => 'nullable|in:TVET,College,University',
            'EDUCATION_LEVEL' => 'nullable|in:Undergraduate Degree,Post Graduate Diploma,Masters Degree,PhD',
            'PREVIOUS_SCHOOL_NAME' => 'nullable|string',
            'PREVIOUS_PROGRAM_OF_STUDY' => 'nullable|string',
            'REGISTRATION_FEE' => 'required|string|min:1',
            'PASSPORT_PHOTO' => 'required|image|mimes:jpeg,png,jpg|max:2048',

            // Newly added fields
            'TITTLE' => 'nullable|string|max:255',
            'POSTAL_ADDRESS' => 'nullable|string|max:255',
            'PHYSICAL_ADDRESS' => 'nullable|string|max:255',
            'COUNTY' => 'nullable|string|max:255',
            'LINKEDIN' => 'nullable|string|max:255',
            'PROFESSION' => 'nullable|string|max:255',
            'WORK_PLACE' => 'nullable|string|max:255',
            'JOB' => 'nullable|string|max:255',
            'COMMENT' => 'nullable|string',
            'DATE' => 'nullable|date',
            'role_id' => 'required|exists:roles,id',
            'must_change_password' => 'required|boolean',
        ]);

        // Normalize phone to 2547XXXXXXXX
        // Normalize phone numbers
        $validated['PHONE_NUMBER'] = $this->normalizePhone($validated['PHONE_NUMBER']);
        $validated['ALTERNATIVE_PHONE_NUMBER'] = $this->normalizePhone($validated['ALTERNATIVE_PHONE_NUMBER']);

        if (!$validated['PHONE_NUMBER'] || !$validated['ALTERNATIVE_PHONE_NUMBER']) {
            return back()->with('error', 'Invalid phone number format. Use 07XXXXXXXX or 2547XXXXXXXX.');
        }

        // Store photo temporarily in public/tmp
        $tmpRelPath = null;
        if ($request->hasFile('PASSPORT_PHOTO')) {
            $file = $request->file('PASSPORT_PHOTO');
            $tmpDir = public_path('tmp');
            if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

            $name = time() . '_' .
                Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . 
                '.' . $file->getClientOriginalExtension();

            $file->move($tmpDir, $name);
            $tmpRelPath = 'tmp/' . $name;
        }

        $amount = (float)$validated['REGISTRATION_FEE'];
        $accountRef = 'KESA-' . now('Africa/Nairobi')->format('YmdHis');

        // Send STK push
        $stk = $mpesa->stkPush($validated['ALTERNATIVE_PHONE_NUMBER'], $amount, $accountRef, 'Membership Registration');

        if (!isset($stk['ResponseCode']) || $stk['ResponseCode'] !== '0') {
            if ($tmpRelPath && file_exists(public_path($tmpRelPath))) @unlink(public_path($tmpRelPath));
            return back()->with('error', 'M-Pesa Error: ' . json_encode($stk));
        }

        // Save pending registration & payment
        DB::transaction(function () use ($validated, $tmpRelPath, $amount, $stk, $accountRef) {
            $pendingId = DB::table('pending_registrations')->insertGetId([
                'data' => json_encode($validated),
                'passport_photo_tmp' => $tmpRelPath,
                'phone' => $validated['ALTERNATIVE_PHONE_NUMBER'],
                'amount' => $amount,
                'merchant_request_id' => $stk['MerchantRequestID'] ?? null,
                'checkout_request_id' => $stk['CheckoutRequestID'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mpesa_payments')->insert([
                'phone' => $validated['ALTERNATIVE_PHONE_NUMBER'],
                'amount' => $amount,
                'account_reference' => $accountRef,
                'description' => 'Membership Registration',
                'merchant_request_id' => $stk['MerchantRequestID'] ?? null,
                'checkout_request_id' => $stk['CheckoutRequestID'] ?? null,
                'status' => 'pending',
                'pending_registration_id' => $pendingId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'STK push sent. Enter your M-Pesa PIN to complete payment.');
    }


public function checkUserExists(Request $request)
{
    try {
        Log::info('checkUserExists raw request:', ['input' => $request->all()]);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'EMAIL' => 'required|email|max:255',
            'PHONE_NUMBER' => 'required|string|min:9|max:15',
            'NATIONAL_ID_NUMBER' => 'required|string|min:7|max:50',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed in checkUserExists:', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return response()->json([
                'exists' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => 'Validation failed'
            ], 422);
        }

        // Extract & normalize
        $email = trim(strtolower($request->input('EMAIL')));
        $phone_number = $this->normalizePhone($request->input('PHONE_NUMBER'));
        $national_id_number = trim($request->input('NATIONAL_ID_NUMBER'));

        if (!$phone_number) {
            return response()->json([
                'exists' => false,
                'message' => 'Invalid phone number format. Use 07XXXXXXXX, 01XXXXXXXX, or 254XXXXXXXXX.'
            ], 422);
        }

        Log::info('Normalized inputs:', [
            'EMAIL' => $email,
            'PHONE_NUMBER' => $phone_number,
            'NATIONAL_ID_NUMBER' => $national_id_number,
        ]);

        // Check for duplicates
        $existingUser = User::whereRaw('LOWER(EMAIL) = ?', [$email])
            ->orWhere('NATIONAL_ID_NUMBER', $national_id_number)
            ->orWhereRaw('REGEXP_REPLACE(PHONE_NUMBER, "[^0-9]", "") = ?', [$phone_number])
            ->first();

        if ($existingUser) {
            $field = null;

            if (strtolower($existingUser->EMAIL) === $email) {
                $field = 'EMAIL';
            } elseif ($existingUser->NATIONAL_ID_NUMBER === $national_id_number) {
                $field = 'NATIONAL_ID_NUMBER';
            } else {
                $dbPhoneNormalized = $this->normalizePhone($existingUser->PHONE_NUMBER);
                if ($dbPhoneNormalized === $phone_number) {
                    $field = 'PHONE_NUMBER';
                }
            }

            if ($field) {
                Log::info('Duplicate found in users:', [
                    'field' => $field,
                    'value' => $existingUser->$field,
                    'input_value' => $request->input($field)
                ]);

                return response()->json([
                    'exists' => true,
                    'field' => $field,
                    'message' => "The provided {$field} already exists."
                ], 409);
            }
        }

        Log::info('No duplicates found in users.');
        return response()->json(['exists' => false], 200);

    } catch (\Exception $e) {
        Log::error('Error in checkUserExists:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        return response()->json([
            'exists' => false,
            'message' => 'Server error occurred while checking duplicates.'
        ], 500);
    }
}

}
