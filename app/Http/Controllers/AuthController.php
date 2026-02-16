<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ======================
    // FORM LOGIN
    // ======================
    public function showLogin()
    {
        return view('user.auth.login');
    }

    // ======================
    // PROSES REGISTER
    // ======================
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'nomor_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        // Regenerate session (security)
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    // ======================
    // PROSES LOGIN
    // ======================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            // Regenerate session (WAJIB untuk security)
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
