<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sender_id' => \App\Models\User::factory(), // Create a sender user
            'receiver_id' => \App\Models\User::factory(), // Create a receiver user
            'deleted_at' => null, // Soft delete field (nullable)
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
