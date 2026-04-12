@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-10">

<h1 class="text-2xl font-bold mb-8 text-gray-800">
Riwayat Pengajuan Sewa
</h1>

<div class="grid md:grid-cols-3 gap-6">

@forelse($penyewas as $sewa)

<div class="bg-white rounded-2xl shadow-md overflow-hidden border hover:shadow-lg transition">

{{-- FOTO KOST --}}
<img src="{{ asset('images/kost/'.$sewa->kost->images->first()->image) }}"
class="h-40 w-full object-cover">

<div class="p-5">

<h2 class="font-bold text-lg text-gray-800 mb-2">
{{ $sewa->kost->nama }}
</h2>

<p class="text-sm text-gray-500 mb-3">
Tanggal Masuk :
{{ \Carbon\Carbon::parse($sewa->tgl_masuk)->format('d M Y') }}
</p>

{{-- STATUS --}}
<div class="mb-4">

@if($sewa->status == 'menunggu')

<span class="bg-yellow-100 text-yellow-700 px-4 py-1 rounded-full text-xs font-semibold"> Menunggu Persetujuan
</span>

@elseif($sewa->status == 'disetujui')

<span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-xs font-semibold">
Disetujui
</span>

@elseif($sewa->status == 'ditolak')

<span class="bg-red-100 text-red-700 px-4 py-1 rounded-full text-xs font-semibold">
Ditolak
</span>

@endif

</div>

{{-- BUTTON --}}


<a href="{{ route('user.pengajuan.status',$sewa->id) }}"
class="block text-center bg-[#0047FF] text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
Lihat Detail
</a>

</div>
</div>

@empty

<p class="text-gray-400">
Belum ada pengajuan sewa
</p>

@endforelse

</div>

</div>

@endsection