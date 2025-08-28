<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\BlogViewLog;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $table = 'blog';

    protected $fillable = [
        'title',
        'slug',
        'name', // ✅ Newly added field
        'content',
        'image',
        'date',
        'author',
        'category',
        'copyright',
        'ownership_disclaimer',
    ];

    protected $casts = [
    'date' => 'datetime',
     ];


    /**
     * Relationship to the blog view logs.
     */
    public function viewLogs()
    {
        return $this->hasMany(BlogViewLog::class, 'blog_id'); // ✅ Fixed: should be 'blog_id'
    }

    public function viewsInDays($days)
    {
        $fromDate = Carbon::now()->subDays($days)->toDateString();

        return $this->viewLogs()
            ->where('view_date', '>=', $fromDate)
            ->sum('views');
    }
// creates blog title in the browser instead of id
protected static function boot()
{
    parent::boot();

    static::creating(function ($blog) {
        if (is_null($blog->slug) || $blog->slug === '') {
            $blog->slug = Str::slug($blog->title);
        }
    });

    static::updating(function ($blog) {
        if (is_null($blog->slug) || $blog->slug === '') {
            $blog->slug = Str::slug($blog->title);
        }
    });
}

}
