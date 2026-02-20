<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller // Nama class sebaiknya PascalCase
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'username'      => 'required|string|max:255', 
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:15', 
            'tanggal_lahir' => 'nullable|date',           
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan', // Tambahkan in: agar data valid
            'status'        => 'nullable|string',         
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            
            // Simpan foto baru
            $path = $request->file('photo')->store('profile-photos', 'public');
            $validated['photo'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed', // Min 8 karakter lebih aman
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        /** @var \App\Models\User $user */
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