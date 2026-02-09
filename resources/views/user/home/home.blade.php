@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="relative rounded-3xl overflow-hidden h-72 flex items-center justify-center">
        <img src="{{ asset('images/hero-bg.jpg') }}" class="absolute inset-0 w-full h-full object-cover brightness-50">
        <div class="relative text-center text-white">
            <h1 class="text-5xl font-bold mb-2 italic">Rumah<span class="text-orange-300">Kost</span></h1>
            <p class="text-xl font-light mb-8">Kosan nyaman & Strategis di Karawang</p>
            <div class="flex justify-center gap-16 text-center">
                <div>
                    <span class="block text-3xl font-bold">3</span>
                    <span class="text-xs">Pilihan kosan</span>
                </div>
                <div class="border-l border-white/30 px-16">
                    <span class="block text-3xl font-bold italic">Karawang</span>
                    <span class="text-xs">Lokasi Strategis</span>
                </div>
                <div class="border-l border-white/30 pl-16">
                    <span class="block text-3xl font-bold">100</span>
                    <span class="text-xs">Penghuni Puas</span>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER BUTTON --}}
    <button class="mt-8 px-6 py-2 border border-blue-400 text-blue-500 rounded-xl flex items-center gap-2 font-medium hover:bg-blue-50">
        <i class="fa fa-sliders"></i> Filter Kost
    </button>

    {{-- LIST KOST --}}
    <div class="mt-12 space-y-20">
        @foreach($kosts as $kost)
        <div>
            {{-- JUDUL DENGAN GARIS --}}
            <div class="flex items-center gap-4 mb-6">
                <h2 class="text-3xl font-extrabold text-blue-600 whitespace-nowrap">
                    {{ strtoupper($kost->nama) }} <span class="text-orange-400">ATA</span>
                </h2>
                <div class="h-[1px] bg-gray-300 w-full"></div>
            </div>

            {{-- CARD --}}
            <a href="{{ route('kost.detail', $kost->id) }}" class="block group">
                <div class="bg-white rounded-[40px] shadow-sm border p-6 flex flex-col md:flex-row gap-8 group-hover:shadow-md transition">
                    {{-- GAMBAR --}}
                    <div class="w-full md:w-[400px] h-64 overflow-hidden rounded-[30px]">
                        <img src="{{ asset('storage/'.$kost->gambar) }}" class="w-full h-full object-cover">
                    </div>

                    {{-- DETAIL --}}
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">{{ $kost->nama }}</h3>
                            <p class="text-sm text-gray-500 flex items-start gap-2 mb-4">
                                <i class="fa fa-map-marker-alt mt-1"></i>
                                {{ $kost->alamat }}
                            </p>

                            {{-- BADGE FASILITAS --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach($kost->fasilitas as $f)
                                <span class="text-[10px] bg-gray-100 text-gray-700 px-3 py-1.5 rounded-md border border-gray-200">
                                    {{ $f }}
                                </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- HARGA --}}
                        <div class="text-right">
                            <p class="text-lg font-bold">
                                Rp {{ number_format($kost->harga, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ tahun</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

@endsection