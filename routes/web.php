<?php

use App\Models\User;
use Illuminate\Support\Str;
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
    return view('welcome');
});
Route::get('/test', function () {
    dd(User::all());
    return 'test';
});

Route::get('/ct', function () {
    $random_num = Str::random(8);
    $data = [
        'name'=>$random_num,
        'username'=>$random_num,
        'email'=>$random_num . "@email.com"
    ];

    $data2 = User::factory()->create($data);
    dd($data,User::all());

});