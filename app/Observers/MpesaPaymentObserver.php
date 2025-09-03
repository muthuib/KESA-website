<?php

namespace App\Observers;

use App\Models\MpesaPayment;
use App\Models\User;
use Carbon\Carbon;

class MpesaPaymentObserver
{
    public function updated(MpesaPayment $payment)
    {
        if ($payment->status === 'successful' && $payment->purpose === 'renewal') {
            $user = $payment->user;
            if ($user) {
                $expiryMinutes = config('kesa.membership_expiry_minutes', 1440);

                $currentExpiry = $user->membership_expiry
                    ? Carbon::parse($user->membership_expiry)
                    : now('UTC');

                $newExpiry = $currentExpiry->greaterThan(now('UTC'))
                    ? $currentExpiry->copy()->addMinutes($expiryMinutes)
                    : now('UTC')->addMinutes($expiryMinutes);

                $user->membership_expiry = $newExpiry;
                $user->payment_status    = 'successful';
                $user->mpesa_receipt     = $payment->mpesa_receipt_number;
                $user->amount_paid       = $payment->amount;
                $user->payment_date      = $payment->transaction_date ?? now('UTC');
                $user->save();
            }
        }
    }
}
