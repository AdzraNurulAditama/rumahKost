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

    // 2. Tentukan Harga & Nama (Gunakan fallback agar tidak kosong)
    $harga = (int) $sewa->kost->harga;
    $namaKost = $sewa->kost->nama ?? 'Sewa Kost';
    $user = auth()->user();

    // 3. Konfigurasi
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => 'SEWA-' . $sewa->id . '-' . time(),
            'gross_amount' => $harga,
        ],
        'customer_details' => [
            // Gunakan ->name jika ->username kosong
            'first_name'    => $user->username ?? $user->username ?? 'Penyewa',
            'email'         => $user->email,
            'phone'         => $user->nomor_telepon ?? '08123456789',
            'shipping_address' => [
                'first_name'   => $user->username ?? $user->username ?? 'Penyewa',
                'email'        => $user->email,
                'phone'        => $user->nomor_telepon ?? '08123456789',
             
            ],
        ],
        'item_details' => [
            [
                'id'       => 'KOST-' . $sewa->kost_id,
                'price'    => $harga,
                'quantity' => 1,
                'name'     => substr("Kost: " . $namaKost, 0, 50),
            ]
        ],
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    return view('user.pembayaran.index', compact('sewa', 'snapToken'));
}
    
  

}