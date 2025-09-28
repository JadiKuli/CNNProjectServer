<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseContoller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseContoller
{
    // Register Controller
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone_number' => $validatedData['phone_number'] ?? null,
            'role' => 'user',
        ]);

        return $this->successResponse($user, 'User registered successfully', 201);
    }

    // Login Controller
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 'User logged in successfully');
        }

        return $this->errorResponse('Invalid credentials', 401);
    }
}
