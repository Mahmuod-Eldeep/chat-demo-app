<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase; // لإعادة إعداد قاعدة البيانات لكل اختبار

    /**
     * اختبار تسجيل الدخول بنجاح.
     *
     * @return void
     */
    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create();


        $response = $this->postJson('/api/users/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/users/login', [
            'email' => 'wrongew@xample.com',
            'password' => '0111',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Login information invalid',
            ]);
    }
}
