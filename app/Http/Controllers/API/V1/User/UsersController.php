<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::latest()->paginate(10);

        return success_response(
            'Data found!',
            Response::HTTP_OK,
            UserResource::collection($users)
                ->withQuery($request->query())
                ->response()->getData(),
        );
    }

    /**
     * Store a newly created resource in database.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        return success_response(
            'User created successfully!',
            Response::HTTP_CREATED,
            new UserResource(User::create($data))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return success_response(
            'Data found!',
            Response::HTTP_OK,
            new UserResource($user)
        );
    }

    /**
     * Update the specified resource in database.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update($data);

        return success_response(
            'User updated successfully!',
            Response::HTTP_OK,
            new UserResource($user)
        );
    }

    /**
     * Remove the specified resource from database
     */
    public function destroy(User $user)
    {
        $user->delete();

        return success_response(
            'User deleted successfully!',
            Response::HTTP_OK,
            new UserResource($user)
        );
    }
}
