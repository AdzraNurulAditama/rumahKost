<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
{
    $kosts = Kost::latest()->get();

    return view('user.home.index', compact('kosts'));
}
    public function index(Request $request)
    {
        $query = Kost::query();

        if ($request->lokasi) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->harga) {
            $query->where('harga', '<=', $request->harga);
        }

        if ($request->fasilitas) {
            $query->whereJsonContains('fasilitas', $request->fasilitas);
        }

        $kosts = $query->get();

        return view('user.home.index', compact('kosts'));
    }
}
