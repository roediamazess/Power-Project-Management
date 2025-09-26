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
        $users = User::query()->orderByDesc('id')->get();
        return view('apps-crm-contact', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * API: Get data for editing the specified resource.
     */
    public function apiEdit($id)
    {
        $user = User::findOrFail($id);
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
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tier' => 'required|string|in:' . implode(',', User::getTierOptions()),
            'role' => 'required|string|in:' . implode(',', User::getRoleOptions()),
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
            'status' => 'required|string|in:' . implode(',', User::getStatusOptions()),
        ]);

        try {
            // Hash password (hashed cast will skip rehashing if already hashed)
            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            \Log::info('User created successfully', ['id' => $user->id, 'email' => $user->email]);
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Throwable $e) {
            \Log::error('User create failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Failed to create user. Check logs.'])->withInput();
        }
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
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'tier' => 'required|string|in:' . implode(',', User::getTierOptions()),
            'role' => 'required|string|in:' . implode(',', User::getRoleOptions()),
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
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