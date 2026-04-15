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
        
        {{-- SIDEBAR --}}
        <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">
            
            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php
                        $displayUsername = $user->username ?? $user->email ?? 'User';
                    @endphp
                    
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                            class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}"
                            class="w-full h-full rounded-full object-cover border-2 border-white">
                    @endif
                </div>

                <h3 class="font-bold text-gray-800 text-sm">
                    {{ $user->username ?? 'User' }}
                </h3>

                <p class="text-[10px] text-gray-400">
                    {{ $user->email ?? '' }}
                </p>
            </div>

            <nav class="space-y-6 px-2">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase mb-3 px-2">Aktivitas</p>

                    <a href="{{ route('user.transaksi') }}" class="menu">Daftar Transaksi</a>

                    <a href="{{ route('user.disukai') }}" class="menu active">Disukai</a>

                    <a href="{{ route('user.kosan.saya') }}" class="menu">Kosan Saya</a>

                    {{-- ✅ FIX DI SINI --}}
                    <a href="{{ route('user.ulasan') }}" class="menu">Ulasan</a>

                    <a href="#" class="menu">Pesan</a>
                </div>

                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase mb-3 px-2">Akun</p>

                    <a href="{{ route('user.profile') }}" class="menu">Akun</a>

                    <a href="/user/chat" class="menu">Notifikasi</a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="menu text-red-500">Keluar</button>
                    </form>
                </div>
            </nav>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 bg-white rounded-[32px] p-10">

            <h2 class="text-2xl font-bold mb-6">Disukai</h2>

            <div class="grid md:grid-cols-3 gap-6">

            @forelse($likes as $like)
                <div class="border rounded-2xl overflow-hidden">

                    @php $img = $like->kost->images->first(); @endphp

                    @if($img)
                        <img src="{{ asset('images/kost/' . $img->image) }}" class="w-full h-40 object-cover">
                    @endif
                    
                    <div class="p-4">
                        <h3 class="font-bold">{{ $like->kost->nama }}</h3>

                        <p class="text-xs text-gray-400">{{ $like->kost->alamat }}</p>

                        <div class="flex justify-between mt-3">
                            <span class="text-red-400 text-xs">❤️ Disukai</span>

                            <a href="{{ route('kost.detail', $like->kost->id) }}"
                               class="text-blue-600 text-xs">Detail</a>
                        </div>
                    </div>
                </div>

            @empty
                <p class="col-span-3 text-center text-gray-400">Belum ada kost</p>
            @endforelse

            </div>

        </div>

    </div>
</div>
@endsection