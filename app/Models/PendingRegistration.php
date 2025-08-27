<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    protected $table = 'pending_registrations';

    protected $fillable = [
        'data',
        'passport_photo_tmp',
        'phone',
        'amount',
        'merchant_request_id',
        'checkout_request_id',
    ];
}
