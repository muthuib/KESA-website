<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveEvent extends Model
{
    use HasFactory;
    protected $table = 'live_events';

    protected $fillable = ['title', 'platform', 'link', 'date_time'];

     // Specify that your table uses timestamps (created_at and updated_at)
     public $timestamps = true;
}

