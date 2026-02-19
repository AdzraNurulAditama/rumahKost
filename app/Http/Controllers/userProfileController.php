<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class userProfileController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
    $user = \Illuminate\Support\Facades\Auth::user();

    return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

    $validated = $request->validate([
        'username' => 'required|string|max:255', 
        'email' => 'required|email|unique:users,email,' . $user->id,
        'nomor_telepon' => 'nullable|string|max:15', 
        'tanggal_lahir' => 'nullable|date',           
        'jenis_kelamin' => 'nullable|string',         
        'status' => 'nullable|string',         
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $validated['photo'] = $request->file('photo')->store('profile-photos', 'public');
    }

    $user->update($validated);

    return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function deletePhoto()
{
    $user = auth()->user();

    // Cek jika user punya foto
    if ($user->photo) {
        // Hapus file fisik dari storage
        Storage::disk('public')->delete($user->photo);

        // Update database jadi null
        $user->update(['photo' => null]);

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    return back()->with('error', 'Tidak ada foto untuk dihapus.');
}
    
}
