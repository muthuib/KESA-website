<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'phone', 'amount', 'mpesa_receipt', 'status'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}

