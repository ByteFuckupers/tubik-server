<?php

namespace App\Action\V1\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class RespondWithToken
{
    public function __invoke(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  Config::get('jwt.ttl') // time life in config
        ]);
    }
}
