<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(\App\Http\Requests\LoginRequest $request)
    {
        if (!$token = auth('api')->attempt($request->validated())) {
            return \App\Helper\ResponseHelper::error([
                'message' => 'Wrong Email or Password!'
            ], 200);
        }

        $content = \App\Helper\JWTHelper::createNewToken($token);

        return \App\Helper\ResponseHelper::ok($content);
    }

    public function register(\App\Http\Requests\RegisterRequest $request)
    {
        $user = \App\Models\User::create(array_merge($request->validated(), [
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]));

        return \App\Helper\ResponseHelper::ok([
            'message' => 'User successfully registered',
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return \App\Helper\ResponseHelper::ok([
            'message' => 'User successfully signed out',
        ]);
    }

    public function profile()
    {
        return \App\Helper\ResponseHelper::ok([
            'user' => auth('api')->user(),
        ]);
    }
}
