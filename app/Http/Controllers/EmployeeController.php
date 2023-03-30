<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $employees = User::whereHas('roles', function ($query) {
                $query->whereNot('name', 'customer');
            })->paginate(10);

            return view('admin.employees.index', compact('employees'))->with('success', 'Employees retrieved successfully');
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
            $roles = Role::all();
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
}
