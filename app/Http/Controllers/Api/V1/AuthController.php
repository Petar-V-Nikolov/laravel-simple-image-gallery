<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\UserRegisterRequest;
use App\Http\Requests\Api\V1\UserLoginRequest;
use App\Models\User;
use App\Services\Api\V1\UserService;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request)
    {
        $user = $this->userService->store($request->validated());
        $token = $this->userService->generateToken($user, 'accessToken');

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(UserLoginRequest $request)
    {
        $fields = $request->validated();
        
        // Check for existing user
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !\Hash::check($fields['password'], $user->password))
        {
            return response([
                'message' => "Bad Credentials"
            ], 401);
        }

        $token = $this->userService->generateToken($user, 'accessToken');

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => "logged out"
        ]);
    }
}
