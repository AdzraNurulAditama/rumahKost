<?php

namespace App\Http\Controllers;

use App\Models\Kost;  
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index($id)
    {
        $kost = Kost::with('images', 'videos')->findOrFail($id);

        return view('user.gallery', compact('kost'));
    }
}