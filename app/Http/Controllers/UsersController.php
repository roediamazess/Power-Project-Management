<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tier' => ['required', Rule::in(User::getTierOptions())],
            'role' => ['required', Rule::in(User::getRoleOptions())],
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
            'status' => ['required', Rule::in(User::getStatusOptions())],
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'tier' => ['required', Rule::in(User::getTierOptions())],
            'role' => ['required', Rule::in(User::getRoleOptions())],
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
            'status' => ['required', Rule::in(User::getStatusOptions())],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * API: Get all users
     */
    public function apiIndex()
    {
        $users = User::select('id', 'name', 'email', 'tier', 'role', 'start_work', 'birthday', 'status', 'created_at')
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return response()->json($users);
    }

    /**
     * API: Get single user
     */
    public function apiShow(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * API: Create user
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tier' => ['required', Rule::in(User::getTierOptions())],
            'role' => ['required', Rule::in(User::getRoleOptions())],
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
            'status' => ['required', Rule::in(User::getStatusOptions())],
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    /**
     * API: Update user
     */
    public function apiUpdate(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'tier' => ['required', Rule::in(User::getTierOptions())],
            'role' => ['required', Rule::in(User::getRoleOptions())],
            'start_work' => 'nullable|date',
            'birthday' => 'nullable|date',
            'status' => ['required', Rule::in(User::getStatusOptions())],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    /**
     * API: Delete user
     */
    public function apiDestroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
