<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\User;
use Laravel\Passport\Passport;

class BlogPostFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'author' => 'QA Tester',
            'status' => 'published'
        ];
        $this->postJson('/api/posts', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id', 'title', 'content', 'author', 'status', 'created_at', 'updated_at'
            ]);
    }

    public function test_can_validate_when_creating()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $this->postJson('/api/posts', [
            'status' => 'published'
        ])->assertStatus(422)
        ->assertJson([
            'title' => [
                'The title field is required.'
            ],
            'content' => [
                'The content field is required.'
            ],
            'author' => [
                'The author field is required.'
            ]
        ]);
    }

    public function test_can_validate_when_updating()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $post = BlogPost::factory()->create();

        $this->putJson("/api/posts/{$post->id}", [
            'status' => 'Abracadabra'
        ])->assertStatus(422)
        ->assertJson([
            'status' => [
                'The selected status is invalid.'
            ]
        ]);
    }

    public function test_can_rejects_invalid_status_value()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $this->postJson('/api/posts', [
            'title' => 'A valid title',
            'content' => 'Some valid content',
            'author' => 'QA Tester',
            'status' => 'Abracadabra'
        ])->assertStatus(422)
        ->assertJson([
            'status' => [
                'The selected status is invalid.'
            ]
        ]);
    }

    public function test_can_get_all_posts()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        BlogPost::factory()->count(3)->create();

        $this->getJson('/api/posts')
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'content', 'author', 'status', 'created_at', 'updated_at']
            ]);
    }

    public function test_can_update_post()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $post = BlogPost::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'author' => 'Jane Doe',
            'status' => 'draft'
        ];

        $this->putJson("/api/posts/{$post->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure(['id', 'title', 'content', 'author', 'status', 'created_at', 'updated_at']);
    }

    public function test_can_delete_post()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $post = BlogPost::factory()->create();

        $this->deleteJson("/api/posts/{$post->id}")
            ->assertStatus(204);
    }
}
