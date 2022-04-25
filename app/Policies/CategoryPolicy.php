<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
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

    public function view(User $user, Category $category): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Category $category): bool
    {
        //
    }

    public function delete(User $user, Category $category): Response
    {
        return $user->isAdmin() ?
                Response::allow("You are an admin, you can delete this Category") :
                Response::deny("You are not an admin. You can't delete this Category");
    }

    public function restore(User $user, Category $category): bool
    {
        //
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return $user->isAdmin() ?
                Response::allow("You are an admin, you can delete this Category") :
                Response::deny("You are not an admin. You can't delete this Category");
    }
}