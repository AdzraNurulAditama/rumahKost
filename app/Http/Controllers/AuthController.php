<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'nomor_telepon' => 'required',
            'jenis_kelamin' => 'required',
            'status' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        // langsung login setelah register
        Auth::login($user);

        return redirect()->route('dashboard');
    }
     // FORM LOGIN
    public function showLogin()
    {
        return view('user.auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

