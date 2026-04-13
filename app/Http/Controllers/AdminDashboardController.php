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
        $totalKost      = Kost::count();
        $kamarKosong    = Kamar::where('status', 'Kosong')->count();

        // Penyewa aktif = yang disetujui atau lunas
        $penyewaAktif   = Penyewa::whereIn('status', ['disetujui', 'lunas'])->count();

        // Pendapatan dari penyewa yang lunas atau disetujui
        $pendapatan = Penyewa::join('kosts', 'penyewas.kost_id', '=', 'kosts.id')
            ->whereIn('penyewas.status', ['lunas', 'disetujui'])
            ->sum('kosts.harga');

        // Booking terbaru dari data nyata
        $bookings = Penyewa::with(['user', 'kost', 'kamar'])
            ->latest()
            ->take(7)
            ->get();

        // Data pendapatan per bulan untuk chart (tahun ini)
        $tahun = date('Y');
        $pendapatanBulanan = Penyewa::join('kosts', 'penyewas.kost_id', '=', 'kosts.id')
            ->whereIn('penyewas.status', ['lunas', 'disetujui'])
            ->whereYear('penyewas.created_at', $tahun)
            ->selectRaw('MONTH(penyewas.created_at) as bulan, SUM(kosts.harga) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Pastikan semua 12 bulan ada nilainya
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[$i] = $pendapatanBulanan[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalKost',
            'kamarKosong',
            'penyewaAktif',
            'pendapatan',
            'bookings',
            'chartData',
            'tahun'
        ));
    }
}