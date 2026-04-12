<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 
        $transaksis = collect(); // kosong dulu
        return view('user.transaksi', compact('user','transaksis'));
    }
}