<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SendPasswordResetNotification extends Notification
{
    use Queueable;
    public $token;
    public $front_url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$front_url)
    {
        $this->token = $token;
        $this->front_url = $front_url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Provide token so User can copy the token if they wanted to reset email from there app,
     * Or click the link if they wanted
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $frontResetLink = $this->front_url . '/password/reset/'. $this->token;

        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->greeting($this->token)
            ->line(Lang::get('Please copy and paste this token to your app, or click the button bellow to reset via web browser.'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $frontResetLink)
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
