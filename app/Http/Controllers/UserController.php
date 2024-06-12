<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;

class UserController extends Controller
{
    // Fot get all users.
    public function index()
    {
        // return UserResource::collection(User::paginate());
        return UserResource::collection(User::with('role')->paginate()); //* If the role is loaded, it will be displayed.
    }

    // Create a new user.
    public function store(UserCreateRequest $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email', 'role_id')
            + ['password' => Hash::make(1234)] // Default password.
        );

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    // Get a single user.
    public function show(string $id)
    {
        return new UserResource(User::with('role')->find($id));
    }

    // Update a user.
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);

        // The body of the request must be x-www-form-urlencoded. It is a way to encode key-value pairs.
    }

    // To delete a user.
    public function destroy(string $id)
    {
        User::destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
