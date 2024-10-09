<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'conversation_id' => \App\Models\Conversation::factory(), // Assuming you have a ConversationFactory
            'sender_id' => \App\Models\User::factory(), // Create a sender user
            'receiver_id' => \App\Models\User::factory(), // Create a receiver user
            'read_at' => $this->faker->boolean ? Carbon::now() : null, // Randomly set read_at
            'is_seen' => $this->faker->boolean,
            'receiver_deleted_at' => $this->faker->boolean ? Carbon::now() : null, // Randomly set receiver_deleted_at
            'sender_deleted_at' => $this->faker->boolean ? Carbon::now() : null, // Randomly set sender_deleted_at
            'body' => $this->faker->sentence, // Random message body
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
