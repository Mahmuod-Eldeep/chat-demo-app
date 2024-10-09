<?php

namespace Tests\Feature\Api;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_send_message()
    {
        // إنشاء مستخدمين
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        // إنشاء محادثة
        $conversation = Conversation::factory()->create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ]);

        // محاكاة تسجيل دخول المستخدم المرسل
        $this->actingAs($sender);

        $data = [
            'conversation_id' => $conversation->id,
            'receiver_id' => $receiver->id,
            'body' => 'Hello, how are you?',
        ];

        $response = $this->postJson('api/messages', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'conversation_id',
                    'sender_id',
                    'receiver_id',
                    'body',
                    'created_at',
                    'updated_at',
                ],
                'receiver_Name',
            ]);

        $this->assertDatabaseHas('messages', [
            'body' => 'Hello, how are you?',
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'conversation_id' => $conversation->id,
            'is_seen' => false,
        ]);
    }

    /** @test */
    public function user_can_mark_all_messages_as_seen()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Message::factory()->create(['receiver_id' => $user->id, 'is_seen' => false]);
        Message::factory()->create(['receiver_id' => $user->id, 'is_seen' => false]);

        $response = $this->postJson('api/messages/seen');

        $response->assertStatus(200)
            ->assertJson(['message' => 'All received messages marked as seen.']);

        $this->assertDatabaseHas('messages', [
            'receiver_id' => $user->id,
            'is_seen' => true,
        ]);

        $this->assertDatabaseCount('messages', 2);
        $this->assertDatabaseHas('messages', [
            'receiver_id' => $user->id,
            'is_seen' => true,
        ]);
    }
}
