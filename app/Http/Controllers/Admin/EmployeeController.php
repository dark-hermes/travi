<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employee-list|employee-create|employee-edit|employee-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $isSuperadmin = auth()->user()->hasRole('superadmin');
            $employees = User::whereHas('roles', function ($query) {
                $query->where('name', '!=', 'customer');
                })
                ->when(! $isSuperadmin, function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', '!=', 'superadmin');
                    });
                })
                ->when($request->search, function ($query) use ($request, $isSuperadmin) {
                    $query->whereHas('roles', function ($query) use ($isSuperadmin) {
                        $isSuperadmin
                            ? $query->whereNot('name', 'customer')
                            : $query->whereNotIn('name', ['superadmin', 'customer']);
                    })
                        ->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%")
                        ->orWhere('phone', 'like', "%{$request->search}%")
                        ->orWhereHas('roles', function ($query) use ($request) {
                            $query->where('name', 'like', "%{$request->search}%");
                        });
                })->paginate(10);

            return view('admin.employees.index', compact('employees'))->with('success', 'Employees retrieved successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $isSuperadmin = auth()->user()->hasRole('superadmin');
            $roles = $isSuperadmin
                ? Role::whereNot('name', 'customer')->get()
                : Role::whereNotIn('name', ['superadmin', 'customer'])->get();
            return view('admin.employees.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
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
            return redirect()->route('employees.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = User::where('id', $id)->whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->firstOrFail();
            return view('admin.employees.show', compact('employee'))->with('success', 'Employee retrieved successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $isSuperadmin = auth()->user()->hasRole('superadmin');
            $roles = $isSuperadmin
                ? Role::whereNot('name', 'customer')->get()
                : Role::whereNotIn('name', ['superadmin', 'customer'])->get();
            $employee = User::where('id', $id)->whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->firstOrFail();
            return view('admin.employees.edit', compact('employee', 'roles'))->with('success', 'Employee retrieved successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|min:10|max:15',
            'address' => 'nullable|string|min:3',
        ]);

        try {
            $employee = User::where('id', $id)->whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->firstOrFail();
            $employee->update($request->only('name', 'email', 'phone', 'address'));
            $employee->syncRoles($request->role);
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = User::where('id', $id)->whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->firstOrFail();
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    public function switchStatus(string $id)
    {
        try {
            $employee = User::where('id', $id)->whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->firstOrFail();
            $employee->update([
                'is_active' => ! $employee->is_active,
            ]);
            return redirect()->route('employees.index')->with('success', 'Employee status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    public function editPassword(string $id)
    {
        try {
            $employee = User::findOrFail($id);
            return view('admin.employees.edit-password', compact('employee'));
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }

    public function updatePassword(Request $request, string $id)
    {
        $this->validate($request, [
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            return back()->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', $e->getMessage());
        }
    }
}
