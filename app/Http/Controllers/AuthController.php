<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
    // FORM REGISTER
    // ======================
    public function showRegister()
    {
        return view('user.auth.register');
    }


    // ======================
    // PROSES REGISTER + OTP
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

        // ======================
        // GENERATE OTP
        // ======================
        $otp = rand(100000, 999999);

        // ======================
        // CREATE USER
        // ======================
        $user = User::create([
            'username'       => $request->username,
            'email'          => $request->email,
            'nomor_telepon'  => $request->nomor_telepon,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'status'         => $request->status,
            'password'       => Hash::make($request->password),

            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // ======================
        // KIRIM EMAIL OTP REGISTER
        // ======================
        Mail::raw("Kode OTP registrasi kamu adalah: $otp", function ($message) use ($user) {

            $message->to($user->email)
                    ->subject('OTP Registrasi RumahKostPutri');

        });

        // simpan session OTP
        session(['otp_user' => $user->id]);

        // redirect OTP
        return redirect()->route('otp.form')
            ->with('success', 'OTP berhasil dikirim ke email');
    }


    // ======================
    // PROSES LOGIN + OTP
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
            // GENERATE OTP LOGIN
            // ======================
            $otp = rand(100000, 999999);

            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            // ======================
            // KIRIM EMAIL OTP LOGIN
            // ======================
            Mail::raw("Kode OTP login kamu adalah: $otp", function ($message) use ($user) {

                $message->to($user->email)
                        ->subject('Kode OTP Login RumahKostPutri');

            });

            // logout dulu sebelum OTP benar
            Auth::logout();

            // simpan session OTP
            session(['otp_user' => $user->id]);

            // redirect OTP
            return redirect()->route('otp.form')
                ->with('success', 'OTP berhasil dikirim ke email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ])->onlyInput('email');
    }


    // ======================
    // FORM OTP
    // ======================
    public function showOtpForm()
    {
        return view('user.auth.otp');
    }


    // ======================
    // VERIFY OTP
    // ======================
    public function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = User::find(session('otp_user'));

        if (!$user) {

            return redirect()->route('login')
                ->with('error', 'Session OTP tidak ditemukan');

        }

        // ======================
        // CEK OTP
        // ======================
        if (
            $user->otp == $request->otp &&
            now()->lessThan($user->otp_expires_at)
        ) {

            // login user
            Auth::login($user);

            // hapus OTP
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            // hapus session
            session()->forget('otp_user');

            // regenerate session
            $request->session()->regenerate();

            // redirect role
            if ($user->role === 'admin') {

                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login admin berhasil');

            }

            return redirect()->route('home')
                ->with('success', 'Login berhasil');
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

        return redirect()->route('login');
    }

}