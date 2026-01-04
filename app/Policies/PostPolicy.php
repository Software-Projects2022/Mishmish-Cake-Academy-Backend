<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }

    // Add similar for create, update, delete...
}
