<?php

namespace App\Services;

use App\Models\User;

class CreateUserService
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
