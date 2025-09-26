<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Very simple approach - just return empty array first
        $users = [];
        
        try {
            // Try to get users from database
            $users = \App\Models\User::all()->toArray();
        } catch (\Exception $e) {
            // If any error, use empty array
            $users = [];
        }
        
        // Return test view first
        return view('apps-crm-contact-test', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tier' => 'required|string|in:' . implode(',', User::getTierOptions()),
            'role' => 'required|string|in:' . implode(',', User::getRoleOptions()),
            'start_work' => 'required|date',
            'birthday' => 'required|date',
            'status' => 'required|string|in:' . implode(',', User::getStatusOptions()),
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'tier' => 'required|string|in:' . implode(',', User::getTierOptions()),
            'role' => 'required|string|in:' . implode(',', User::getRoleOptions()),
            'start_work' => 'required|date',
            'birthday' => 'required|date',
            'status' => 'required|string|in:' . implode(',', User::getStatusOptions()),
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * API: Show the specified resource.
     */
    public function apiShow($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }
}