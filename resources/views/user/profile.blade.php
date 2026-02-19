@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F4F7FE] py-6 px-8 font-sans">
    
    {{-- BREADCRUMB (Kiri Atas) --}}
    <div class="flex items-center gap-2 mb-8 bg-white w-fit px-4 py-2 rounded-full shadow-sm border border-blue-50">
        <div class="bg-blue-50 p-1.5 rounded-lg">
            <i class="fa-solid fa-house text-blue-600 text-xs"></i>
        </div>
        <span class="text-sm font-medium text-gray-500">Beranda</span>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-sm font-bold text-blue-600">Akun</span>
    </div>

    <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">
        
        {{-- SIDEBAR KIRI (Light Blue Style) --}}
        <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">
            {{-- User Mini Card --}}
            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php
                        $displayUsername = $user->name ?? $user->username ?? $user->email ?? 'User';
                    @endphp
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=DBEAFE&color=2563EB&size=128" 
                         class="w-full h-full rounded-full object-cover border-2 border-white"
                         alt="Avatar">
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
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
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
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
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

        {{-- MAIN CONTENT KANAN --}}
        <div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-black text-gray-800">Akun</h2>
                <button class="p-2 border border-red-50 rounded-lg text-red-400 hover:bg-red-50 transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>
            <hr class="border-gray-100 mb-10">

            <div class="flex flex-col lg:flex-row gap-16">
                {{-- Profile Info (Avatar & Name) --}}
                <div class="w-full lg:w-[260px] flex flex-col items-center">
                    <div class="bg-[#EEF4FF] rounded-[24px] p-8 w-full flex flex-col items-center border border-blue-50">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=FFFFFF&color=2563EB&size=128" 
                             class="w-24 h-24 rounded-full border-4 border-white shadow-sm mb-4"
                             alt="Avatar Central">
                             
                        <div class="text-center">
                            <h4 class="font-bold text-gray-800 text-lg">{{ $user->username ?? 'Kim Seonho' }}</h4>
                            <p class="text-[11px] text-gray-400 tracking-wide">{{ $user->email ?? 'Seonho@gmail.com' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Form Section --}}
                <div class="flex-1 max-w-[500px]">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label class="text-[13px] font-bold text-gray-700">Nama lengkap</label>
                            <input type="text" name="name" value="{{ $user->username ?? 'Kim Seonho' }}" 
                                   class="w-full border-gray-300 border rounded-lg px-4 py-2.5 text-sm text-gray-500 outline-none focus:ring-1 focus:ring-blue-400">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-1.5">
                            <label class="text-[13px] font-bold text-gray-700">Tanggal Lahir</label>
                            <div class="relative">
                                <input type="text" value="8 Mei 1986" class="w-full border-gray-300 border rounded-lg px-4 py-2.5 text-sm text-gray-500 bg-white" readonly>
                                 <i class="fa-solid fa-calendar-days absolute right-4 top-1/2 -translate-y-1/2 text-blue-400 cursor-not-allowed"></i>
                            </div>
                        </div>

                     {{-- Jenis Kelamin --}}
                        <div class="space-y-1.5">
                            <label class="text-[13px] font-bold text-gray-700 block">Jenis Kelamin</label>
                            <div class="flex gap-8 mt-2">
                                
                                {{-- Radio Laki-laki --}}
                                <label class="flex items-center gap-2.5 text-sm cursor-pointer transition {{ $user->jenis_kelamin == 'Laki-laki' ? 'text-blue-600 font-bold' : 'text-gray-400 font-medium' }}">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" 
                                        @checked($user->jenis_kelamin == 'Laki-laki') 
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"> 
                                    Laki-laki
                                </label>

                                {{-- Radio Perempuan --}}
                                <label class="flex items-center gap-2.5 text-sm cursor-pointer transition {{ $user->jenis_kelamin == 'Perempuan' ? 'text-blue-600 font-bold' : 'text-gray-400 font-medium' }}">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" 
                                        @checked($user->jenis_kelamin == 'Perempuan') 
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"> 
                                    Perempuan
                                </label>
                                
                            </div>
                        </div>

                        {{-- Nomor Handphone --}}
                        <div class="space-y-1.5">
                            <label class="text-[13px] font-bold text-gray-700">Nomor handphone</label>
                            <input type="text" value="{{ $user->nomor_telepon ?? '0812-9973-0477' }}" 
                                   class="w-full border-gray-300 border rounded-lg px-4 py-2.5 text-sm text-gray-500 outline-none">
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1.5">
                            <label class="text-[13px] font-bold text-gray-700">Email</label>
                            <input type="email" value="{{ $user->email ?? 'Seonho@gmail.com' }}" 
                                   class="w-full border-gray-300 border rounded-lg px-4 py-2.5 text-sm text-gray-500 outline-none">
                        </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggle(id, iconId) {
        const p = document.getElementById(id);
        const i = document.getElementById(iconId);
        if (p.type === "password") {
            p.type = "text";
            i.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            p.type = "password";
            i.classList.replace('fa-eye', 'fa-eye-slash');
        }
    }
</script>
@endsection