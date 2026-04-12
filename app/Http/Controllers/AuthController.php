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
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'nomor_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username'       => $request->username,
            'email'          => $request->email,
            'nomor_telepon'  => $request->nomor_telepon,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'status'         => $request->status,
            'password'       => Hash::make($request->password),
        ]);

        // login otomatis
        Auth::login($user);

        // regenerate session
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success','Registrasi berhasil!');
    }


    // ======================
    // PROSES LOGIN
    // ======================
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ])->onlyInput('email');
    }


    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}