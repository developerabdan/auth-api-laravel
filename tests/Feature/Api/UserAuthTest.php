<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * API Authentication Tests
 *
 * @author @abdansyakuro.id
 */
class UserAuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user registration with valid data
     *
     * @return void
     */
    public function test_user_can_register_with_valid_data()
    {
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
        ]);
    }

    /**
     * Test user registration with invalid data
     *
     * @return void
     */
    public function test_user_cannot_register_with_invalid_data()
    {
        // Missing required fields
        $response = $this->postJson('/api/register', []);
        $response->assertStatus(422);

        // Email already exists
        $existingUser = User::factory()->create();

        $userData = [
            'name' => $this->faker->name(),
            'email' => $existingUser->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(422);

        // Invalid email format
        $userData = [
            'name' => $this->faker->name(),
            'email' => 'invalid-email',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(422);

        // Short password
        $userData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'pass',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(422);
    }

    /**
     * Test user login with valid credentials
     *
     * @return void
     */
    public function test_user_can_login_with_valid_credentials()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'access_token'
                ]
            ]);
    }

    /**
     * Test user login with invalid credentials
     *
     * @return void
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        // Wrong password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);

        // Non-existent user
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);

        // Missing credentials
        $response = $this->postJson('/api/login', []);
        $response->assertStatus(422);
    }

    /**
     * Test authenticated user can get their profile
     *
     * @return void
     */
    public function test_authenticated_user_can_get_profile()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);
    }

    /**
     * Test unauthenticated user cannot get profile
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_get_profile()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);
    }
}
