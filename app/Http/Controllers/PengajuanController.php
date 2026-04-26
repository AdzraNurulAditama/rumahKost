<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // ======================
    // HALAMAN AJUKAN SEWA
    // ======================
    public function show($id)
    {
        $kost = Kost::with('kamars')->findOrFail($id);

        $kamarsKosong = Kamar::where('kost_id', $id)
            ->where('status', 'Kosong')
            ->get()
            ->groupBy('tipe_kamar');

        return view('user.pengajuan', compact('kost', 'kamarsKosong'));
    }

    // ======================
    // SIMPAN PENGAJUAN
    // ======================
    public function create(Request $request, $id)
    {
        // 🔥 VALIDASI (BIAR JELAS ERRORNYA)
        $request->validate([
            'kamar_id'     => 'required|exists:kamars,id',
            'jumlah_orang' => 'required|integer|min:1|max:2',
            'tgl_masuk'    => 'required|date',
        ], [
            'kamar_id.required' => 'Pilih kamar dulu!',
            'tgl_masuk.required' => 'Tanggal harus diisi!',
        ]);

        $kost = Kost::findOrFail($id);
        $kamar = Kamar::findOrFail($request->kamar_id);

        // 🔥 CEK STATUS KAMAR
        if ($kamar->status !== 'Kosong') {
            return back()->with('error', 'Kamar sudah tidak tersedia');
        }

        // 🔥 SIMPAN KE DB
        $penyewa = Penyewa::create([
            'user_id'      => Auth::id(),
            'kost_id'      => $kost->id,
            'kamar_id'     => $request->kamar_id,
            'jumlah_orang' => $request->jumlah_orang,
            'tgl_masuk'    => $request->tgl_masuk,
            'status'       => 'menunggu',
        ]);

        // 🔥 UPDATE STATUS KAMAR
        $kamar->update([
            'status' => 'Terisi'
        ]);

        // 🔥 REDIRECT
        return redirect('/menunggu-persetujuan')
            ->with('success', 'Pengajuan berhasil!');
    }

    // ======================
    // HALAMAN MENUNGGU
    // ======================
    public function status($id)
    {
        $pengajuan = Penyewa::with('kost')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.menunggu', compact('pengajuan'));
    }

    // ======================
    // BATALKAN PENGAJUAN
    // ======================
    public function batal($id)
    {
        $penyewa = Penyewa::where('user_id', Auth::id())->findOrFail($id);

        if ($penyewa->kamar_id) {
            Kamar::where('id', $penyewa->kamar_id)
                ->update(['status' => 'Kosong']);
        }

        $penyewa->delete();

        return redirect()->route('home')
            ->with('success', 'Pengajuan dibatalkan');
    }

    // ======================
    // RIWAYAT SEWA
    // ======================
    public function riwayat()
    {
        $penyewas = Penyewa::with('kost.images')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.sewa', compact('penyewas'));
    }
}