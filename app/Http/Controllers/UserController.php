<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            $query = User::where('role', 'staff');

            // Apply status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $users = $query->paginate(8)->withQueryString();

            return view('users.staff', ['users' => $users]);
        }
        // for super admin
        $query = User::where(function($q) {
            $q->where('role', 'staff')
              ->orWhere('role', 'admin');
        });

        // Apply role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(8)->withQueryString();

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
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:admin,staff',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['status'] = $validated['status'] ?? 'active';
        // Only super admins can set role; others default to staff
        if ($request->user()->isSuperAdmin()) {
            $validated['role'] = $request->input('role', 'staff');
        } else {
            $validated['role'] = 'staff';
        }
        $validated['remember_token'] = Str::random(10);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Succesfully added a user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', ['user' => $user]);
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
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|in:admin,staff',
        ]);

        // update the user status
        $validated['status'] =  $request->input('status') ?  'active' : 'inactive';

        // Only super admins can change role; others ignored
        if ($request->user()->isSuperAdmin()) {
            if ($request->filled('role')) {
                $validated['role'] = $request->input('role');
            } else {
                unset($validated['role']);
            }
        } else {
            unset($validated['role']);
        }

        // optional password
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User details updated!');
    }

    /**
     * Deactivate a user (set status to inactive).
     */
    public function deactivate(User $user)
    {
        $this->authorize('update', $user);

        // Prevent deactivating yourself to avoid lockout
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot deactivate your own account.');
        }

        $user->status = 'inactive';
        $user->save();

        return redirect()->route('users.index')->with('success', 'User deactivated.');
    }

    /**
     * Reactivate a user (set status to active).
     */
    public function reactivate(User $user)
    {
        $this->authorize('update', $user);

        $user->status = 'active';
        $user->save();

        return redirect()->route('users.index')->with('success', 'User reactivated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted from the list!');
    }
}
