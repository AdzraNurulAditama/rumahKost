<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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

        return view('user.home.home', compact('kosts'));
    }
}
