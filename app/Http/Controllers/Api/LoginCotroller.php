<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginCotroller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $userRequest = $request->validated();

        $user = User::where('email', $userRequest['email'])->first();
        
        if (empty($user)) {
            return response()->json('Sorry! Please provide correct email and password.', 404);
        }

        if ($user) {
            if (Hash::check($userRequest['password'], $user->password)) {
                $user->tokens()->delete();
                $token =  $user->createToken('login');
                return new LoginResource(['token' => $token->plainTextToken]);
            }
            // Wrong password
            return response()->json('Sorry! Please provide correct email and password.', 404);
        }

        return response()->json('Sorry! Unknown Error.', 404);
    }
}
