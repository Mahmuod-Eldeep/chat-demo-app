<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Send a message to a specific user in a conversation.
     *
     * @OA\Post(
     *     path="/api/messages",
     *     tags={"Messages"},
     *     summary="Send a message",
     *     description="Send a message to a user in a conversation.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"conversation_id", "receiver_id", "body"},
     *             @OA\Property(property="conversation_id", type="integer", example=1),
     *             @OA\Property(property="receiver_id", type="integer", example=2),
     *             @OA\Property(property="body", type="string", example="Hello, how are you?")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Message sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Message sent successfully!"),
     *             @OA\Property(property="data", ref="#/components/schemas/Message"),
     *             @OA\Property(property="receiver_Name", type="string", example="receiver_username")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Receiver or conversation not found")
     * )
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ]);

        $user = Auth::user();
        $conversation = Conversation::find($request->conversation_id);
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);
        $receiver = User::find($request->receiver_id);

        $receiver->notify(new MessageSent($user, $message, $conversation, $request->receiver_id));
        return response()->json(['message' => 'Message sent successfully!', 'data' => $message, 'receiver_Name' => $receiver->username], 201);
    }

    /**
     * Mark all messages as seen for the authenticated user.
     *
     * @OA\Post(
     *     path="/api/messages/seen",
     *     tags={"Messages"},
     *     summary="Mark all messages as seen",
     *     description="Mark all received messages as seen for the authenticated user.",
     *     @OA\Response(
     *         response=200,
     *         description="All received messages marked as seen.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="All received messages marked as seen.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="No messages found for this user")
     * )
     */
    public function markAllAsSeen(Request $request)
    {
        $userId = $request->user()->id;

        $updatedCount = Message::where('receiver_id', $userId)
            ->where('is_seen', false)
            ->update(['is_seen' => true]);

        if ($updatedCount === 0) {
            return response()->json(['message' => 'This user does not have any messages yet.'], 404);
        }

        return response()->json(['message' => 'All received messages marked as seen.'], 200);
    }
}
