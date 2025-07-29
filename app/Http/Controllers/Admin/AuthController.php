<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.index');
    }

    public function login(Request $request)
    {
        // Step 1: Validate request inputs
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:6|max:100',
        ]);

        // Step 2: Attempt to find the user by username
        $user = User::where('name', $request->name)->first();

        if (!$user) {
            // User not found
            return back()->with('error', 'User does not exist.');
        }

        // Step 3: Check password manually
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        // Step 4: Log in the user
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/admin/products');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth.index')->with('error', 'You have been logged out.');
    }
}
