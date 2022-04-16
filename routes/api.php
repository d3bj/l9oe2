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

/*
* Not all laravel hosting provide a way to run command on console.
* This code I write from frustration and terrybelly unsecure.
* So if you wanted to secure your app please delete this.
*/

Route::post('/artisan/call', function (Request $request) {
    //Get the key from env to compare with requested key
    $appKey  = env("ARTISAN_RUN_KEY", "");
    $usersProvidedKey = str_ireplace(" ", "+", $request->key);

    if (empty($appKey)) {
        return response()->json([
            "message" => "Please Setup First.",
        ], 401);
    }

    if ($appKey != $usersProvidedKey) {
        return response()->json([
            "message" => "Unauthorized",
        ], 401);
    }

    switch ($request->type) {
        case 'fresh_migration':

            $artisan = \Artisan::call("migrate:fresh --force");
            $output = \Artisan::output();

            return response()->json([
                "message" => "Migration Confirm.",
                "output" => $output
            ]);
            break;

        case 'clear_cache':

            $artisan = \Artisan::call("cache:clear");
            $output = \Artisan::output();
            $artisan .= \Artisan::call("cache:clear");
            $output .= \Artisan::output();
            $artisan .= \Artisan::call("config:clear");
            $output .= \Artisan::output();

            return response()->json([
                "message" => "Cache Cleared.",
                "output" => $output
            ]);
            break;


        default:
            return response()->json([
                "message" => "Artisan Call Type Missing",
            ], 401);
            break;
    }
})->name('artisan.call');

// Auth
Route::post('login', LoginCotroller::class)
    ->name('api.login');

Route::post('logout', LogoutCotroller::class)
    ->name('api.logout')
    ->middleware(['auth:sanctum']);

Route::post('register', RegisterCotroller::class)
    ->name('api.register');

Route::post('password/forgot', [ResetPasswordCotroller::class, 'forgotPassword'])
    ->name('password.request');

Route::post('password/reset', [ResetPasswordCotroller::class, 'resetPassword'])
    ->name('password.reset');
