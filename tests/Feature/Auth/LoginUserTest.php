<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    public function test_user_must_provide_email_and_password()
    {
        $this->setup();
        $this->withExceptionHandling();
        $test = $this->create_user([], 1);
        $response = $this->postJson(
            '/api/login',[]
        );
        $this->assertEquals(2, count($response->json()['errors']));
    }

    public function test_users_password_must_be_min_8_char()
    {
        $this->setup();
        $this->withExceptionHandling();
        $test = $this->create_user([], 1);
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $test->first()->email,
                'password' => 'passwor'
            ]
        );
        $this->assertEquals(1, count($response->json()['errors']['password']));
    }

    public function test_user_must_provide_valid_email()
    {
        $this->setup();
        $this->withExceptionHandling();
        $test = $this->create_user([], 1);
        $response = $this->postJson(
            '/api/login',
            [
                'email' => 'email.com',
                'password' => 'password'
            ]
        );
        $this->assertEquals(1, count($response->json()['errors']['email']));
    }

    public function test_user_can_get_token_after_sucesfull_login()
    {
        $this->setup();
        $test = $this->create_user([], 1);
        $response = $this->postJson(
            '/api/login',
            [
                'email' => $test->first()->email,
                'password' => 'password'
            ]
        );
        $this->assertEquals(1, count($response->json()['data']));
    }
}
