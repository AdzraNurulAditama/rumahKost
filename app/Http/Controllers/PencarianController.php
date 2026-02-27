<?php

namespace App\Http\Controllers;

use App\Models\Pencarian;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $pencarians = Pencarian::when($search, function ($query) use ($search) {
            $query->where('nama_kost', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        })->latest()->get();

        return view('user.pencarian.index', compact('pencarians', 'search'));
    }
}