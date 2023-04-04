<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'agreement' => 'required',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->customer()->create();
            $user->assignRole('customer');

            Auth::login($user);

            return redirect('/')->with('success', 'Your account has been created.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

}
