<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostLikeFeatureTest extends TestCase
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
     * post Like test.
     *
     * @return void
     */
    public function test_post_like_toggle()
    {
        //checking before toggle
        $post_response = $this->actingAs($this->user)->get('api/v1/posts/' . $this->post->id);
        $this->assertEquals(200, $post_response->getStatusCode());
        $post_response = json_decode($post_response->getContent(), true);
        $this->assertEquals('1', $post_response['status']);
        $this->assertEquals(false, $post_response['data']['is_liked']);

        //calling toggle API
        $like_toggle_response  = $this->actingAs($this->user)->post('api/v1/posts/' . $this->post->id . '/likes/toggle');
        $this->assertEquals(200, $like_toggle_response->getStatusCode());
        $this->assertEquals('1', $like_toggle_response['status']);

        //checking after toggle
        $post_response = $this->actingAs($this->user)->get('api/v1/posts/' . $this->post->id);
        $this->assertEquals(200, $post_response->getStatusCode());
        $post_response = json_decode($post_response->getContent(), true);
        $this->assertEquals('1', $post_response['status']);
        $this->assertEquals(true, $post_response['data']['is_liked']);
    }
}