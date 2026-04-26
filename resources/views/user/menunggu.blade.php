@extends('layouts.app')

@section('content')

<div class="flex items-center justify-center h-screen">
    <div class="text-center max-w-md">

        <h1 class="text-2xl font-bold text-blue-600 mb-4">
            Lanjutkan di WhatsApp
        </h1>

        <p class="text-gray-600 mb-6">
            Permintaan sewa kamu sudah dikirim.  
            Silakan lanjutkan pembayaran dan konfirmasi melalui WhatsApp pemilik kost.
        </p>

        <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded-lg text-sm">
            Setelah pembayaran dikonfirmasi, kamu bisa langsung check-in.
        </div>

    </div>
</div>

<script>
setTimeout(() => {
    window.location.href = "/checkin";
}, 3000); // ⏱ 3 detik
</script>

@endsection