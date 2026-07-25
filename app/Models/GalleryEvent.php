<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryEvent extends Model
{
    protected $table = "gallery_events";

    protected $fillable = [
	     'uuid',

        'event_name',

        'slug',

        'description',

        'event_date',

        'location',

        'cover_photo',

        'status',

        'created_by'

    ];

    public function photos()
    {
        return $this->hasMany(
            GalleryPhoto::class,
            'event_id'
        );
    }
	// In app/Models/GalleryEvent.php
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
}