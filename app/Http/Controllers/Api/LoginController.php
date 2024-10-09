<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 */
/**
 * @OA\Info(
 *     title="Chat Application API",
 *     version="1.0.0",
 *     description="API for a real-time chat application.",
 *     @OA\Contact(
 *         name="Your Name",
 *         email="your.email@example.com"
 *     )
 * )
 */

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users/login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     operationId="loginUser",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Submit the login data using a form.",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", example="user@example.com", description="The user's email address."),
     *                 @OA\Property(property="password", type="string", format="password", example="password123", description="The user's password.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="your_access_token_here"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid login information"
     *     )
     * )
     */
    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $loginRequest->email)->first();

            return response()->json([
                'access_token' => $user->createToken('api_token')->plainTextToken,
                'token_type' => 'Bearer'
            ]);
        }

        return response()->json([
            'message' => 'Login information invalid'
        ], 401);
    }
}
