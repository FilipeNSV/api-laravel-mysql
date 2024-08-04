<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle a registration attempt.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|min:10',
            'password' => 'required|string|min:3',
        ]);

        return $this->userService->register($validatedData);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $this->userService->updateLastLogin(Auth::user());

        return $this->respondWithToken($token);
    }

    /**
     * Return the token response.
     *
     * @param  string  $token
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Config::get('jwt.ttl')
        ]);
    }
}
