<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryEvent extends Model
{
    protected $table = "gallery_events";

    protected $fillable = [
        'uuid',
        'event_name',
        'slug',
        'description',
        'event_date',
        'event_end_date',
        'display_end_date',
        'start_time',
        'end_time',
        'location',
        'cover_photo',
        'total_photos',
        'total_views',
        'total_downloads',
        'status',
        'created_by'
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_end_date' => 'date',
        'display_end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'Published',
        'total_photos' => 0,
        'total_views' => 0,
        'total_downloads' => 0,
    ];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'event_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCoverPhotoUrl()
    {
        $cover = $this->photos()->latest()->first();
        if ($cover) {
            return $cover->getImageUrl();
        }
        return asset('images/no-image.jpg');
    }

    public function hasCoverPhoto()
    {
        $cover = $this->photos()->latest()->first();
        if ($cover) {
            $url = $cover->getImageUrl();
            return $url && $url !== asset('images/no-image.jpg');
        }
        return false;
    }

    public function isPublished()
    {
        return $this->status === 'Published';
    }

    public function isDraft()
    {
        return $this->status === 'Draft';
    }

    public function isMultiDay()
    {
        return !is_null($this->event_end_date) && $this->event_end_date > $this->event_date;
    }

    public function getEventDuration()
    {
        if ($this->isMultiDay()) {
            return $this->event_date->format('d M Y') . ' - ' . $this->event_end_date->format('d M Y');
        }
        return $this->event_date->format('d M Y');
    }

    public function getTimeRange()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->format('h:i A') . ' - ' . $this->end_time->format('h:i A');
        }
        if ($this->start_time) {
            return 'Starts at ' . $this->start_time->format('h:i A');
        }
        if ($this->end_time) {
            return 'Ends at ' . $this->end_time->format('h:i A');
        }
        return null;
    }

    public function isCurrentlyDisplayed()
    {
        if ($this->status !== 'Published') {
            return false;
        }

        if ($this->display_end_date) {
            return now()->startOfDay()->lte($this->display_end_date);
        }

        return true;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'Draft');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->startOfDay())
            ->orderBy('event_date', 'desc');
    }

    public function scopeActiveDisplay($query)
    {
        return $query->where('status', 'Published')
            ->where(function ($q) {
                $q->whereNull('display_end_date')
                    ->orWhere('display_end_date', '>=', now()->startOfDay());
            });
    }

    public function incrementViews()
    {
        $this->increment('total_views');
    }

    public function incrementDownloads()
    {
        $this->increment('total_downloads');
    }

    public function updatePhotoCount()
    {
        $this->total_photos = $this->photos()->count();
        $this->save();
    }

    // Generate a unique slug
    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', $slug . '%')->count();
        
        if ($count > 0) {
            return $slug . '-' . ($count + 1);
        }
        
        return $slug;
    }

    // Boot method to auto-generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}