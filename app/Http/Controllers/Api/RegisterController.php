<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 */
class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users/register",
     *     tags={"Authentication"},
     *     summary="User registration",
     *     operationId="registerUser",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Submit the registration data using a form.",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"username", "email", "password", "password_confirmation"},
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                     example="john_doe",
     *                     description="The username of the user."
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="user@example.com",
     *                     description="The user's email address."
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123",
     *                     description="The user's password."
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="password123",
     *                     description="Confirm the user's password."
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="acces_token", type="string", example="your_access_token_here"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     */
    public function register(RegisterRequest $registerRequest)
    {
        $user = User::create([
            'username' => $registerRequest->username,
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password),
        ]);

        return response()->json([
            'acces_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 201);
    }
}
