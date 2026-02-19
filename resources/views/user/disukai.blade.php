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
        
        {{-- SIDEBAR KIRI (Tetap Sama) --}}
        <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">
            {{-- User Mini Card --}}
            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php
                        $displayUsername = $user->username ?? $user->email ?? 'User';
                    @endphp
                    
                    {{-- Logika Tampilan Foto --}}
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
                <h3 class="font-bold text-gray-800 text-sm tracking-tight">{{ $user->username ?? 'Kim Seonho' }}</h3>
                <p class="text-[10px] text-gray-400 break-all">{{ $user->email ?? 'Seonho@gmail.com' }}</p>
            </div>

            {{-- Navigasi Menu --}}
            <nav class="space-y-6 px-2">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Aktivitas</p>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 bg-white rounded-xl shadow-sm border border-gray-50">
                            <i class="fa-solid fa-clipboard-list w-4 text-gray-500"></i> Daftar Transaksi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-ticket w-4 text-gray-500"></i> Voucher
                        </a>
                        <a href="{{ route('user.disukai') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-heart w-4 text-gray-500"></i> Disukai
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-house w-4 text-gray-500"></i> Kosan Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-star w-4 text-gray-500"></i> Ulasan
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-comment-dots w-4 text-gray-500"></i> Pesan
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Akun</p>
                    <div class="space-y-1">
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
                            <i class="fa-solid fa-user w-4 text-blue-600"></i> Akun
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-location-dot w-4 text-gray-500"></i> Alamat
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
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

        {{-- MAIN CONTENT KANAN (Disukai Empty State) --}}
        <div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10 flex flex-col">
            <h2 class="text-2xl font-black text-gray-800 mb-6 leading-tight">Disukai</h2>
            <hr class="border-gray-100 mb-4">

            {{-- Empty State Content --}}
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                {{-- Ilustrasi Kost --}}
                <div class="mb-10">
                    {{-- Ganti src dengan path image kamu --}}
                    <img src="{{ asset('images/empty-disukai.png') }}" alt="Belum ada kost" class="w-full max-w-[400px] h-auto">
                </div>

                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Cari Kost-an yang kamu suka dahulu di Beranda
                </h3>
            </div>
        </div>
    </div>
</div>
@endsection