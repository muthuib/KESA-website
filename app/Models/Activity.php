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
        'media1',
        'media2',
        'media3',
        'youtube_link',
        'description',
    ];
}
