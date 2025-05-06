<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'position', 'content', 'photo', 'date'];

    protected $casts = [
        'date' => 'date',
    ];
}


