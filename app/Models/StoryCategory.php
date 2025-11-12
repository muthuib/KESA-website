<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoryCategory extends Model
{
    use HasFactory;

    protected $table = 'story_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Automatically set the slug when creating a new category.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Define relationship with SuccessStory (if linked later).
     */
   public function stories()
        {
            return $this->belongsToMany(
                SuccessStory::class,
                'story_category_pivot',   // pivot table name
                'category_id',            // foreign key on pivot table for this model
                'story_id'                // foreign key on pivot table for related model
            );
        }

}
