@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F4F7FE] py-6 px-8 font-sans">
    
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 mb-8 bg-white w-fit px-4 py-2 rounded-full shadow-sm border border-blue-50">
        <div class="bg-blue-50 p-1.5 rounded-lg">
            <i class="fa-solid fa-house text-blue-600 text-xs"></i>
        </div>
        <span class="text-sm font-medium text-gray-500">Beranda</span>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-sm font-bold text-blue-600">Disukai</span>
    </div>

    <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">
        
        {{-- SIDEBAR KIRI --}}
        <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">
            
            {{-- User Mini Card --}}
            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php
                        $displayUsername = $user->username ?? $user->email ?? 'User';
                    @endphp
                    
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                            class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm"
                            alt="Avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=DBEAFE&color=2563EB&size=128" 
                            class="w-full h-full rounded-full object-cover border-2 border-white"
                            alt="Avatar">
                    @endif
                </div>

                <h3 class="font-bold text-gray-800 text-sm tracking-tight">
                    {{ $user->username ?? 'User' }}
                </h3>

                <p class="text-[10px] text-gray-400 break-all">
                    {{ $user->email ?? '' }}
                </p>
            </div>

            {{-- Navigasi Menu --}}
            <nav class="space-y-6 px-2">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Aktivitas</p>
                    <div class="space-y-1">

                        {{-- Daftar Transaksi (tidak aktif) --}}
                        <a href="{{ route('user.transaksi') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-clipboard-list w-4 text-gray-500"></i> Daftar Transaksi
                        </a>

                        {{-- Disukai (AKTIF) --}}
                        <a href="{{ route('user.disukai') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
                            <i class="fa-solid fa-heart w-4 text-blue-500"></i> Disukai
                        </a>

                        {{-- Kosan Saya --}}
                        <a href="{{ route('user.kosan.saya') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-house w-4 text-gray-500"></i> Kosan Saya
                        </a>

                        {{-- Ulasan --}}
                        <a href="{{ route('user.ulasan') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-star w-4 text-gray-500"></i> Ulasan
                        </a>

                        {{-- Pesan --}}
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-comment-dots w-4 text-gray-500"></i> Pesan
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Akun</p>
                    <div class="space-y-1">
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-user w-4 text-gray-500"></i> Akun
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-location-dot w-4 text-gray-500"></i> Alamat
                        </a>
                        <a href="/user/chat" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-bell w-4 text-gray-500"></i> Notifikasi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-wallet w-4 text-gray-500"></i> Pembayaran
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition rounded-xl">
                                <i class="fa-solid fa-right-from-bracket w-4 text-red-400"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10 flex flex-col">

            <h2 class="text-2xl font-black text-gray-800 mb-6 leading-tight">
                Disukai
            </h2>

            <hr class="border-gray-100 mb-6">

            <div class="grid md:grid-cols-3 gap-6">

            @forelse($likes as $like)
                <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm bg-white hover:shadow-md transition">

                    @php
                        $firstImage = $like->kost->images->first();
                    @endphp

                    @if($firstImage)
                        <img src="{{ asset('images/kost/' . $firstImage->image) }}"
                            class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-blue-50 flex items-center justify-center">
                            <i class="fa-solid fa-house text-blue-200 text-3xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-bold text-base text-gray-800 mb-1">
                            {{ $like->kost->nama }}
                        </h3>

                        <p class="text-xs text-gray-400 mb-3 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            {{ $like->kost->alamat }}
                        </p>

                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <span class="text-red-400 text-xs font-medium flex items-center gap-1">
                                <i class="fa-solid fa-heart"></i> Disukai
                            </span>

                            <a href="{{ route('kost.detail', $like->kost->id) }}"
                                class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-3 flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mb-5">
                        <i class="fa-solid fa-heart text-red-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-700 font-bold text-lg mb-1">Belum ada kost yang disukai</p>
                    <p class="text-gray-400 text-sm mb-6">Temukan kost favoritmu dan simpan di sini</p>
                    <a href="{{ route('home') }}" 
                        class="bg-blue-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-700 transition">
                        Cari Kost Sekarang
                    </a>
                </div>
            @endforelse

            </div>

        </div>

    </div>
</div>
@endsection