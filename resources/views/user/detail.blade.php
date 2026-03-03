@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 font-sans text-gray-800">

    {{-- Galeri Foto --}}
    <div class="mb-6">
        {{-- Foto Utama --}}
        <div class="w-full h-[300px] md:h-[400px] bg-gray-200 rounded-xl mb-4">
            @if($kost->images && $kost->images->count())
                <img src="{{ asset('storage/' . $kost->images->first()->path) }}" class="w-full h-full object-cover rounded-xl" alt="Foto Utama">
            @endif
        </div>
        
        {{-- Thumbnail Bawah --}}
        <div class="grid grid-cols-3 gap-4 h-[120px] md:h-[150px]">
            <div class="bg-gray-200 rounded-xl w-full h-full object-cover"></div>
            <div class="bg-gray-200 rounded-xl w-full h-full object-cover"></div>
            <div class="bg-gray-200 rounded-xl w-full h-full relative">
                <button class="absolute bottom-3 right-3 bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Foto
                </button>
            </div>
        </div>
    </div>

    {{-- Tabs Foto / Video --}}
    <div class="flex gap-3 mb-6">
        <button class="flex items-center gap-2 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Foto
        </button>
        <button class="flex items-center gap-2 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Video
        </button>
    </div>

    {{-- Header Content (Judul & Aksi) --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-3xl font-bold">{{ $kost->nama }}</h1>
                <span class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">Putra</span>
            </div>
            <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Premium</a>
        </div>
        <div class="flex gap-4 items-center text-blue-600">
            <button class="hover:text-red-500 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></button>
            <button class="hover:text-blue-800 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
        </div>
    </div>

    {{-- Info Bar (Lokasi & Rating) --}}
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-8 pb-6 border-b">
        <div class="flex items-center gap-1">
            <span>📍</span> {{ $kost->lokasi }}
        </div>
        <div class="flex items-center gap-1">
            <span>🚪</span> 20 Kamar Tersedia
        </div>
        <div class="flex items-center gap-1 text-yellow-400">
            ★★★★★ <span class="text-gray-800 font-bold ml-1">5.0</span>
        </div>
    </div>

    {{-- Main Grid Content --}}
    <div class="grid md:grid-cols-3 gap-10">

        {{-- Kiri (Detail) --}}
        <div class="md:col-span-2">
            
            {{-- Deskripsi --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-3">Deskripsi</h2>
                <p class="text-gray-600 leading-relaxed text-sm text-justify">
                    {{ $kost->deskripsi ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}
                </p>
            </div>

            {{-- Spesifikasi Tipe Kamar --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Spesifikasi Tipe Kamar</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">📏</span>
                        3.6 x 2.4 meter
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">⚡</span>
                        Tidak termasuk listrik
                    </div>
                </div>
            </div>

            {{-- Fasilitas Kamar --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Fasilitas Kamar</h2>
                <div class="grid grid-cols-2 gap-y-4 text-sm text-gray-600">
                    {{-- Ini bisa diubah pakai @foreach jika data dinamis --}}
                    <div class="flex items-center gap-3"><span>❄️</span> AC</div>
                    <div class="flex items-center gap-3"><span>🛏️</span> Kasur</div>
                    <div class="flex items-center gap-3"><span>🪑</span> Meja</div>
                    <div class="flex items-center gap-3"><span>📺</span> TV</div>
                    <div class="flex items-center gap-3"><span>🚪</span> Lemari</div>
                    <div class="flex items-center gap-3"><span>🪟</span> Jendela</div>
                    <div class="flex items-center gap-3"><span>🛋️</span> Bantal</div>
                    <div class="flex items-center gap-3"><span>🪑</span> Kursi</div>
                    <div class="flex items-center gap-3"><span>🥖</span> Guling</div>
                </div>
            </div>

            {{-- Fasilitas Kamar Mandi --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Fasilitas Kamar Mandi</h2>
                <div class="grid grid-cols-2 gap-y-4 text-sm text-gray-600">
                    <div class="flex items-center gap-3"><span>🛁</span> K. Mandi Dalam</div>
                    <div class="flex items-center gap-3"><span>🚽</span> Kloset Duduk</div>
                    <div class="flex items-center gap-3"><span>🚿</span> Shower</div>
                    <div class="flex items-center gap-3"><span>♨️</span> Air panas</div>
                </div>
            </div>

            {{-- Peraturan Khusus --}}
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Peraturan Khusus Kamar ini</h2>
                <div class="flex flex-col gap-3 text-sm text-gray-600">
                    <div class="flex items-center gap-3"><span>⚠️</span> Tamu menginap dikenakan biaya</div>
                    <div class="flex items-center gap-3"><span>👥</span> Tipe ini bisa diisi maks. 2 orang/kamar</div>
                    <div class="flex items-center gap-3"><span>🚫</span> Tidak untuk pasutri</div>
                    <div class="flex items-center gap-3"><span>🚷</span> Tidak boleh bawa anak</div>
                    <div class="flex justify-between items-start mt-2">
                        <div class="flex items-start gap-3">
                            <span>💰</span>
                            <div>
                                <p class="font-medium text-gray-800">Deposit</p>
                                <p class="text-xs text-gray-500">Dikembalikan di akhir periode sewa jika tidak ditemukan kerusakan</p>
                            </div>
                        </div>
                        <span class="font-medium text-gray-800">Rp300.000</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Kanan (Card Pemesanan) --}}
        <div>
            <div class="bg-white p-5 rounded-2xl shadow-[0_0_15px_rgba(0,0,0,0.05)] border border-gray-100 sticky top-6">
                
                {{-- Harga & Diskon --}}
                <div class="mb-4 border-b pb-4">
                    <div class="flex items-center gap-2 mb-1 text-sm">
                        <span class="bg-yellow-100 text-yellow-700 font-semibold px-2 py-0.5 rounded text-xs flex items-center gap-1">
                            % Diskon 69rb
                        </span>
                        <span class="text-gray-400 line-through">Rp. 2.325.000</span>
                    </div>
                    <div class="flex items-end gap-1 mb-3">
                        <h3 class="text-2xl font-bold">Rp. 2.256.000</h3>
                        <span class="text-xs text-gray-500 mb-1">(bulan pertama)</span>
                    </div>

                    {{-- Pilihan Pembayaran --}}
                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div>
                            <p class="text-[10px] text-gray-500 mb-1">Pembayaran</p>
                            <select class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 text-blue-600 bg-white">
                                <option>dd/mm/yy</option>
                            </select>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 mb-1">&nbsp;</p>
                            <select class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 text-white bg-blue-600 outline-none">
                                <option>Per Tahun</option>
                                <option>Per Bulan</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Box Kalkulasi Pembayaran --}}
                <div class="border border-gray-100 rounded-xl p-4 mb-4 text-xs text-gray-600 bg-gray-50/50">
                    <p class="mb-2 font-medium">Jika kamu bayar pakai DP:</p>
                    <div class="flex justify-between mb-1">
                        <span class="underline decoration-dotted cursor-pointer">Uang muka (DP)</span>
                        <span>Rp705.000</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="underline decoration-dotted cursor-pointer">Pelunasan</span>
                        <span>Rp1.881.000</span>
                    </div>

                    <p class="mb-2 font-medium">Jika kamu pakai pembayaran penuh:</p>
                    <div class="flex justify-between mb-4">
                        <span class="underline decoration-dotted cursor-pointer">Pembayaran Penuh</span>
                        <span>Rp2.571.000</span>
                    </div>

                    <div class="border-t border-dashed pt-3 flex justify-between font-bold text-gray-800 text-sm mt-2">
                        <span>Total Pembayaran Pertama</span>
                        <span>Rp2.571.000</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-3">
                    <button class="w-full border border-blue-600 text-blue-600 font-medium py-2.5 rounded-xl hover:bg-blue-50 transition flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Tanya Pemilik
                    </button>
                    <button class="w-full bg-blue-600 text-white font-medium py-2.5 rounded-xl hover:bg-blue-700 transition text-sm">
                        Ajukan Sewa
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection