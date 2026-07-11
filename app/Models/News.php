<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'image',
        'date',
        'media1',   
        'media2',
        'media3',
        'views',
    ];
    
   public function incrementViews()
    {
        $this->increment('views');
    }
}
