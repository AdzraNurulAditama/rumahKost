<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use App\Models\KostImage;
use App\Models\KostVideo;
use Illuminate\Http\Request;

class KelolaKostController extends Controller
{
    public function index(Request $request)
    {
        $query = Kost::with(['images', 'kamars']);

        // ✅ TAMBAH: Filter search by nama kost
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kosts = $query->latest()->get();

        return view('admin.kelolakost.index', compact('kosts'));
    }

    public function create()
    {
        return view('admin.kelolakost.create');
    }

    public function show($id)
    {
        $kost = Kost::with('images')->findOrFail($id);
        return view('detail-kost', compact('kost'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required',
            'alamat'       => 'required',
            'lokasi'       => 'required',
            'harga'        => 'required|numeric',
            'jumlah_kamar' => 'required|integer|min:1',
            'gambar.*'     => 'image|mimes:jpg,jpeg,png|max:2048',
            'video.*'      => 'nullable|mimetypes:video/mp4,video/avi,video/quicktime,video/x-msvideo|max:51200',
        ]);

        $kost = Kost::create([
            'nama'         => $request->nama,
            'alamat'       => $request->alamat,
            'lokasi'       => $request->lokasi,
            'jenis'        => $request->jenis,
            'harga'        => $request->harga,
            'jumlah_kamar' => $request->jumlah_kamar,
            'fasilitas'    => $request->fasilitas,
            'status'       => 'Aktif',
        ]);

        KelolaKamarController::generateKamar($kost);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/kost'), $namaFile);
                KostImage::create(['kost_id' => $kost->id, 'image' => $namaFile]);
            }
        }

        if ($request->hasFile('video')) {
            if (!file_exists(public_path('videos/kost'))) {
                mkdir(public_path('videos/kost'), 0755, true);
            }
            foreach ($request->file('video') as $index => $file) {
                $namaFile = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $file->move(public_path('videos/kost'), $namaFile);
                KostVideo::create([
                    'kost_id' => $kost->id,
                    'video'   => $namaFile,
                    'judul'   => $request->judul_video[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil ditambahkan');
    }

    public function edit(Kost $kost)
    {
        $kost->load('images', 'videos');
        return view('admin.kelolakost.edit', compact('kost'));
    }

    public function update(Request $request, Kost $kost)
    {
        $request->validate([
            'nama'         => 'required',
            'harga'        => 'required|numeric',
            'lokasi'       => 'required',
            'alamat'       => 'required',
            'jenis'        => 'required',
            'jumlah_kamar' => 'required|integer|min:1',
            'fasilitas'    => 'array',
            'gambar.*'     => 'image|mimes:jpeg,png,jpg|max:2048',
            'video.*'      => 'nullable|mimetypes:video/mp4,video/avi,video/quicktime,video/x-msvideo|max:51200',
        ]);

        $kost->update([
            'nama'         => $request->nama,
            'harga'        => $request->harga,
            'lokasi'       => $request->lokasi,
            'alamat'       => $request->alamat,
            'jenis'        => $request->jenis,
            'jumlah_kamar' => $request->jumlah_kamar,
            'fasilitas'    => $request->fasilitas,
            'status'       => 'Aktif',
        ]);

        KelolaKamarController::generateKamar($kost);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/kost'), $filename);
                KostImage::create(['kost_id' => $kost->id, 'image' => $filename]);
            }
        }

        if ($request->hasFile('video')) {
            if (!file_exists(public_path('videos/kost'))) {
                mkdir(public_path('videos/kost'), 0755, true);
            }
            foreach ($request->file('video') as $index => $file) {
                $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $file->move(public_path('videos/kost'), $filename);
                KostVideo::create([
                    'kost_id' => $kost->id,
                    'video'   => $filename,
                    'judul'   => $request->judul_video[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil diupdate!');
    }

    public function destroy(Kost $kost)
    {
        foreach ($kost->images as $image) {
            $path = public_path('images/kost/' . $image->image);
            if (file_exists($path)) unlink($path);
            $image->delete();
        }
        foreach ($kost->videos as $video) {
            $path = public_path('videos/kost/' . $video->video);
            if (file_exists($path)) unlink($path);
            $video->delete();
        }
        $kost->delete();
        return redirect()->route('admin.kost.index')->with('success', 'Kost berhasil dihapus');
    }

    public function destroyImage($id)
    {
        $image = KostImage::findOrFail($id);
        $path  = public_path('images/kost/' . $image->image);
        if (file_exists($path)) unlink($path);
        $image->delete();
        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function destroyVideo($id)
    {
        $video = KostVideo::findOrFail($id);
        $path  = public_path('videos/kost/' . $video->video);
        if (file_exists($path)) unlink($path);
        $video->delete();
        return back()->with('success', 'Video berhasil dihapus');
    }
}