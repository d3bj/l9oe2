<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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



Route::get('/ct', function () {
    $random_num = Str::random(8);
    $data = [
        'name'=>$random_num,
        'username'=>$random_num,
        'email'=>$random_num . "@email.com",
        'password'=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ];

    $data2 = User::create($data);
    dd($data,User::all());

});
Route::get('/get-users', function ()
{
    dd(User::all());
});

Route::get('/test', function(){
    $test = Artisan::call("migrate:fresh --force");
        dd($test);
});



Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/', function () {
    return view('welcome');
});
