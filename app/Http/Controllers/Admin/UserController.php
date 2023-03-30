<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = User::query()
            ->when($search, fn ($query, $search) =>
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            )
            ->paginate(10);

        return view('admin.users.index', compact(['users', 'search']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $roles = Role::all();
            return view('admin.users.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::create($request->only('name', 'email', 'password'));
            $user->assignRole($request->role);
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::all();
            return view('admin.users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->syncRoles($request->role);
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }

    public function switchStatus(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'is_active' => ! $user->is_active
            ]);
            return redirect()->route('users.index')->with('success', 'User status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }
    }
}
