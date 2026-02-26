<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::latest()->get();
        return view('admin.penyewa.index', compact('penyewas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'nomor_telepon' => 'required',
            'no_kamar' => 'required',
            'nama_kost' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('penyewa', 'public');
        }

        Penyewa::create([
            'nama_lengkap' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'no_kamar' => $request->no_kamar,
            'nama_kost' => $request->nama_kost,
            'status' => $request->status,
            'foto' => $path,
        ]);

        return redirect()->route('admin.penyewa.index')
            ->with('success', 'Penyewa berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::findOrFail($id);

        if ($penyewa->foto && file_exists(storage_path('app/public/' . $penyewa->foto))) {
            unlink(storage_path('app/public/' . $penyewa->foto));
        }

        $penyewa->delete();

        return redirect()->route('admin.penyewa.index')
            ->with('success', 'Penyewa berhasil dihapus.');
    }
}