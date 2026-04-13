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
        <span class="text-sm font-bold text-blue-600">Ulasan</span>
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

                        <a href="{{ route('user.transaksi') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-clipboard-list w-4 text-gray-500"></i> Daftar Transaksi
                        </a>

                        <a href="{{ route('user.disukai') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-heart w-4 text-gray-500"></i> Disukai
                        </a>

                        <a href="{{ route('user.kosan.saya') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-house w-4 text-gray-500"></i> Kosan Saya
                        </a>

                        {{-- Ulasan (AKTIF) --}}
                        <a href="{{ route('user.ulasan') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
                            <i class="fa-solid fa-star w-4 text-yellow-400"></i> Ulasan
                        </a>

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
                Ulasan Saya
            </h2>

            <hr class="border-gray-100 mb-6">

            {{-- Success / Error Message --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-100 text-green-700 text-sm rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                    {{ session('error') }}
                </div>
            @endif

            @forelse($reviews as $review)
                <div class="border border-gray-100 rounded-2xl p-5 mb-4 hover:shadow-sm transition bg-white">
                    <div class="flex items-start justify-between gap-4">
                        
                        {{-- Info Kost --}}
                        <div class="flex items-center gap-3 flex-1">
                            @php
                                $firstImage = $review->kost->images->first() ?? null;
                            @endphp

                            @if($firstImage)
                                <img src="{{ asset('images/kost/' . $firstImage->image) }}"
                                    class="w-14 h-14 rounded-xl object-cover shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-house text-blue-300 text-lg"></i>
                                </div>
                            @endif

                            <div>
                                <a href="{{ route('kost.detail', $review->kost->id) }}"
                                    class="font-bold text-sm text-gray-800 hover:text-blue-600 transition">
                                    {{ $review->kost->nama }}
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-blue-300"></i>
                                    {{ $review->kost->alamat }}
                                </p>

                                {{-- Rating Bintang --}}
                                <div class="flex items-center gap-0.5 mt-1.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                        @else
                                            <i class="fa-regular fa-star text-gray-200 text-xs"></i>
                                        @endif
                                    @endfor
                                    <span class="text-xs text-gray-400 ml-1">({{ $review->rating }}/5)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal + Hapus --}}
                        <div class="flex flex-col items-end gap-2 shrink-0">
                            <span class="text-[11px] text-gray-400">
                                {{ $review->created_at->format('d M Y') }}
                            </span>
                            <form action="{{ route('review.delete', $review->id) }}" method="POST"
                                onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-[11px] text-red-400 hover:text-red-600 flex items-center gap-1 transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Komentar --}}
                    <div class="mt-4 bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-600 leading-relaxed border border-gray-100">
                        "{{ $review->komentar }}"
                    </div>
                </div>

            @empty
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center flex-1 py-20 text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mb-5">
                        <i class="fa-solid fa-star text-yellow-300 text-3xl"></i>
                    </div>
                    <p class="text-gray-700 font-bold text-lg mb-1">Belum ada ulasan</p>
                    <p class="text-gray-400 text-sm mb-6">Ulasan kamu setelah menyewa kost akan muncul di sini</p>
                    <a href="{{ route('home') }}" 
                        class="bg-blue-600 text-white text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-blue-700 transition">
                        Cari Kost Sekarang
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection