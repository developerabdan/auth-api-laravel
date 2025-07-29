<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contracts\AuthServiceInterface;

class SanctumServices implements AuthServiceInterface
{
    public function register(array $data): string
    {
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return ApiResponse::success($user, 'User created successfully', 200);
    }

    public function login(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            return ApiResponse::error('Invalid credentials', 401);
        }
        $user = Auth::user();
        return ApiResponse::success([
            'user' => $user->makeHidden(['created_at', 'updated_at', 'email_verified_at']),
            'access_token' => $user->createToken('api-token')->plainTextToken
        ], 'Login successfully', 200);
    }

    public function getUser(): string
    {
        $user = Auth::user();
        return ApiResponse::success($user, 'User retrieved successfully', 200);
    }
}
