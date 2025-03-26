<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';
    protected $primaryKey = 'ID'; // Ensure this matches your actual database primary key

    protected $fillable = [
        'NAME',
        'LOGO_PATH',
        'DESCRIPTION',
        'WEBSITE',
    ];
}
