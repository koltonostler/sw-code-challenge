<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Convert to array
        $usersArray = $users->toArray();

        // Return the array of users
        return response()->json([
            'users' => $usersArray
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'can_edit' => 'required|boolean',
        ]);

        // Create a new Article instance and save it
        $user = new User([
            'name' => $validatedData['name'],
            'can_edit' => $validatedData['can_edit'],
        ]);

        $user->save();

        // Return a JSON response with a success message and the saved article
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'can_edit' => $validatedData['can_edit']
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
