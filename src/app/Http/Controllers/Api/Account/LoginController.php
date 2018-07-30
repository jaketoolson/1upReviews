<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Account;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OneUpReviews\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return $this->json(['message' => 'Logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function me(): JsonResponse
    {
        return $this->json(auth('api')->user());
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return $this->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
