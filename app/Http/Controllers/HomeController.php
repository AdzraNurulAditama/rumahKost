<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $kosts = Kost::query();

        // FILTER LOKASI
        if ($request->filled('lokasi')) {
            $kosts->where('lokasi', $request->lokasi);
        }

        // FILTER HARGA MAKSIMAL
        if ($request->filled('harga')) {
            $kosts->where('harga', '<=', $request->harga);
        }

        // FILTER FASILITAS (JSON)
        if ($request->filled('fasilitas')) {
            // fasilitas dikirim satuan, contoh: "AC"
            $kosts->whereJsonContains('fasilitas', $request->fasilitas);
        }

        $kosts = $kosts->get();

        return view('user.home.home', compact('kosts'));
    }

    /**
     * DETAIL KOST (KLIK CARD)
     */
    // public function show($id)
    // {
    //     $kost = Kost::findOrFail($id);

    //     return view('kost.detail', compact('kost'));
    // }
}
