<?php

namespace App\Services\DTO\Auth;

use Carbon\Carbon;
use Hash;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public string $first_name;

    public string $last_name;

    public string $email;

    public string $password;

    public function getFillable(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
    }
}
