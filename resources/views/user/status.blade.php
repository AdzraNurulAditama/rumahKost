@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10 text-center">

    <h2 class="text-xl font-bold mb-4">
        Status Pengajuan
    </h2>

    <p class="mb-6">
        Status: {{ $pengajuan->status }}
    </p>

    <a href="{{ route('user.pembayaran.index', $pengajuan->id) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-xl">
       Bayar Sekarang
    </a>

</div>

@endsection