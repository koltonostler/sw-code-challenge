<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\User;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method of the ArticleController.
     *
     * @return void
     */
    public function testIndexMethod(): void
    {
        // Create some sample users in the testing database since the article factory needs users to work properly
        User::factory()->count(3)->create();
        // Create some sample articles in the testing database
        Article::factory()->count(3)->create();

        // Send a GET request to the /api/articles endpoint
        $response = $this->getJson('/api/articles');

        // Assert the response status
        $response->assertStatus(200);

        // Assert the response structure
        $response->assertJsonStructure([
            'articles' => [
                '*' => [
                    'id',
                    'title',
                    'body',
                    'user_id',
                    'last_edit_user_id',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        // Assert the number of articles in the response matches the number created
        $response->assertJsonCount(3, 'articles');
    }
    /**
     * Test the store method of the ArticleController.
     *
     * @return void
     */
    public function testStoreMethod(): void
    {
        // Create a sample user with can_edit set to true
        $user = User::factory()->create(['can_edit' => true]);

        // Simulate a POST request to the /api/articles endpoint
        $data = [
            'title' => 'Test Article',
            'body' => 'This is a test article body.',
            'user' => [
                'id' => $user->id,
                'can_edit' => 1,
            ],
        ];

        $response = $this->postJson('/api/articles', $data);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure
        $response->assertJson([
            'message' => 'Article created successfully',
            'article' => [
                'title' => 'Test Article',
                'body' => 'This is a test article body.',
                'user_id' => $user->id,
            ],
            'data' => $data,
        ]);

        // Assert the article is saved in the database
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'body' => 'This is a test article body.',
            'user_id' => $user->id,
        ]);
    }

     /**
     * Test the update method of the ArticleController.
     *
     * @return void
     */
    public function testUpdateMethod(): void
    {
        // Create a sample user with can_edit set to true
        $user = User::factory()->create(['can_edit' => true]);

        // Create a sample article
        $article = Article::factory()->create();

        // Simulate a PUT request to the /api/articles/{id} endpoint
        $data = [
            'title' => 'Updated Article Title',
            'body' => 'This is an updated article body.',
            'user' => [
                'id' => $user->id,
                'can_edit' => 1,
            ],
        ];

        $response = $this->putJson("/api/articles/{$article->id}", $data);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure
        $response->assertJson([
            'message' => 'Article updated successfully',
            'article' => [
                'title' => 'Updated Article Title',
                'body' => 'This is an updated article body.',
                'last_edit_user_id' => $user->id,
            ],
        ]);

        // Assert the article in the database has been updated
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Article Title',
            'body' => 'This is an updated article body.',
            'last_edit_user_id' => $user->id,
        ]);
    }
     /**
     * Test the destroy method of the ArticleController.
     *
     * @return void
     */
    public function testDestroyMethod(): void
    {
        // Create a sample user with can_edit set to true
        $user = User::factory()->create(['can_edit' => true]);

        // Create a sample article
        $article = Article::factory()->create();

        // Simulate a DELETE request to the /api/articles/{id} endpoint
        $response = $this->deleteJson("/api/articles/{$article->id}", [], ['can_edit' => 'true']);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure
        $response->assertJson([
            'message' => 'Article successfully deleted',
            'article' => [
                'title' => $article->title,
                'body' => $article->body,
            ],
        ]);

        // Assert the article has been deleted from the database
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }
}
