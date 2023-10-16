<?php

namespace App\Http\Controllers\V1\Auth;

use App\Action\V1\Auth\RespondWithToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }


    public function login(LoginRequest $request, RespondWithToken $respondWithToken): JsonResponse
    {
        return (!$token = auth()->attempt($request->validated()))
            ? response()->json(['error' => 'Unauthorized'], 401)
            : $respondWithToken($token);
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        return User::query()->create($credentials)// automatic hashing while user creation
            ? $this->login(LoginRequest::create('login', 'POST', $credentials), new RespondWithToken())
            : response()->json(['error' => 'fall to create user'], 409);
    }


    public function refresh(RespondWithToken $respondWithToken): JsonResponse
    {
        return $respondWithToken(auth()->refresh());
    }


    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }


    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    //test push to main 2






}
