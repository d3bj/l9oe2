<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\RegisterResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RegisterCotroller extends Controller
{
    /**
     * Register a user 
     *
     * @param  App\Http\Requests\Api\RegisterRequest  $request
     * @return App\Http\Resources\Api\RegisterResource
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            // Validate request
            $test = $request->validated();
            // Get data except password and set encrypted password to the array
            $user_details = Arr::except($test, ['password']) + ['password' => bcrypt($test['password'])];

            // Create user
            $user = User::create($user_details);

            // Return confirmation with username, name and email inside 'data' array
            return new RegisterResource($user);
        } catch (Exception $ex) {
            dd($ex);
            abort(401, 'Could not create office or assign it to administrator');
        }
    }
}
