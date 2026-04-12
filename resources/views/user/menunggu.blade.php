@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold mb-8 text-center">Menunggu Persetujuan Pemilik</h1>

    {{-- STEP PROGRESS --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex flex-col items-center text-blue-600">
            <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-sm mt-2">Ajukan sewa</p>
        </div>
        <div class="flex-1 h-1 bg-blue-600"></div>

        <div class="flex flex-col items-center text-blue-600">
            <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                </svg>
            </div>
            <p class="text-sm mt-2">Menunggu persetujuan</p>
        </div>
        <div class="flex-1 h-1 bg-gray-300"></div>

        <div class="flex flex-col items-center text-gray-400">
            <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-white"></div>
            <p class="text-sm mt-2">Bayar sewa pertama</p>
        </div>
        <div class="flex-1 h-1 bg-gray-300"></div>

        <div class="flex flex-col items-center text-gray-400">
            <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-white"></div>
            <p class="text-sm mt-2">Check-in</p>
        </div>
    </div>

    {{-- ALERT STATUS --}}
    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-8 flex items-center gap-3">
        <div class="bg-yellow-500 text-white w-6 h-6 flex items-center justify-center rounded-full text-sm font-bold">!</div>
        <span>Pengajuan kamu sedang menunggu persetujuan dari pemilik kost.</span>
    </div>

    {{-- INFORMASI PENGAJUAN --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Detail Pengajuan</h2>
        <div class="space-y-4 text-sm">
            <div>
                <p class="text-gray-500">Nama Kost</p>
                <p class="font-semibold">{{ $pengajuan->kost->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Alamat</p>
                <p class="font-semibold">{{ $pengajuan->kost->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Jumlah Penghuni</p>
                <p class="font-semibold">{{ $pengajuan->jumlah_orang ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Tanggal Masuk</p>
                <p class="font-semibold">{{ \Carbon\Carbon::parse($pengajuan->tgl_masuk)->format('d M Y') ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Harga</p>
                <p class="font-semibold">
                    Rp {{ $pengajuan->kost->harga ? number_format($pengajuan->kost->harga) : 'Harga belum tertera' }}
                </p>
            </div>
        </div>
    </div>

    {{-- BUTTON BATALKAN --}}
    <div class="text-center">
        <form action="{{ route('user.pengajuan.batal', $pengajuan->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                Batalkan Pengajuan
            </button>
        </form>
    
    </div>

</div>

@endsection