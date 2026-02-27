<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KelolaKostController extends Controller
{
    public function index()
    {
        $kosts = Kost::latest()->paginate(3); // Paginate 3 sesuai jumlah di gambar kamu
        return view('admin.kelolakost.index', compact('kosts'));
        $kosts = Kost::with('images')->latest()->paginate(3);
        return view('admin.kelolakost.index', compact('kosts'));
    }

    public function create()
    {
        return view('admin.kelolakost.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'lokasi' => 'required',
            'harga' => 'required|numeric',
            'fasilitas' => 'required|array',
            'gambar' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan data utama kost
        $kost = Kost::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'lokasi' => $request->lokasi,
            'jenis' => 'Putri', // hardcode
            'harga' => $request->harga,
            'fasilitas' => json_encode($request->fasilitas),
            'status' => 'Aktif' // hardcode
        ]);

        // Simpan multiple gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/kost'), $filename);

                $kost->images()->create([
                    'image' => $filename
                ]);
            }
        }

        return redirect()->route('admin.kost.index')
            ->with('success', 'Kost berhasil ditambahkan!');
    }

    public function edit(Kost $kost)
    {
        $kost->load('images');
        return view('admin.kelolakost.edit', compact('kost'));
    }

    public function update(Request $request, Kost $kost)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'lokasi' => 'required',
            'alamat' => 'required',
            'fasilitas' => 'required|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update data utama
        $kost->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'alamat' => $request->alamat,
            'jenis' => 'Putri', // hardcode
            'fasilitas' => json_encode($request->fasilitas),
            'status' => 'Aktif' // hardcode
        ]);

        // Tambah foto baru jika ada
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {

                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/kost'), $filename);

                $kost->images()->create([
                    'image' => $filename
                ]);
            }
        }

        return redirect()->route('admin.kost.index')
            ->with('success', 'Kost berhasil diupdate!');
    }

    public function destroy(Kost $kost)
    {
        // Hapus semua file gambar dari folder
        foreach ($kost->images as $image) {

            $path = public_path('images/kost/' . $image->image);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $kost->delete();

        return redirect()->route('admin.kost.index')
            ->with('success', 'Kost berhasil dihapus!');
    }
}