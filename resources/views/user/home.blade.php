@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- List Kost --}}
    <div class="flex flex-col gap-10"> {{-- Gap diperbesar agar jarak antar item kost lebih lega --}}
        @forelse ($kosts as $kost)
        
            {{-- Wrapper untuk Judul Luar & Card --}}
            <div class="flex flex-col">
                
                {{-- Judul Besar di Atas Card --}}
                <h1 class="text-2xl font-bold text-gray-900 mb-4 ml-1">
                    {{ $kost->nama }}
                </h1>

                {{-- Card Kost --}}
                <a href="{{ route('kost.detail', $kost->id) }}" class="block">
                    <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col md:flex-row gap-6 relative shadow-[0_2px_15px_rgba(0,0,0,0.04)] hover:shadow-md transition">

                        {{-- Badge Tipe Kost (Putra/Putri) --}}
                        @if(str_contains(strtolower($kost->nama), 'ryu') || (isset($kost->tipe) && strtolower($kost->tipe) == 'putri'))
                            <span class="absolute top-5 right-5 bg-pink-400 text-white text-[10px] font-bold px-4 py-1.5 rounded-full">
                                Putri
                            </span>
                        @else
                            <span class="absolute top-5 right-5 bg-blue-600 text-white text-[10px] font-bold px-4 py-1.5 rounded-full">
                                Putra
                            </span>
                        @endif

                        {{-- IMAGE (Kotak Abu-abu di kiri) --}}
                        <div class="w-full md:w-[280px] h-[240px] bg-gray-200 rounded-lg shrink-0 overflow-hidden">
                            @php
                                $firstImage = $kost->images->first();
                            @endphp
                            
                            @if($firstImage)
                                <img src="{{ asset('images/kost/' . $firstImage->image) }}" alt="{{ $kost->nama }}" class="w-full h-full object-cover">
                            @endif
                        </div>

                        {{-- INFO CONTENT (Kanan) --}}
                        <div class="flex-1 flex flex-col pt-1 pr-16 md:pr-24">
                            
                            {{-- Judul Dalam Card & Premium --}}
                            <div class="mb-2">
                                <h2 class="text-xl font-bold text-gray-900 tracking-tight leading-none mb-1">
                                    {{ $kost->nama }}
                                </h2>
                                <p class="text-orange-400 text-[11px] font-semibold">Premium</p>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center gap-1 text-gray-400 text-[11px] mb-4">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $kost->lokasi ?? 'Karawang barat' }}
                            </div>
                            
                            {{-- Fasilitas (Teks Sambung) --}}
                            <div class="mb-3">
                                <p class="text-[10px] font-bold text-gray-800 mb-0.5">Fasilitas</p>
                                <p class="text-[10px] text-gray-400">
                                    {{ implode(' - ', (array) $kost->fasilitas) }}
                                </p>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4">
                                <p class="text-[10px] font-bold text-gray-800 mb-0.5">Deskripsi</p>
                                <p class="text-[10px] text-gray-400 leading-relaxed line-clamp-4 text-justify pr-4">
                                    {{ $kost->deskripsi ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' }}
                                </p>
                            </div>

                            {{-- Harga --}}
                            <div class="mt-auto">
                                <h3 class="text-xl font-bold text-gray-900 tracking-tight">
                                    Rp. {{ number_format($kost->harga, 0, ',', '.') }}
                                </h3>
                            </div>

                        </div>
                    </div>
                </a>

            </div>

        @empty
            <div class="text-center py-20 text-gray-400">
                <i class="fa fa-search text-4xl mb-4"></i>
                <p>Tidak ada kost ditemukan.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection