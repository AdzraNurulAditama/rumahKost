<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{

    // ======================
    // FORM LOGIN
    // ======================
    public function showLogin()
    {
        return view('admin.loginAdmin');
    }


    // ======================
    // FORM REGISTER ADMIN
    // ======================
    public function showRegister()
    {
        return view('admin.registerAdmin');
    }


    // ======================
    // REGISTER ADMIN + OTP
    // ======================
    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'nomor_telepon' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ======================
        // GENERATE OTP
        // ======================
        $otp = rand(100000, 999999);

        // ======================
        // CREATE ADMIN
        // ======================
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'password' => Hash::make($request->password),

            // role admin
            'role' => 'admin',

            // otp
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // ======================
        // KIRIM EMAIL OTP
        // ======================
        Mail::raw("Kode OTP registrasi admin kamu adalah: $otp", function ($message) use ($user) {

            $message->to($user->email)
                    ->subject('OTP Registrasi Admin RumahKostPutri');

        });

        // simpan session otp admin
        session(['otp_admin' => $user->id]);

        return redirect()->route('admin.otp.form')
            ->with('success', 'OTP berhasil dikirim ke email admin');
    }


    // ======================
    // LOGIN ADMIN + OTP
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

            // ======================
            // CEK ROLE ADMIN
            // ======================
            if (!in_array($user->role, ['admin', 'super_admin'])) {

                Auth::logout();

                return back()->with('error', 'Akses ditolak! Bukan admin');
            }

            // ======================
            // GENERATE OTP LOGIN
            // ======================
            $otp = rand(100000, 999999);

            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            // ======================
            // KIRIM OTP EMAIL
            // ======================
            Mail::raw("Kode OTP login admin kamu adalah: $otp", function ($message) use ($user) {

                $message->to($user->email)
                        ->subject('OTP Login Admin RumahKostPutri');

            });

            // logout dulu sebelum OTP benar
            Auth::logout();

            // session otp admin
            session(['otp_admin' => $user->id]);

            return redirect()->route('admin.otp.form')
                ->with('success', 'OTP berhasil dikirim ke email');
        }

        return back()->with('error', 'Email atau password salah');
    }


    // ======================
    // FORM OTP ADMIN
    // ======================
    public function showOtpForm()
    {
        return view('admin.otp');
    }


    // ======================
    // VERIFY OTP ADMIN
    // ======================
    public function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = User::find(session('otp_admin'));

        if (!$user) {

            return redirect()->route('admin.login')
                ->with('error', 'Session OTP admin tidak ditemukan');

        }

        // ======================
        // VALIDASI OTP
        // ======================
        if (
            $user->otp == $request->otp &&
            now()->lessThan($user->otp_expires_at)
        ) {

            // login admin
            Auth::login($user);

            // hapus otp
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            // hapus session
            session()->forget('otp_admin');

            // regenerate session
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Login admin berhasil');
        }

        return back()->withErrors([
            'otp' => 'OTP salah atau sudah expired'
        ]);
    }


    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

}