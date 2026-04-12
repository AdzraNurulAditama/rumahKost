<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        $kosts = Kost::with('images')->latest()->paginate(8);
        return view('user.home', compact('kosts'));
    }

    public function index(Request $request)
    {
        $query = Kost::with('images');

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->lokasi) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }
        if ($request->harga) {
            $query->where('harga', '<=', $request->harga);
        }
        if ($request->fasilitas) {
            $query->whereJsonContains('fasilitas', $request->fasilitas);
        }

        $kosts = $query->latest()->paginate(8);
        return view('user.home', compact('kosts'));
    }

    public function detail($id)
    {
        $kost = Kost::with(['images' => function($q) {
            $q->limit(4);
        }, 'reviews.user', 'videos'])->findOrFail($id);

        // ✅ UBAH: hitung sisa kamar dari tabel kamars
        $sisaKamar = Kamar::where('kost_id', $id)
                        ->where('status', 'Kosong')
                        ->count();

        return view('user.detail', compact('kost', 'sisaKamar'));
    }
}