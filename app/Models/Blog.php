<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\BlogViewLog;

class Blog extends Model
{
    protected $table = 'blog';

    protected $fillable = [
        'title',
        'content',
        'image',
        'date',
        'author',
        'category',
        'copyright',
        'ownership_disclaimer',
    ];

    /**
     * Relationship to the blog view logs.
     */
 public function viewLogs()
    {
        return $this->hasMany(BlogViewLog::class, 'id');
    }

    public function viewsInDays($days)
    {
        $fromDate = Carbon::now()->subDays($days)->toDateString();

        return $this->viewLogs()
            ->where('view_date', '>=', $fromDate)
            ->sum('views');
    }
}


