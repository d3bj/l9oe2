<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    LoginCotroller,
    LogoutCotroller,
    RegisterCotroller,
    ResetPasswordCotroller
};

// Main Landing Page
Route::get('/', function () {
    return response()->json(
        [
            'status' => 'error',
            'message' => '404 endpoint not found. This is the base URL for the API and does not return anything itself. Please check the API reference at https://alpana.org/openexam to find a valid API endpoint.',
            'payload' => null,
        ],
        404
    );
});

// Auth
Route::post('login', LoginCotroller::class);
Route::post('logout', LogoutCotroller::class)->middleware(['auth:sanctum']);
Route::post('register', RegisterCotroller::class);
Route::post('reset-password', [ResetPasswordCotroller::class, 'reset']);
Route::post('reset-password-sent-link', [ResetPasswordCotroller::class, 'sendResetLink']);
