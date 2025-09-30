<?php

namespace App\services; // Uppercase App, lowercase services

use Illuminate\Support\Facades\Http;

class MpesaService
{
    protected string $base;

    public function __construct()
    {
        $this->base = config('mpesa.env') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    protected function accessToken(): string
    {
        // Debug env values
    // dd(config('mpesa.consumer_key'), config('mpesa.consumer_secret'));
        $res = Http::withBasicAuth(
            config('mpesa.consumer_key'),
            config('mpesa.consumer_secret')
        )->get("{$this->base}/oauth/v1/generate?grant_type=client_credentials");

        return $res->json('access_token');
    }

    public function stkPush(string $phone, float $amount, string $accountRef, string $desc): array
    {
        $timestamp = now('Africa/Nairobi')->format('YmdHis');
        $password = base64_encode(config('mpesa.shortcode') . config('mpesa.passkey') . $timestamp);

        $payload = [
            "BusinessShortCode" => config('mpesa.shortcode'),
            "Password"          => $password,
            "Timestamp"         => $timestamp,
            "TransactionType"   => "CustomerPayBillOnline",
            "Amount"            => (int)$amount,
            "PartyA"            => $phone,
            "PartyB"            => config('mpesa.shortcode'),
            "PhoneNumber"       => $phone,
            "CallBackURL"       => config('mpesa.callback_url'),
            "AccountReference"  => $accountRef,
            "TransactionDesc"   => $desc,
        ];

        $res = Http::withToken($this->accessToken())
            ->post("{$this->base}/mpesa/stkpush/v1/processrequest", $payload);

        return $res->json();
    }
    
}
