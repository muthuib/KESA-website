<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MpesaPayment extends Model
{
    use HasFactory;

    protected $table = 'mpesa_payments';

    protected $fillable = [
        'user_id',
        'phone',
        'email',
        'amount',
        'account_reference',
        'description',
        'merchant_request_id',
        'checkout_request_id',
        'result_code',
        'result_desc',
        'mpesa_receipt_number',
        'transaction_date',
        'callback_metadata',
        'status',
        'purpose',
        'processed_at',
        'pending_registration_id',
    ];

    protected $casts = [
        'callback_metadata' => 'array',
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
        'processed_at'      => 'datetime',
    ];

   public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'ID');
    }

}
