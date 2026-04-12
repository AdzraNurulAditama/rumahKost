@extends('admin.layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Kelola Pembayaran</h1>

<a href="{{ route('admin.pembayaran.create') }}"
class="bg-[#0047FF] text-white px-4 py-2 rounded mb-4 inline-block">
+ Tambah Pembayaran
</a>

<div class="bg-white rounded-xl overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-4 text-left">Penyewa</th>
<th>Kamar</th>
<th>Jumlah</th>
<th>Tanggal</th>
<th>Status</th>
<th>Bukti</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach($pembayarans as $item)
<tr class="border-t">

<td class="p-4">{{ $item->penyewa->nama }}</td>
<td>{{ $item->kamar->nama }}</td>
<td>Rp {{ number_format($item->jumlah) }}</td>
<td>{{ $item->tanggal }}</td>

<td>
<span class="px-3 py-1 rounded-full text-xs
{{ $item->status == 'lunas' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
{{ $item->status }}
</span>
</td>

<td>
@if($item->bukti)
<a href="{{ asset('storage/'.$item->bukti) }}" target="_blank" class="text-blue-500">Lihat</a>
@else
-
@endif
</td>

<td class="flex gap-2">
<a href="{{ route('admin.pembayaran.edit', $item->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>

<form action="{{ route('admin.pembayaran.destroy', $item->id) }}" method="POST">
@csrf
@method('DELETE')
<button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
</form>
</td>

</tr>
@endforeach
</tbody>

</table>

</div>

@endsection