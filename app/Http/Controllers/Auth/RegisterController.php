<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\services\MpesaService;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
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
            'type' => 'required|in:student,full,associate',
            'must_change_password' => 'required|boolean',
        ]);

        // Normalize phone to 2547XXXXXXXX
        $phone = preg_replace('/\s+/', '', $validated['PHONE_NUMBER']);
        if (str_starts_with($phone, '0')) $phone = '254' . substr($phone, 1);
        if (str_starts_with($phone, '+')) $phone = ltrim($phone, '+');
        $validated['PHONE_NUMBER'] = $phone;

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
        $stk = $mpesa->stkPush($validated['PHONE_NUMBER'], $amount, $accountRef, 'Membership Registration');

        if (!isset($stk['ResponseCode']) || $stk['ResponseCode'] !== '0') {
            if ($tmpRelPath && file_exists(public_path($tmpRelPath))) @unlink(public_path($tmpRelPath));
            return back()->with('error', 'M-Pesa Error: ' . json_encode($stk));
        }

        // Save pending registration & payment
        DB::transaction(function () use ($validated, $tmpRelPath, $amount, $stk, $accountRef) {
            $pendingId = DB::table('pending_registrations')->insertGetId([
                'data' => json_encode($validated),
                'passport_photo_tmp' => $tmpRelPath,
                'phone' => $validated['PHONE_NUMBER'],
                'amount' => $amount,
                'merchant_request_id' => $stk['MerchantRequestID'] ?? null,
                'checkout_request_id' => $stk['CheckoutRequestID'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mpesa_payments')->insert([
                'phone' => $validated['PHONE_NUMBER'],
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
}
