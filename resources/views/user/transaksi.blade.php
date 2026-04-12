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
    <span class="text-sm font-bold text-blue-600">Transaksi</span>
</div>

<div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">

{{-- SIDEBAR --}}
<div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">

<div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">

@php
$displayUsername = $user->username ?? $user->email ?? 'User';
@endphp

<div class="w-16 h-16 mb-3">

@if($user->photo)
<img src="{{ asset('storage/' . $user->photo) }}"
class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm">
@else
<img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=DBEAFE&color=2563EB&size=128"
class="w-full h-full rounded-full object-cover border-2 border-white">
@endif

</div>

<h3 class="font-bold text-gray-800 text-sm">
{{ $displayUsername }}
</h3>

<p class="text-[10px] text-gray-400 break-all">
{{ $user->email }}
</p>

</div>

{{-- MENU --}}
<nav class="space-y-6 px-2">

{{-- AKTIVITAS --}}
<div>

<p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">
Aktivitas
</p>

<div class="space-y-1">

<a href="{{ route('user.transaksi') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px]
{{ request()->routeIs('user.transaksi') 
? 'text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold'
: 'text-gray-600 hover:bg-white/50 rounded-xl' }}">
<i class="fa-solid fa-clipboard-list w-4 {{ request()->routeIs('user.transaksi') ? 'text-blue-500' : 'text-gray-500' }}"></i>
Daftar Transaksi
</a>

<a href="{{ route('user.disukai') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px]
{{ request()->routeIs('user.disukai') 
? 'text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold'
: 'text-gray-600 hover:bg-white/50 rounded-xl' }}">
<i class="fa-solid fa-heart w-4 text-gray-500"></i>
Disukai
</a>

<a href="{{ route('user.kosan.saya') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px]
{{ request()->routeIs('user.kosan.saya') 
? 'text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold'
: 'text-gray-600 hover:bg-white/50 rounded-xl' }}">
<i class="fa-solid fa-house w-4 text-gray-500"></i>
Kosan Saya
</a>

{{-- ✅ FIX: Ulasan sudah ada route --}}
<a href="{{ route('user.ulasan') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px]
{{ request()->routeIs('user.ulasan') 
? 'text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold'
: 'text-gray-600 hover:bg-white/50 rounded-xl' }}">
<i class="fa-solid fa-star w-4 text-gray-500"></i>
Ulasan
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 rounded-xl">
<i class="fa-solid fa-comment-dots w-4 text-gray-500"></i>
Pesan
</a>

</div>
</div>

{{-- AKUN --}}
<div>

<p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">
Akun
</p>

<div class="space-y-1">

<a href="{{ route('user.profile') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px]
{{ request()->routeIs('user.profile') 
? 'text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold'
: 'text-gray-600 hover:bg-white/50 rounded-xl' }}">
<i class="fa-solid fa-user w-4"></i>
Akun
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 rounded-xl">
<i class="fa-solid fa-bell w-4 text-gray-500"></i>
Notifikasi
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 rounded-xl">
<i class="fa-solid fa-credit-card w-4 text-gray-500"></i>
Pembayaran
</a>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit"
class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 rounded-xl">
<i class="fa-solid fa-right-from-bracket w-4 text-red-400"></i>
Keluar
</button>
</form>

</div>
</div>

</nav>
</div>

{{-- MAIN CONTENT --}}
<div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10">

<h2 class="text-2xl font-black text-gray-800">Riwayat Transaksi</h2>
<hr class="border-gray-100 mb-8">

{{-- FILTER --}}
<div class="bg-gray-50 p-6 rounded-2xl mb-8">

<div class="mb-4">
<div class="relative">
<i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

<input type="text"
placeholder="Cari nama kos"
class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

<div>
<p class="text-sm text-gray-600 mb-1">Dari</p>
<input type="date"
class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
</div>

<div>
<p class="text-sm text-gray-600 mb-1">Sampai</p>
<input type="date"
class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
</div>

</div>
</div>

@if($transaksis->count() == 0)

<div class="flex flex-col items-center justify-center py-20 text-center">

<img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png"
class="w-40 mb-6 opacity-80">

<h3 class="text-lg font-bold text-gray-700">
Belum ada transaksi baru.
</h3>

</div>

@else

<div class="space-y-4">

@foreach($transaksis as $t)

<div class="border border-gray-100 rounded-2xl p-6 shadow-sm">

<div class="flex justify-between items-center mb-2">

<h3 class="font-bold text-gray-800 text-lg">
{{ $t->nama_kost }}
</h3>

<span class="px-3 py-1 text-xs rounded-full
@if($t->status == 'disetujui') bg-green-100 text-green-600
@elseif($t->status == 'ditolak') bg-red-100 text-red-600
@else bg-yellow-100 text-yellow-600
@endif
">
{{ ucfirst($t->status) }}
</span>

</div>

<p class="text-sm text-gray-500">
{{ date('d M Y', strtotime($t->tanggal_mulai)) }}
-
{{ date('d M Y', strtotime($t->tanggal_selesai)) }}
</p>

<p class="text-sm font-semibold text-gray-700 mt-1">
Rp {{ number_format($t->harga,0,',','.') }}
</p>

</div>

@endforeach

</div>

@endif

</div>

</div>
</div>
@endsection