<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class PostPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }


}
