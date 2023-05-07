<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['email_verified_at'] = now()->format('Y-m-d H:i:s');

        $data['password'] = Hash::make($data['password']);

        // Create User
        $user = User::create($data);

        // Generate token
        $token = $user->createToken('authToken')->plainTextToken;

        return success_response(
            'User registered successfully.',
            Response::HTTP_CREATED,
            [
                'user'       => new UserResource($user),
                'token_type' => 'Bearer',
                'token'      => $token
            ]
        );
    }
}
