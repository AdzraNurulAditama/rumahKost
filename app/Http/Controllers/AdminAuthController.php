<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // FORM LOGIN
    public function showLogin()
    {
        return view('admin.loginAdmin');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 🔥 CEK ROLE ADMIN
            if (!in_array($user->role, ['admin', 'super_admin'])) {
                Auth::logout();
                return back()->with('error', 'Akses ditolak! Bukan admin');
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Login berhasil sebagai ' . $user->role);
        }

        return back()->with('error', 'Email atau password salah');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}