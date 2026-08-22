<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    public function report(User $user, Comment $comment)
    {
        return true; // Anyone can report
    }
}