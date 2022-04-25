<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Post $post): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Post $post): Response
    {
        return (int) $post->user_id === (int) $user->id
                ? Response::allow("You are Allowed to update this post")
                : Response::deny('You cannot update this post.');
    }

    public function delete(User $user, Post $post)
    {
        return (int) $post->user_id === (int) $user->id
                ? Response::allow("You are Allowed to Delete your own post")
                : Response::deny('You can only Delete your own posts.');
    }

    public function restore(User $user, Post $post): bool
    {
        //
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return (int) $post->user_id === (int) $user->id;
    }
}