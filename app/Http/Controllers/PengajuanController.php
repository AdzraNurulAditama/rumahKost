<?php
    namespace App\Http\Controllers;
    
    use App\Models\Kost;
    use App\Models\Kamar;
    use App\Models\Penyewa;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Midtrans\Snap;
    use Midtrans\Config;

    class PengajuanController extends Controller
    {
        public function show($id)
        {
            $kost = Kost::with('kamars')->findOrFail($id);

            // ✅ TAMBAH: Ambil kamar kosong, group by tipe
            $kamarsKosong = Kamar::where('kost_id', $id)
                                ->where('status', 'Kosong')
                                ->get()
                                ->groupBy('tipe_kamar');

            return view('user.pengajuan', compact('kost', 'kamarsKosong'));
        }

        public function create(Request $request, $id)
        {
            $kost = Kost::findOrFail($id);

            $request->validate([
                'jumlah_orang' => 'required|integer|min:1|max:2',
                'tgl_masuk'    => 'required|date|after_or_equal:today',
                'kamar_id'     => 'required|exists:kamars,id', // ✅ TAMBAH
            ]);

            // ✅ TAMBAH: Cek kamar masih kosong
            $kamar = Kamar::findOrFail($request->kamar_id);
            if ($kamar->status !== 'Kosong') {
                return back()->with('error', 'Kamar sudah tidak tersedia, pilih kamar lain.');
            }

            $penyewa = Penyewa::create([
                'user_id'      => Auth::id(),
                'kost_id'      => $kost->id,
                'kamar_id'     => $request->kamar_id, // ✅ TAMBAH
                'jumlah_orang' => $request->jumlah_orang,
                'tgl_masuk'    => $request->tgl_masuk,
                'status'       => 'menunggu',
            ]);

            return redirect()->route('user.pengajuan.status', $penyewa->id)
                            ->with('success', 'Pengajuan berhasil dikirim, mohon tunggu konfirmasi admin.');
        }

        public function status($id)
        {
            $pengajuan = Penyewa::with('kost')
                ->where('user_id', Auth::id())
                ->findOrFail($id); 
        
            if ($pengajuan->status == 'menunggu') {
                return view('user.menunggu', compact('pengajuan'));
            }

            $sewa = $pengajuan;
            $snapToken = $this->generateSnapToken($sewa, $pengajuan->kost);

            return view('user.pembayaran.index', compact('pengajuan', 'sewa', 'snapToken'));
        }

        private function generateSnapToken($sewa, $kost)
        {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;
        
            $user = Auth::user();
            $harga = (int) $kost->harga;
        
            $params = [
                'transaction_details' => [
                    'order_id'     => 'SEWA-' . $sewa->id . '-' . time(),
                    'gross_amount' => $harga,
                ],
                'customer_details' => [
                    'first_name' => $user->username ?? $user->name ?? 'Penyewa',
                    'email'      => $user->email,
                    'phone'      => $user->nomor_telepon ?? '08123456789',
                ],
                'item_details' => [
                    [
                        'id'       => 'KOST-' . $kost->id,
                        'price'    => $harga,
                        'quantity' => 1,
                        'name'     => substr('Sewa Kost: ' . $kost->nama, 0, 50),
                    ]
                ],
            ];
        
            return Snap::getSnapToken($params);
        }

        public function batal($id)
        {
            $penyewa = Penyewa::where('user_id', Auth::id())->findOrFail($id);

            // ✅ TAMBAH: Kembalikan kamar ke Kosong
            if ($penyewa->kamar_id) {
                Kamar::where('id', $penyewa->kamar_id)->update(['status' => 'Kosong']);
            }

            $penyewa->delete();
            return redirect()->route('home')->with('success', 'Pengajuan berhasil dibatalkan');
        }

        public function riwayat()
        {
            $penyewas = Penyewa::with('kost.images')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();

            return view('user.sewa', compact('penyewas'));
        }
    }