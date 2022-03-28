<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\SendPasswordResetNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordCotroller extends Controller
{
    // This will send password reset email
    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        try {
            Password::sendResetLink($validated);
            if (Password::RESET_LINK_SENT) {
                return response()->json(['message' => 'You will get an email with instructions.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['error' => 'Could not sent email please try again later.']], 422);
        }
    }

    // This will change the password for user
    // Request will need to 
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Successfully changed your password. Please login with your new password.'], 200)
            : response()->json(['errors' => ['error' => 'Something went wrong, Please try again later.']], 406);
    }
}
