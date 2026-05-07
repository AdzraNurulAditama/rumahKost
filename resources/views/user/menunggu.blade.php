@extends('layouts.app')

@section('content')

@php
    $nomorWa = "6282179929901";
@endphp

<div class="flex items-center justify-center h-screen bg-gray-50">
    
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full text-center">

        <div class="w-20 h-20 mx-auto mb-5 bg-green-100 rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 text-green-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-blue-600 mb-4">
            Lanjutkan di WhatsApp
        </h1>

        <p class="text-gray-600 mb-6 leading-relaxed">
            Permintaan sewa kamu berhasil dikirim.
            Silakan lanjutkan pembayaran dan konfirmasi melalui WhatsApp pemilik kost.
        </p>

        <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded-xl text-sm">
            Kamu akan diarahkan otomatis ke WhatsApp...
        </div>

    </div>

</div>

<script>
setTimeout(() => {
    window.location.href = "https://wa.me/{{ $nomorWa }}";
}, 1000);
</script>

@endsection