<?php

namespace App\Services;

use App\Models\User;

class UsersService
{
    /**
     * Store user
     *
     * @param array $data
     * @return User|null
     */
    public function store(array $data): ?User
    {
        return User::create($data);
    }
}