<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email','password'), $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
            if ($user->is_pro) return redirect()->route('pro.dashboard');
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Ces identifiants ne correspondent pas.']);
    }

    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Bienvenue sur Vitality Inside !');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showForgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }
}
