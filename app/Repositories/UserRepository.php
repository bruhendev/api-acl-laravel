<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(private User $user)
    {
    }
}
