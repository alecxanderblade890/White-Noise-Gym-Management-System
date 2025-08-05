<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        // Find the user by username
        $user = User::where('username', $request->username)->first();
    
        // Check if the user exists and if the plain text passwords match
        if ($user && $request->password === $user->password) {
            // Log the user in
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
