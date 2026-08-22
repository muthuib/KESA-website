<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    public $timestamps = false;
    
    protected $table = 'comment_likes';
    
    protected $fillable = [
        'comment_id', 'user_id', 'guest_id', 'ip_address'
    ];

    protected $dates = ['created_at'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}