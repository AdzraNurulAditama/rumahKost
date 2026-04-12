<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Kost;

class KelolaKamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::with('kost');

        // ✅ Filter by nama kost kalau ada search
        if ($request->search) {
            $query->whereHas('kost', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $kamars = $query->latest()->paginate(10);

        // ✅ Stat card: kalau ada search, hitung per kost yang dicari
        if ($request->search) {
            $kamarIds = $query->pluck('id');
            $totalKamar  = $query->count();
            $kamarTerisi  = (clone $query)->where('status', 'Terisi')->count();
            $kamarKosong  = (clone $query)->where('status', 'Kosong')->count();
            $kamarNonAktif = (clone $query)->where('status', 'Non-aktif')->count();
        } else {
            $totalKamar   = Kamar::count();
            $kamarTerisi  = Kamar::where('status', 'Terisi')->count();
            $kamarKosong  = Kamar::where('status', 'Kosong')->count();
            $kamarNonAktif = Kamar::where('status', 'Non-aktif')->count();
        }

        $kosts = Kost::all();

        return view('admin.kelolakamar.index', compact(
            'kosts', 'kamars', 'totalKamar', 'kamarTerisi', 'kamarKosong', 'kamarNonAktif'
        ));
    }

    public function create()
    {
        $kosts = Kost::all();
        return view('admin.kelolakamar.create', compact('kosts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kost_id'     => 'required|exists:kosts,id',
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar'  => 'required|string',
            'harga'       => 'required|numeric|min:0',
        ]);

        Kamar::create([
            'kost_id'     => $request->kost_id,
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'status'      => 'Kosong',
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar'  => 'required|string',
            'harga'       => 'required|numeric|min:0',
            'status'      => 'required|string',
        ]);

        $kamar = Kamar::findOrFail($id);
        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'status'      => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kamar::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kamar berhasil dihapus!');
    }

    public static function generateKamar(Kost $kost)
    {
        $kost->kamars()->where('status', 'Kosong')->delete();
        $jumlah = $kost->jumlah_kamar ?? 0;

        for ($i = 1; $i <= $jumlah; $i++) {
            $nomor = 'K' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $exists = Kamar::where('kost_id', $kost->id)->where('nomor_kamar', $nomor)->exists();
            if (!$exists) {
                Kamar::create([
                    'kost_id'     => $kost->id,
                    'nomor_kamar' => $nomor,
                    'tipe_kamar'  => 'Standar',
                    'harga'       => $kost->harga,
                    'status'      => 'Kosong',
                ]);
            }
        }
    }
}