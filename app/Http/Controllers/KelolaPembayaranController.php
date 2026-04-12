<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penyewa;
use App\Models\Kamar;

class KelolaPembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['penyewa', 'kamar'])->latest()->get();
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $penyewas = Penyewa::all();
        $kamars = Kamar::all();

        return view('admin.pembayaran.create', compact('penyewas', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyewa_id' => 'required',
            'kamar_id' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|image|max:2048'
        ]);

        $buktiPath = null;

        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti', 'public');
        }

        Pembayaran::create([
            'penyewa_id' => $request->penyewa_id,
            'kamar_id' => $request->kamar_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'bukti' => $buktiPath,
            'status' => $buktiPath ? 'lunas' : 'menunggu'
        ]);

        return redirect()->route('admin.pembayaran.index');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $penyewas = Penyewa::all();
        $kamars = Kamar::all();

        return view('admin.pembayaran.edit', compact('pembayaran', 'penyewas', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti', 'public');
            $pembayaran->bukti = $buktiPath;
            $pembayaran->status = 'lunas';
        }

        $pembayaran->update([
            'penyewa_id' => $request->penyewa_id,
            'kamar_id' => $request->kamar_id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.pembayaran.index');
    }

    public function destroy($id)
    {
        Pembayaran::destroy($id);
        return back();
    }

   
   
   
   
   
   
}
