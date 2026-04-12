<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalKost = Kost::count();
        $kamarKosong = Kamar::where('status', 'Kosong')->count();
        $penyewaAktif = Penyewa::where('status', 'Menunggu')->count();
        $pendapatan = Penyewa::join('kosts', 'penyewas.kost_id', '=', 'kosts.id')
            ->join('kamars', 'kamars.kost_id', '=', 'kosts.id')
            ->where('penyewas.status', 'disetujui')
            ->sum('kamars.harga');

        // booking terbaru (ambil relasi)
        $bookings = Penyewa::with(['kamar.kost'])
            ->latest()
            ->take(7)
            ->get();

        return view('admin.dashboard', compact(
            'totalKost',
            'kamarKosong',
            'penyewaAktif',
            'pendapatan',
            'bookings'
        ));
    }
}
