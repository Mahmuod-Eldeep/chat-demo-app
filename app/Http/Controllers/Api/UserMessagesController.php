<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Messages",
 *     description="API Endpoints for user messages"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Message",
 *     type="object",
 *     required={"id", "sender_id", "receiver_id", "content", "created_at"},
 *     @OA\Property(property="id", type="integer", format="int64", description="The unique identifier of the message."),
 *     @OA\Property(property="sender_id", type="integer", format="int64", description="The ID of the user who sent the message."),
 *     @OA\Property(property="receiver_id", type="integer", format="int64", description="The ID of the user who received the message."),
 *     @OA\Property(property="content", type="string", description="The content of the message."),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="The time when the message was created."),
 *     @OA\Property(property="read_at", type="string", format="date-time", description="The time when the message was read.")
 * )
 */

class UserMessagesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/messages",
     *     tags={"Messages"},
     *     summary="Get all messages for the authenticated user",
     *     operationId="getUserMessages",
     *     @OA\Response(
     *         response=200,
     *         description="Messages retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No messages found for this user"
     *     )
     * )
     */
    public function index()
    {
        $userId = Auth::id();

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get();

        if ($messages->isEmpty()) {
            return response()->json(['message' => 'This user does not have any messages yet.'], 404);
        }

        return response()->json($messages);
    }
}
