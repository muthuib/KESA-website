<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Add the new fields to the $fillable array
    protected $fillable = [
        'name',
        'location',
        'venue',
        'description',
        'start_date',
        'end_date',
        'start_time', // New field
        'end_time',   // New field
        'image',      // New field
    ];

    // Relationship with the Registration model
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
