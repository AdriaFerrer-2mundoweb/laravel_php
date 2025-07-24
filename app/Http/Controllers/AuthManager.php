<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    //Show login form
    public function login()
    {
        return view('auth.login');
    }

    //Login user
    function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        }
        return redirect(route('login'))->with('error', 'Invalid credentials');
    }

    //Show register form
    function register()
    {
        return view('auth.register');
    }

    //Register user
    function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->intended(route('login'))->with('success', 'Account created successfully');

        } catch (\Exception $e) {

            return redirect(route('register'))->with('error', 'Account creation failed');
        }
    }

    //Logout user
    function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
