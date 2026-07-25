<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GalleryPhoto extends Model
{
    protected $table = "gallery_photos";

    protected $fillable = [
        'event_id',
        'title',
        'original_name',
        'file_name',
        'slug',
        'extension',
        'mime_type',
        'file_size',
        'width',
        'height',
        'original_path',
        'thumbnail_path',
        'small_path',
        'medium_path',
        'large_path',
        'uploaded_by',
        'downloads'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($photo) {
            if (empty($photo->slug)) {
                $photo->slug = static::generateUniqueSlug($photo->title ?? $photo->original_name);
            }
        });

        static::updating(function ($photo) {
            if ($photo->isDirty('title') && empty($photo->slug)) {
                $photo->slug = static::generateUniqueSlug($photo->title);
            }
        });
    }

    /**
     * Generate a unique slug
     */
    protected static function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug . '-' . Str::random(6);
        
        // Ensure uniqueness
        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::random(6);
        }
        
        return $slug;
    }

    /**
     * Get the event that owns the photo
     */
    public function event()
    {
        return $this->belongsTo(GalleryEvent::class, 'event_id');
    }

    /**
     * Get the user who uploaded the photo
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the best available image URL
     */
    public function getImageUrl($preferred = 'medium')
    {
        $paths = [
            'thumbnail' => $this->thumbnail_path,
            'small' => $this->small_path,
            'medium' => $this->medium_path,
            'large' => $this->large_path,
            'original' => $this->original_path,
        ];

        // Try the preferred size first
        if (isset($paths[$preferred]) && File::exists(public_path($paths[$preferred]))) {
            return asset($paths[$preferred]);
        }

        // Try all other sizes in order
        $order = ['small', 'medium', 'large', 'thumbnail', 'original'];
        foreach ($order as $size) {
            if (isset($paths[$size]) && $paths[$size] && File::exists(public_path($paths[$size]))) {
                return asset($paths[$size]);
            }
        }

        // Return fallback
        return asset('images/no-image.jpg');
    }

    /**
     * Check if image exists for a specific size
     */
    public function imageExists($size = 'small')
    {
        $path = $this->{$size . '_path'};
        return $path && File::exists(public_path($path));
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes < 1024) {
            return $bytes . ' Bytes';
        } elseif ($bytes < 1024 * 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes < 1024 * 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), 2) . ' MB';
        } else {
            return number_format($bytes / (1024 * 1024 * 1024), 2) . ' GB';
        }
    }

    /**
     * Get the download URL for a specific size
     */
    public function getDownloadUrl($size = 'original')
    {
        return route('gallery.download', [$this->slug, $size]);
    }

    /**
     * Get all download URLs for different sizes
     */
    public function getDownloadUrlsAttribute()
    {
        $sizes = ['thumbnail', 'small', 'medium', 'large', 'original'];
        $urls = [];
        
        foreach ($sizes as $size) {
            if ($this->imageExists($size)) {
                $urls[$size] = $this->getDownloadUrl($size);
            }
        }
        
        return $urls;
    }

    /**
     * Get all available image sizes
     */
    public function getAvailableSizesAttribute()
    {
        $sizes = ['thumbnail', 'small', 'medium', 'large', 'original'];
        $available = [];
        
        foreach ($sizes as $size) {
            if ($this->imageExists($size)) {
                $available[] = $size;
            }
        }
        
        return $available;
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to search photos
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('original_name', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to get most downloaded photos
     */
    public function scopeMostDownloaded($query, $limit = 10)
    {
        return $query->orderByDesc('downloads')->limit($limit);
    }

    /**
     * Increment download count
     */
    public function incrementDownloads()
    {
        $this->increment('downloads');
        return $this->downloads;
    }
}