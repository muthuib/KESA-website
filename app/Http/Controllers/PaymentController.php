<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function renewMembership(Request $request)
    {
        $user   = $request->user();
        $amount = (int) env('MPESA_RENEWAL_AMOUNT', 1000);
        $phone  = $this->normalizeMsisdn($user->phone ?? $user->phone_number ?? '');

        // callback URL must be absolute and accessible by Safaricom (ngrok)
        $callbackURL = route('stk.callback', [], true);

        $resp = $this->stkPush($phone, $amount, $user->id, $callbackURL);

        // Safaricom returns ResponseCode 0 on success
        $responseCode = $resp['ResponseCode'] ?? $resp['responseCode'] ?? null;

        if ($responseCode == 0 || $responseCode === "0") {
            Payment::create([
                'user_id' => $user->id,
                'amount'  => $amount,
                'phone_number' => $phone,
                'purpose' => 'renewal',
                'status'  => 'pending',
                'merchant_request_id' => $resp['MerchantRequestID'] ?? null,
                'checkout_request_id' => $resp['CheckoutRequestID'] ?? null,
            ]);

            return back()->with('success', 'STK Push sent. Enter your M-Pesa PIN to complete payment.');
        }

        Log::warning('STK push failed', ['response' => $resp]);

        return back()->with('error', 'STK Push failed. Please try again.');
    }

    private function stkPush(string $phone, int $amount, int $accountRef, string $callbackURL): array
    {
        $base      = rtrim(env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'), '/');
        $shortcode = env('MPESA_SHORTCODE');
        $passkey   = env('MPESA_PASSKEY');
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode($shortcode . $passkey . $timestamp);

        $payload = [
            "BusinessShortCode" => $shortcode,
            "Password"          => $password,
            "Timestamp"         => $timestamp,
            "TransactionType"   => "CustomerPayBillOnline",
            "Amount"            => $amount,
            "PartyA"            => $phone,
            "PartyB"            => $shortcode,
            "PhoneNumber"       => $phone,
            "CallBackURL"       => $callbackURL,
            "AccountReference"  => (string)$accountRef,
            "TransactionDesc"   => "Membership Renewal",
        ];

        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->acceptJson()
            ->post($base . '/mpesa/stkpush/v1/processrequest', $payload);

        return $response->json() ?? [];
    }

    public function stkCallback(Request $request)
    {
        // Log raw payload for debugging
        Log::info('STK Callback raw:', $request->all());

        $body = $request->input('Body.stkCallback', []);
        $resultCode = $body['ResultCode'] ?? null;
        $checkoutId = $body['CheckoutRequestID'] ?? null;

        // Find pending payment by checkout_request_id OR by MerchantRequestID
        $payment = null;
        if ($checkoutId) {
            $payment = Payment::where('checkout_request_id', $checkoutId)->latest()->first();
        }

        if (!$payment && isset($body['MerchantRequestID'])) {
            $payment = Payment::where('merchant_request_id', $body['MerchantRequestID'])->latest()->first();
        }

        // If still not found you'll want to log and return success to avoid retries
        if (!$payment) {
            Log::warning('Payment match not found for STK callback', ['checkoutId'=>$checkoutId, 'body' => $body]);
            return response()->json(['ResultCode'=>0, 'ResultDesc'=>'Processed']);
        }

        // save raw payload
        $payment->raw_callback = $request->all();

        if ((int)$resultCode === 0) {
            // Build metadata map by Name => Value for robust parsing
            $items = collect($body['CallbackMetadata']['Item'] ?? [])
                ->mapWithKeys(fn($i) => [($i['Name'] ?? '') => ($i['Value'] ?? null)]);

            $payment->status = 'success';
            $payment->mpesa_receipt_number = $items['MpesaReceiptNumber'] ?? $items['ReceiptNumber'] ?? null;

            if (!empty($items['TransactionDate'])) {
                // Daraja transaction date usually YYYYMMDDHHMMSS
                try {
                    $payment->transaction_date = Carbon::createFromFormat('YmdHis', (string)$items['TransactionDate']);
                } catch (\Exception $e) {
                    Log::warning('TransactionDate parse failed', ['val'=>$items['TransactionDate']]);
                }
            }

            $payment->save();

            // Extend membership by 1 year
            $user = $payment->user;
            if ($user) {
                $currentExpiry = $user->membership_expiry ? Carbon::parse($user->membership_expiry) : now();
                $newExpiry = $currentExpiry->greaterThan(now()) ? $currentExpiry->copy()->addYear() : now()->addYear();
                $user->update(['membership_expiry' => $newExpiry]);
            }
        } else {
            // Failed or cancelled
            $payment->status = 'failed';
            $payment->save();
            Log::warning('STK push returned non-zero result', ['code'=>$resultCode, 'desc'=>$body['ResultDesc'] ?? null]);
        }

        return response()->json(['ResultCode'=>0, 'ResultDesc'=>'Processed']);
    }

    private function getAccessToken(): string
    {
        $base   = rtrim(env('MPESA_BASE_URL', 'https://sandbox.safaricom.co.ke'), '/');
        $key    = env('MPESA_CONSUMER_KEY');
        $secret = env('MPESA_CONSUMER_SECRET');

        $resp = Http::withBasicAuth($key, $secret)
            ->acceptJson()
            ->get($base.'/oauth/v1/generate?grant_type=client_credentials');

        return $resp->json()['access_token'] ?? '';
    }

    private function normalizeMsisdn(?string $raw): string
    {
        $raw = preg_replace('/\D+/', '', (string)$raw);
        if (str_starts_with($raw, '0')) return '254' . substr($raw, 1);
        if (str_starts_with($raw, '254')) return $raw;
        if (str_starts_with($raw, '7')) return '254' . $raw;
        return $raw;
    }
}
