<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    /**
     * Check if Login url is valid
     *
     * @return void
     */
    public function test_check_login_route()
    {
        $response = $this->post('/api/login');

        $response->assertStatus(200);
    }
}
