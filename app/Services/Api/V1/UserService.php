<?php

namespace App\Services\Api\V1;

use Illuminate\Http\Request;
use App\Models\User;

class UserService
{
    public function store(array $fields = []) : User
    {
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        return $user;
    }

    public function generateToken(User $user, string $name) : String
    {
        $token = $user->createToken($name)->plainTextToken;

        return $token;
    }
}
