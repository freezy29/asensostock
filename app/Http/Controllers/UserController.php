<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()
            ->take(50);

        return view('users.index', ['users' => $users]);
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
    public function store(Request $request, User $user)
    {
        if ($request->user()->cannot('create', $user)) {
            abort(403);
        }

        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:admin,staff',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['status'] = $validated['status'] ?? 'active';
        $validated['role'] = $validated['role'] ?? 'staff';
        $validated['remember_token'] = Str::random(10);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'user details edited!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'password' => 'nullable|string|confirmed|',
            'role' => 'required|in:admin,staff',
        ]);


        $validated['status'] =  $request->input('status') ?  'active' : 'inactive';

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'user details edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'user deleted!');
    }
}
