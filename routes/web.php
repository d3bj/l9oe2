<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
Route::get('/test', function () {
    return 'test';
});