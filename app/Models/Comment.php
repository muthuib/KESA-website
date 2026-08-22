<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';
    
    protected $fillable = [
        'blog_id', 'user_id', 'parent_id', 'content', 
        'likes', 'is_approved', 'guest_name', 'guest_email', 'ip_address'
    ];

    protected $with = ['user', 'replies'];

    protected $appends = ['avatar', 'author_name', 'time_ago'];

    /**
     * Get the user who made the comment
     * IMPORTANT: Users table uses 'ID' as primary key
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');  // 'ID' is the primary key in users table
    }

    /**
     * Get the blog this comment belongs to
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    /**
     * Get the parent comment
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all replies to this comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('is_approved', true)
            ->orderBy('created_at', 'asc')
            ->with(['user', 'replies']);
    }

    /**
     * Get all likes for this comment
     */
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class, 'comment_id');
    }

    /**
     * Get reports for this comment
     */
    public function reports(): HasMany
    {
        return $this->hasMany(CommentReport::class, 'comment_id');
    }

    /**
     * Get comment avatar
     */
    public function getAvatarAttribute()
    {
        if ($this->user) {
            return $this->user->avatar ?? $this->getGravatar($this->user->EMAIL);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->guest_name ?? 'Guest') . '&background=random';
    }

    /**
     * Get author name
     * Uses FIRST_NAME from users table
     */
    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            // Use FIRST_NAME and LAST_NAME from users table
            $firstName = $this->user->FIRST_NAME ?? '';
            $lastName = $this->user->LAST_NAME ?? '';
            return trim($firstName . ' ' . $lastName) ?: $this->user->EMAIL ?? 'User';
        }
        return $this->guest_name ?? 'Guest';
    }

    /**
     * Get time ago
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Check if user liked this comment
     */
    public function isLikedByUser($userId = null)
    {
        if (!$userId && !auth()->check()) {
            return false;
        }
        $userId = $userId ?? auth()->id();
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Scope for approved comments
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for top-level comments
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for a specific blog
     */
    public function scopeForBlog($query, $blogId)
    {
        return $query->where('blog_id', $blogId);
    }

    /**
     * Get Gravatar URL
     */
    private function getGravatar($email, $size = 80)
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }
}