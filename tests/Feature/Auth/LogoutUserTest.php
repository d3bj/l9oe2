<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
   /**
     * Check if Login url is valid
     *
     * @return void
     */
    public function test_check_logout_route()
    {
        $response = $this->post('/api/logout');

        $response->assertStatus(200);
    }
}
