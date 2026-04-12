<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Penyewa;

class MidtransController extends Controller
{
    public function callback(Request $request)
{
    \Log::info('CALLBACK MASUK', [$request->all()]);
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false;

    try {
        $notification = new Notification();

        // 🔐 VALIDASI SIGNATURE
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', 
            $notification->order_id .
            $notification->status_code .
            $notification->gross_amount .
            $serverKey
        );

        if ($hashed !== $notification->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        // 🧠 parsing order_id
        $parts = explode('-', $orderId);

        if (count($parts) < 2) {
            return response()->json(['message' => 'Format order_id salah'], 400);
        }

        $sewaId = $parts[1];
        $sewa = Penyewa::find($sewaId);

        if (!$sewa) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // 📊 update status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $sewa->update(['status' => 'lunas']);
            }
        } elseif ($transactionStatus == 'settlement') {
            $sewa->update(['status' => 'lunas']);
        } elseif ($transactionStatus == 'pending') {
            $sewa->update(['status' => 'menunggu']);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $sewa->update(['status' => 'gagal']);
        }

        // 🪵 log
        \Log::info('Midtrans Callback:', (array)$notification);

        return response()->json(['message' => 'Callback Berhasil']);

    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
}
