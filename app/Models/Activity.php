<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'activity_title',
        'name',
        'location',
        'date',
        'start_time',
        'end_time',
        'media',
        'youtube_link',
        'description'
    ];
}
