<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('user');
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            || $comment->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin')
            || $user->hasRole('user');
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            || $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            || $comment->user_id === $user->id;
    }

    public function restore(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin');
    }

    public function approve(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            && $comment->status === 'pending';
    }

    public function reject(User $user, Comment $comment): bool
    {
        return $user->hasRole('admin')
            && $comment->status === 'pending';
    }
}