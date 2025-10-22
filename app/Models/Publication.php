<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'authors',
        'file_size',
        'downloads',
        'cover_image',
    ];

    /**
     * Automatically generate a clean, URL-safe slug
     * every time a publication is created or updated.
     */
    protected static function booted()
    {
        static::creating(function ($publication) {
            if (empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
            } else {
                // Clean any manually entered slug
                $publication->slug = Str::slug($publication->slug);
            }
        });

        static::updating(function ($publication) {
            if (empty($publication->slug)) {
                $publication->slug = Str::slug($publication->title);
            } else {
                $publication->slug = Str::slug($publication->slug);
            }
        });
    }
}
