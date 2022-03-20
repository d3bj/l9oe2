<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
   /**
     * Check if Logout url is valid and reply of unauthenticated
     *
     * @return void
     */
    public function test_check_logout_route()
    {
        $this->withExceptionHandling();
        $response = $this->postJson('/api/logout',[]);

        $response->assertStatus(401);
    }

    public function test_can_user_logout()
    {
        $this->withExceptionHandling();
        
        $user = $this->create_user([],1);
        $token = $this->postJson('api/login',['email'=>$user->first()->email,'password'=>'password']);

        $response = $this->postJson('/api/logout',[],['Authorization'=>'Bearer '.$token['data']['user_token']]);

        $response->assertStatus(200);
    }
}
