<?php

namespace App\Http\Controllers\V1\Auth;

use App\Action\V1\Auth\RespondWithToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Jobs\ImportDefaultAvatarJob;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
    }


    /**
     * @OA\Post(
     *     path="/v1/auth/login",
     *     summary="User authentication",
     *     description="Authenticate a user and get an access token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful authentication",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unsuccessful authentication",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The selected email is invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The selected email is invalid."))
     *             )
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request, RespondWithToken $respondWithToken): JsonResponse
    {
        return (!$token = auth()->attempt($request->validated()))
            ? response()->json(['error' => 'Unauthorized'], 401)
            : $respondWithToken($token);
    }


    /**
     * @OA\Post(
     *     path="/v1/auth/register",
     *     summary="User registration",
     *     description="Register a new user and get an access token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *         )
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Conflict - User registration failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to create user")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The selected email is invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The selected email is invalid."))
     *             )
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request, RespondWithToken $respondWithToken): JsonResponse
    {
        $credentials = $request->validated();

        if($user = User::query()->create($credentials))
        {
            ImportDefaultAvatarJob::dispatch($user);
            return $respondWithToken(auth()->attempt($request->validated()));
        }
        return response()->json(['error' => 'fall to create user'], 409);
        
    }

    /**
     * @OA\Post(
     *     path="/v1/auth/refresh",
     *     summary="Refresh access token",
     *     description="Refresh the user's access token.",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response="200",
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function refresh(RespondWithToken $respondWithToken): JsonResponse
    {
        return $respondWithToken(auth()->refresh());
    }


    /**
     * @OA\Get(
     *     path="/v1/auth/me",
     *     summary="Get current user information",
     *     description="Get information about the currently authenticated user.",
     *     tags={"Authentication"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response="200",
     *         description="User information retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", example="2023-01-01 12:00:00"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 12:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 14:30:00"),
     *             @OA\Property(property="phone_number", type="string", example="1234567890"),
     *             @OA\Property(property="image", type="string", example="user.jpg"),
     *             @OA\Property(property="placeholder", type="string", example="placeholder.jpg"),
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }


    /**
     * @OA\Post(
     *     path="/v1/auth/logout",
     *     summary="User logout",
     *     description="Log the user out of the application.",
     *     tags={"Authentication"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response="200",
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
