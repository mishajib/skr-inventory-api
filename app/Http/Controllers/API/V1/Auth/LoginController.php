<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        auth()->user()->tokens()->delete();
        $token = auth()->user()->createToken('authToken')->plainTextToken;

        return success_response(
            "Login successful!",
            Response::HTTP_OK,
            [
                'user'       => new UserResource(auth()->user()),
                'token_type' => 'Bearer',
                'token'      => $token,
            ]

        );

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return success_response(
            'Logged out successfully!',
            Response::HTTP_OK
        );
    }

    public function currentUser(Request $request)
    {
        return success_response(
            'User found!',
            Response::HTTP_OK,
            [
                'user' => new UserResource($request->user())
            ]
        );
    }

}
