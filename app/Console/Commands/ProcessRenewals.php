<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MpesaPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessRenewals extends Command
{
    protected $signature = 'renewals:process';
    protected $description = 'Process successful M-Pesa renewals and update membership_expiry in users table';

    public function handle()
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

                    Log::info("Renewal processed for user {$user->EMAIL}");
                }
            }

            $this->info(count($payments) . ' renewals processed successfully.');

        } catch (\Exception $e) {
            Log::error('Error in ProcessRenewals command: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
