<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase; // Use the RefreshDatabase trait to reset the database before each test

    /**
     * Test the /users POST API.
     */
    public function testCreateUser(): void
    {
        $userData = [
            'name' => 'JohnDoe',
            'can_edit' => true,
        ];

        // Send a POST request to the /api/users endpoint
        $response = $this->json('POST', '/api/users', $userData);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure
        $response->assertJson([
            'message' => 'User created successfully',
            'user' => $userData,
            'can_edit' => true,
        ]);

        // Assert the user is saved in the database
        $this->assertDatabaseHas('users', $userData);
    }

    public function testIndexUsers(): void
    {
        // Create some sample users in the testing database
        User::factory()->count(3)->create();
    
        // Send a GET request to the /api/users endpoint
        $response = $this->getJson('/api/users');
    
        // Assert the response status
        $response->assertStatus(200);
    
        // Assert the response structure
        $response->assertJsonStructure([
            'users' => [
                '*' => [
                    'id',
                    'name',
                    'can_edit',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    
        // Assert the number of users in the response matches the number created
        $response->assertJsonCount(3, 'users');
    }
}
