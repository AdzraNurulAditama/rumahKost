<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::with(['user', 'kost', 'kamar'])->latest()->paginate(5);
        return view('admin.penyewa.index', compact('penyewas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak'
        ]);

        $penyewa = Penyewa::findOrFail($id);
        $statusLama = $penyewa->status;

        $penyewa->update(['status' => $request->status]);

        // ✅ Update status kamar otomatis
        if ($request->status === 'disetujui' && $penyewa->kamar_id) {
            Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'Terisi']);
        }

        if (in_array($request->status, ['ditolak', 'menunggu']) && $penyewa->kamar_id) {
            Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'Kosong']);
        }

        return back()->with('success', 'Status penyewa berhasil diupdate');
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::findOrFail($id);

        if ($penyewa->kamar_id) {
            Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'Kosong']);
        }

        $penyewa->delete();
        return back()->with('success', 'Penyewa berhasil dihapus');
    }

    public function kosanSaya()
    {
        $penyewas = Penyewa::with(['kost', 'kost.images', 'kamar'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.kosan_saya', compact('penyewas'));
    }
}