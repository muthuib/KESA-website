<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function initiatePayment(Request $request)
    {
        try {
            // Validate the request inputs
            $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'phone' => 'required|regex:/^2547\d{8}$/',
            ]);
    
            // Retrieve the ticket and round the price to an integer
            $ticket = Ticket::find($request->ticket_id);
            $amount = (int) round($ticket->price);
    
            // Get the access token
            $accessToken = $this->getAccessToken();
    
            if (!$accessToken) {
                return redirect()->route('payment.error')->with('error', 'Safaricom servers are down, please try again later.');
            }
    
            // Proceed with STK Push using the integer amount
            $response = $this->stkPush($accessToken, $request->phone, $amount, $ticket->id);
    
            // Redirect to the payment success view with response data
            return view('payment.success', [
                'message' => 'Payment initiated successfully',
                'response' => $response
            ]);
        } catch (\Exception $e) {
            return redirect()->route('payment.error')->with('error', $e->getMessage());
        }
    }
    

    private function stkPush($accessToken, $phone, $amount, $transactionId)
    {
        $timestamp = now()->format('YmdHis');
        $password = base64_encode('174379' . 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919' . $timestamp); // Replace shortcode and passkey directly
    
        // Convert or format amount to an integer
       $amount = (int) round($amount);

        $response = Http::withToken($accessToken)->post(
            'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
            [
                'BusinessShortCode' => '174379', // Your M-Pesa Business Shortcode
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => '174379', // M-Pesa Business Shortcode
                'PhoneNumber' => $phone,
                'CallBackURL' => 'https://prototype-pms.000webhostapp.com/api/mpesa/callback', // Replace with your actual callback URL,
                'AccountReference' => $transactionId,
                'TransactionDesc' => 'Event Ticket Purchase',
            ]
        );
    
        return $response->json();
    }
    

    private function getAccessToken()
    {
        $consumerKey = 'mAEp5BmBSX3VgmS8CLLQbsNeqjf80LV1pGaDhbEFLnRrFiK9'; // Replace with actual consumer key
        $consumerSecret = 'TqLuovFutfjxrGVeui9bRXB3BpDHPJGolDrWQTeS9SXQWelvUseF64UiNicA0O3q'; // Replace with actual consumer secret
    
        if (!$consumerKey || !$consumerSecret) {
            Log::error('M-Pesa Consumer Key or Secret is missing.');
            throw new \Exception('M-Pesa Consumer Key or Secret is not configured.');
        }
    
        try {
            $response = Http::withBasicAuth($consumerKey, $consumerSecret)
                ->timeout(120) // Increase timeout to 120 seconds
                ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    
            if (!$response->successful()) {
                Log::error('Failed to generate access token: ' . $response->body());
                throw new \Exception('Failed to generate M-Pesa access token.');
            }
    
            return $response->json()['access_token'];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('RequestException: ' . $e->getMessage());
    
            if (str_contains($e->getMessage(), 'cURL error 28')) {
                throw new \Exception('Change your network connection and try again.');
            }
    
            throw new \Exception('An error occurred while generating the M-Pesa access token.');
        }
    }
    
    public function handleCallback(Request $request)
    {
        $data = $request->all();
    
        try {
            $resultCode = $data['Body']['stkCallback']['ResultCode'];
            $transactionId = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $mpesaReceipt = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    
            // Find the corresponding transaction
            $transaction = Transaction::where('id', $transactionId)->first();
    
            if (!$transaction) {
                Log::error("Transaction not found: {$transactionId}");
                return response()->json(['error' => 'Transaction not found'], 404);
            }
    
            if ($resultCode == 0) {
                // Update transaction as successful
                $transaction->update([
                    'status' => 'completed',
                    'mpesa_receipt' => $mpesaReceipt,
                ]);
    
                // Optional: Update related ticket or notify the user
                Ticket::where('id', $transaction->ticket_id)->update(['status' => 'paid']);
            } else {
                // Update transaction as failed
                $transaction->update(['status' => 'failed']);
            }
    
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error("Error handling M-Pesa callback: " . $e->getMessage());
            return response()->json(['error' => 'Callback handling failed'], 500);
        }
    }
    

}
