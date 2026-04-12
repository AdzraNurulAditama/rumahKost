@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F4F7FE] py-6 px-8 font-sans">

<div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">

{{-- ================= SIDEBAR ================= --}}
<div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">

{{-- User Mini Card --}}
<div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">

<div class="w-16 h-16 mb-3">

@if(Auth::user()->photo)
<img src="{{ asset('storage/'.Auth::user()->photo) }}" class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm">
@else
<img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username ?? 'User') }}&background=DBEAFE&color=2563EB&size=128"
class="w-full h-full rounded-full object-cover border-2 border-white">
@endif

</div>

<h3 class="font-bold text-gray-800 text-sm tracking-tight">
{{ Auth::user()->username ?? 'User' }}
</h3>

<p class="text-[10px] text-gray-400 break-all">
{{ Auth::user()->email }}
</p>

</div>

{{-- Navigasi Menu --}}
<nav class="space-y-6 px-2">

<div>
<p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">
Aktivitas
</p>

<div class="space-y-1">

<a href="{{ route('user.transaksi') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-clipboard-list w-4 text-gray-500"></i> Daftar Transaksi
</a>

<a href="{{ route('user.disukai') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-heart w-4 text-gray-500"></i> Disukai
</a>

{{-- Kosan Saya (AKTIF) --}}
<a href="{{ route('user.kosan.saya') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
<i class="fa-solid fa-house w-4 text-blue-600"></i> Kosan Saya
</a>

{{-- ✅ FIX: Ulasan sudah ada route --}}
<a href="{{ route('user.ulasan') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-star w-4 text-gray-500"></i> Ulasan
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-comment-dots w-4 text-gray-500"></i> Pesan
</a>

</div>
</div>

<div>
<p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">
Akun
</p>

<div class="space-y-1">

<a href="{{ route('user.profile') }}"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-user w-4 text-gray-500"></i> Akun
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-bell w-4 text-gray-500"></i> Notifikasi
</a>

<a href="#"
class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
<i class="fa-solid fa-wallet w-4 text-gray-500"></i> Pembayaran
</a>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit"
class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition rounded-xl">
<i class="fa-solid fa-right-from-bracket w-4 text-red-400"></i> Keluar
</button>
</form>

</div>
</div>

</nav>

</div>

{{-- ================= MAIN CONTENT ================= --}}
<div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10">

<h2 class="text-2xl font-black text-gray-800 mb-8">
Kosan Saya
</h2>

@if($penyewas->count() > 0)

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($penyewas as $sewa)

<div class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">

<img src="{{ asset('images/kost/'.$sewa->kost->images->first()->image) }}"
class="h-40 w-full object-cover">

<div class="p-4">

<h3 class="font-bold text-gray-800 text-lg mb-1">
{{ $sewa->kost->nama}}
</h3>

<p class="text-xs text-gray-500 mb-2">
Kamar : {{ $sewa->no_kamar ?? 'belum ditentukan' }}
</p>

<p class="text-xs text-gray-500 mb-3">
Mulai Sewa : {{ \Carbon\Carbon::parse($sewa->tgl_masuk)->format('d M Y') }}
</p>

{{-- STATUS --}}
<div class="mb-4">

@if($sewa->status == 'menunggu')
<span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-xs font-semibold">Menunggu Persetujuan</span>
@elseif($sewa->status == 'disetujui')
<span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-semibold">Disetujui</span>
@elseif($sewa->status == 'ditolak')
<span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-xs font-semibold">Ditolak</span>
@endif

</div>

<a href="{{ route('user.pengajuan.status',$sewa->id) }}"
class="block text-center bg-[#0047FF] text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
Lihat Detail
</a>

</div>

</div>

@endforeach

</div>

@else

<div class="flex flex-col items-center justify-center py-20 text-center">

<h3 class="font-bold text-lg text-gray-700 mb-2">
Belum Ada Kosan
</h3>

<p class="text-sm text-gray-400 mb-4">
Kamu belum menyewa kosan
</p>

<a href="{{ route('home') }}"
class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
Cari Kost
</a>

</div>

@endif

</div>

</div>

</div>

@endsection