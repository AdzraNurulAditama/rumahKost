<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    // ======================
    // TAMPILKAN PROFILE
    // ======================
    public function index()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    // ======================
    // UPDATE PROFILE
    // ======================
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username'      => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status'        => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ======================
        // UPLOAD FOTO (FIXED)
        // ======================
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // simpan foto baru
            $file = $request->file('photo');
            $path = $file->store('profile-photos', 'public');

            // set ke validated
            $validated['photo'] = $path;
        }

        // update user
        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ======================
    // UPDATE PASSWORD
    // ======================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // ======================
    // HAPUS FOTO
    // ======================
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo) {

            if (Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->update(['photo' => null]);

            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada foto untuk dihapus.');
    }
}