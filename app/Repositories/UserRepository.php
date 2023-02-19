<?php

namespace App\Repositories;

use App\Models;
use Laravel\Sanctum\NewAccessToken;

class UserRepository extends AbstractRepository
{
    public function createAccessToken(Models\User $user): NewAccessToken
    {
        return $user->createToken('default');
    }

    public function findByEmail(string $email): ?Models\User
    {
        return Models\User::whereEmail($email)->first();
    }
}
