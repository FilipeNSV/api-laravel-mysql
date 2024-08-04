<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Register a new user.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function register(array $data): JsonResponse
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    /**
     * Update the last login timestamp for the user.
     *
     * @param  User  $user
     * @return void
     */
    public function updateLastLogin(User $user): void
    {
        $user->last_login = now();
        $user->save();
    }
}