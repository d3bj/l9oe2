<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    public $userData = [
        'name' => 'Debjit',
        'username' => 'DebjitBiswas',
        'email' => 'a@a.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ];

    /**
     *Check if User's can register.
     *
     * @return void
     */
    public function test_can_a_user_register()
    {
        $this->setup();

        $response = $this->postJson(
            '/api/register',
            $this->userData
        )
            ->assertCreated();

        $this->assertEquals(3, count($response->json()['data']));
        $this->assertDatabaseHas('Users', ['name' => 'Debjit']);
    }

    /**
     *Check duplocate email and user can not register.
     *
     * @return void
     */
    public function test_duplicate_email_and_username_can_not_register()
    {
        $this->setup();
        // We are expecting errors to be happend so enable withExceptionHandling.
        $this->withExceptionHandling();
        $dataSet1 = $this->create_user(['username' => 'DebjitBiswas', 'email' => 'a@a.com']);

        $response = $this->postJson(
            '/api/register',
            $this->userData
        )
            ->assertUnprocessable();

        $this->assertEquals(2, count($response->json()['errors']));
        $this->assertDatabaseHas('Users', ['username' => 'DebjitBiswas']);
    }

    /**
     *Check if Passwordlength is 8
     *
     * @return void
     */

    public function test_users_password_must_not_be_blank()
    {
        $this->setup();
        $this->withExceptionHandling();
        $response = $this->postJson(
            '/api/register',
            Arr::except($this->userData, ['password', 'password_confirmation'])
        )
            ->assertUnprocessable();
        $this->assertEquals(1, count($response->json()['errors']['password']));
    }
    public function test_users_password_length_must_be_8()
    {
        $this->setup();
        $this->withExceptionHandling();
        $response = $this->postJson(
            '/api/register',
            Arr::except($this->userData, ['password', 'password_confirmation']) + [
                'password' => 'passwo',
                'password_confirmation' => 'passwo'
            ]
        )
            ->assertUnprocessable();
        $this->assertEquals(1, count($response->json()['errors']['password']));
    }
}
