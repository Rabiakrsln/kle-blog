<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('user');
    }

    public function view(User $user, Post $post): bool
    {
        return $user->hasRole('admin')
            || $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') 
            || $user->hasRole('user');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->hasRole('admin')
            || $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasRole('admin')
            || $post->user_id === $user->id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->hasRole('admin');
    }
}
