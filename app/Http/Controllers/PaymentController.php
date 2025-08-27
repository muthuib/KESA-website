<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;


class PaymentController extends Controller
{
    /**
     * Trigger STK push for membership renewal
     */
    public function renewMembership(Request $request)
    {
        $user = auth()->user();
        $phone = $user->phone;  // user’s registered phone
        $amount = 1000; // renewal fee (example)

        // Generate STK push
        $response = $this->stkPush($phone, $amount, $user->id);

        if ($response['ResponseCode'] == "0") {
            // Save renewal attempt in DB
            Payment::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'mpesa_receipt' => null,
                'payment_status' => 'pending',
                'payment_date' => now(),
                'purpose' => 'renewal',
            ]);

            return back()->with('success', 'STK Push sent to your phone. Please enter your PIN to complete payment.');
        }

        return back()->with('error', 'STK Push failed. Try again.');
    }

    /**
     * STK Push Implementation
     */
    private function stkPush($phone, $amount, $userId)
    {
        $shortcode = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $lipaNaMpesaOnlineShortcode = $shortcode;
        $timestamp = date('YmdHis');
        $password = base64_encode($shortcode.$passkey.$timestamp);

        $callbackURL = route('stk.callback'); // Our callback URL

        $payload = [
            "BusinessShortCode" => $lipaNaMpesaOnlineShortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => $shortcode,
            "PhoneNumber" => $phone,
            "CallBackURL" => $callbackURL,
            "AccountReference" => $userId, // link payment to user
            "TransactionDesc" => "Membership Renewal"
        ];

        // Get access token
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

        return $response->json();
    }

    /**
     * STK Callback (Safaricom will call this after payment)
     */
    public function stkCallback(Request $request)
    {
        $data = $request->all();

        if (isset($data['Body']['stkCallback']['ResultCode']) && $data['Body']['stkCallback']['ResultCode'] == 0) {
            $callback = $data['Body']['stkCallback']['CallbackMetadata']['Item'];

            $mpesaReceipt = $callback[1]['Value']; // Receipt number
            $amount = $callback[0]['Value'];
            $phone = $callback[4]['Value'];
            $userId = $data['Body']['stkCallback']['MerchantRequestID'] ?? null;

            // Find last pending payment for this user
            $payment = Payment::where('payment_status', 'pending')
                              ->where('amount', $amount)
                              ->latest()
                              ->first();

            if ($payment) {
                $payment->update([
                    'mpesa_receipt' => $mpesaReceipt,
                    'payment_status' => 'successful',
                    'payment_date' => now(),
                ]);

                // Extend membership by 1 year
                $user = $payment->user;
                $currentExpiry = $user->membership_expiry ?? Carbon::now();
                $newExpiry = Carbon::parse($currentExpiry)->greaterThan(now())
                              ? Carbon::parse($currentExpiry)->addYear()
                              : now()->addYear();

                $user->update(['membership_expiry' => $newExpiry]);
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }

    private function getAccessToken()
    {
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        return $response->json()['access_token'];
    }
}
