<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostDetailFeatureTest extends TestCase
{
    public $user;
    public $should_delete_user;
    public $post;

    public function setUp(): void
    {
        //preparation
        parent::setUp();

        $this->user = User::where('email', 'test@gmail.com')->first();
        $this->should_delete_user = false;
        if (!$this->user) {
            $this->should_delete_user = true;
            $this->user = User::factory()->createQuietly([
                'email' => 'test@gmail.com',
                'password' => bcrypt('password'),
            ]);
        }

        if (!$this->post) {
            $this->post = Post::factory()->createQuietly([
                'is_verified' => 1,
                'is_blocked' => 0,
            ]);
        }
    }

    public function tearDown(): void
    {
        //reverting back any changes
        parent::tearDown();

        if ($this->should_delete_user) {
            $this->user->delete();
        }
        $this->post->delete();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_post_detail()
    {
        //checking for post data
        $post_response = $this->actingAs($this->user)->get('api/v1/posts/' . $this->post->id);
        $this->assertEquals(200, $post_response->getStatusCode());
        $post_response = json_decode($post_response->getContent(), true);

        $this->assertArrayHasKey('status', $post_response);
        $this->assertArrayHasKey('data', $post_response);
        $this->assertArrayHasKey('message', $post_response);
        $this->assertIsNumeric($post_response['data']['id']);
        $this->assertIsNumeric($post_response['data']['user_id']);
        $this->assertIsString($post_response['data']['title']);
        $this->assertIsString($post_response['data']['description']);
        $this->assertEquals('1', $post_response['status']);
    }
}