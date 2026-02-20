<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kost;
use Illuminate\Http\Request;

class KelolaKostController extends Controller
{
    // Tampilan Tabel Kelola Kost
    public function index()
    {
        $kosts = Kost::latest()->paginate(3); // Paginate 3 sesuai jumlah di gambar kamu
        return view('admin.kelolakost.index', compact('kosts'));
    }

    // Proses Simpan Kost Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // Simpan Gambar ke folder public/storage/kosts
        $gambarPath = $request->file('gambar')->store('kosts', 'public');

        Kost::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis' => $request->jenis,
            'harga' => $request->harga,
            'fasilitas' => $request->fasilitas, // Input berupa array dari checkbox
            'gambar' => $gambarPath,
            'status' => 'Aktif'
        ]);

        return redirect()->route('admin.kelolakost')->with('success', 'Kost Berhasil Ditambahkan!');
    }
}
