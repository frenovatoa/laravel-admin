<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    // Fot get all users.
    public function index()
    {
        return User::all();
    }

    // Create a new user.
    public function store(Request $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + ['password' => Hash::make(1234)] // Default password.
        );

        return response($user, Response::HTTP_CREATED);
    }

    // Get a single user.
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    // Update a user.
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email'));

        return \response($user, Response::HTTP_ACCEPTED);

        // The body of the request must be x-www-form-urlencoded. It is a way to encode key-value pairs.
    }

    // To delete a user.
    public function destroy(string $id)
    {
        User::destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
