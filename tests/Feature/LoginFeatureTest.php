<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginFeatureTest extends TestCase
{
    public $user;

    public $should_delete_user;

    public function setUp(): void
    {
        //preparation
        parent::setUp();

        $this->user = User::where('email', 'test@gmail.com')->first();
        $this->should_delete_user = false;
        if (! $this->user) {
            $this->should_delete_user = true;
            $this->user = User::factory()->createQuietly([
                'email' => 'test@gmail.com',
                'password' => bcrypt('password'),
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
    }

    /**
     * Successful login test.
     *
     * @return void
     */
    public function test_successful_login()
    {
        //assertion check for user detail(before login)
        //TODO::figure out why we need to pass application/json for laravel to consider this as an API and use Handler exception.
        $response = $this->get('api/v1/users/detail', [
            'Accept' => 'application/json',
        ]);
        $response->assertUnauthorized();

        //actions
        $response = $this->post('api/v1/users/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        //assertion/checks
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('token', $responseData);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertEquals('1', $responseData['status']);

        //assertion check for user detail
        $response = $this->get('api/v1/users/detail', [
            'Authorization' => 'Bearer '.$responseData['token'],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * UnSuccessful login test.
     *
     * @return void
     */
    public function test_unsuccessful_login()
    {
        //actions
        $response = $this->post('api/v1/users/login', [
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        //assertion/checks
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertEquals('0', $responseData['status']);
    }
}
