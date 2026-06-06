<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->status !== 'active' && $user->role_id != 3) { // 3 is usually Customer, let's assume customers are auto-active
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval by the admin.',
                ]);
            }

            // Redirect based on role
            switch ($user->role->name) {
                case 'admin': return redirect()->route('admin.dashboard');
                case 'farmer': return redirect()->route('farmer.dashboard');
                default: return redirect()->route('marketplace');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        $roles = Role::whereIn('name', ['farmer', 'customer'])->get();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'farmName' => ['nullable', 'required_if:role_id,2', 'string', 'max:255'],
        ], [
            'farmName.required_if' => 'The farm name is required when registering as a farmer.',
            'role_id.required' => 'Please select whether you want to buy or sell eggs.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => ($request->role_id == 2) ? 'pending' : 'active',
            'farm_name' => $request->role_id == 2 ? $request->farmName : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);

        if ($user->status === 'active') {
            Auth::login($user);
            return redirect()->route('marketplace')->with('success', 'Welcome to the Egg Marketplace!');
        }

        return redirect()->route('login')->with('success', 'Farmer account created! Please wait for admin approval before logging in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}
