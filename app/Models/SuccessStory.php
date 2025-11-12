<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuccessStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'title', 'slug', 'excerpt', 'body', 'author', 'language',
        'visibility', 'status', 'is_featured', 'is_pinned', 'published_at',
        'cover_image', 'seo_title', 'seo_description', 'meta', 'tags_cached'
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
   
protected static function booted()
    {
        static::creating(function ($story) {
            $story->uuid = Str::uuid();
            $story->slug = static::generateUniqueSlug($story->title);
        });

        static::updating(function ($story) {
            $story->slug = static::generateUniqueSlug($story->title, $story->id);
        });
    }

    /**
     * Generate unique slug
     */
    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
