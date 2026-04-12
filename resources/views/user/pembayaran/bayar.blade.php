@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-16 bg-white shadow-lg rounded-xl p-8 text-center">

    <h1 class="text-2xl font-bold text-green-600 mb-4">
        Pembayaran Berhasil Dikirim
    </h1>

    <p class="text-gray-600 mb-6">
        Bukti pembayaran kamu sudah kami terima dan sedang menunggu verifikasi admin.
    </p>

    <div class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
        <p><b>Nama Penyewa:</b> {{ $sewa->nama }}</p>
        <p><b>Kost:</b> {{ $sewa->kost->nama ?? '-' }}</p>
        <p><b>Status:</b> <span class="text-yellow-600 font-semibold">Menunggu Verifikasi</span></p>
    </div>

    <a href="{{ route('user.sewa') }}"
       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
       Kembali ke Riwayat Sewa
    </a>

</div>

@endsection