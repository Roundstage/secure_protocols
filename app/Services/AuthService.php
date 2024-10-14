<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function authenticate(string $email, string $password): array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
        }

        throw new \Exception('Authentication failed.');
    }

}
