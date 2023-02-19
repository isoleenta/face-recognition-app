<?php

namespace App\Services\Auth;

use App\Models;
use App\Repositories;
use App\Services\DTO;
use Response;

class AuthService
{
    public function __construct(
        private Repositories\UserRepository $user_repository,
    ) {
        //
    }

    public function registerUser(DTO\Auth\RegisterData $data): string
    {
        $user = $this->user_repository->create(
            $data->getFillable()
        );

        $token = $this->user_repository->createAccessToken($user)->plainTextToken;

        return $token;
    }

    public function loginUser($email, $password): string
    {
        $user = $this->user_repository->findByEmail($email);

        abort_if(
            $user === null,
            Response::BAD_REQUEST,
            __('There is no account with this email')
        );

        abort_if(
            ! $user->checkPassword($password),
            Response::BAD_REQUEST,
            __('Wrong password')
        );

        $token = $this->user_repository->createAccessToken($user)->plainTextToken;

        return $token;
    }

    public function logoutUser(Models\User $user)
    {
        $user->currentAccessToken()->delete();

        return true;
    }
}
