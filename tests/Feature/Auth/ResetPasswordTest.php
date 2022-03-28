<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    /**
     * User can get email with password reset information.
     *
     * @return void
     */
    public function test_can_user_get_the_email_with_password_reset_information()
    {
        Notification::fake();

        $user = $this->create_user();
        $response = $this->postJson('/api/password/forgot', ['email' => $user->first()->email]);

        Notification::assertSentTo(
            [$user],
            \App\Notifications\SendPasswordResetNotification::class
        );
    }
}
