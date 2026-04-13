<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function index($id)
    {
        // 1. Ambil data dengan relasi lengkap
        $sewa = Penyewa::with(['kost', 'user'])->findOrFail($id);

        // 2. Tentukan Harga & Nama
        $harga = (int) $sewa->kost->harga;
        $namaKost = $sewa->kost->nama ?? 'Sewa Kost';
        $user = auth()->user();

        // 3. Gunakan order_id yang konsisten (disimpan di session agar tidak berubah tiap refresh)
        $sessionKey = 'snap_order_id_' . $sewa->id;
        $orderId = session($sessionKey);

        if (!$orderId) {
            $orderId = 'SEWA-' . $sewa->id . '-' . time();
            session([$sessionKey => $orderId]);
        }

        // 4. Konfigurasi Midtrans
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $harga,
            ],
            'customer_details' => [
                'first_name' => $user->username ?? 'Penyewa',
                'email'      => $user->email,
                'phone'      => $user->nomor_telepon ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id'       => 'KOST-' . $sewa->kost_id,
                    'price'    => $harga,
                    'quantity' => 1,
                    'name'     => substr('Kost: ' . $namaKost, 0, 50),
                ],
            ],
        ];

        // 5. Generate Snap Token dengan error handling
        $snapToken = null;
        $errorMessage = null;

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Log::error('Midtrans getSnapToken error: ' . $e->getMessage());
            $errorMessage = 'Gagal menghubungi server pembayaran. Silakan coba lagi.';
        }

        return view('user.pembayaran.index', compact('sewa', 'snapToken', 'errorMessage'));
    }
}