@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-end mb-6">
    <div>
        <h1 class="text-2xl font-bold mb-4">Kelola Kost</h1>
        <select class="bg-white border rounded-lg px-4 py-2 text-sm outline-none">
            <option>Semua kost</option>
        </select>
    </div>
    <a href="{{ route('admin.kost.create') }}" class="bg-[#0047FF] text-white px-6 py-2 rounded-lg font-bold text-sm shadow-md flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah Kost
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b bg-gray-50">
            <tr class="text-gray-500 text-sm font-semibold">
                <th class="px-6 py-4">Foto</th>
                <th class="px-6 py-4">Nama Kost</th>
                <th class="px-6 py-4 text-center">Jenis</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($kosts as $kost)
            <tr>
                <td class="px-6 py-4">
                    <img src="{{ asset('storage/'.$kost->gambar) }}" class="w-32 h-20 object-cover rounded-xl">
                </td>
                <td class="px-6 py-4">
                    <h3 class="font-bold text-gray-800">{{ $kost->nama }}</h3>
                    <p class="text-[10px] text-gray-400 leading-tight max-w-xs">{{ $kost->alamat }}</p>
                </td>
                <td class="px-6 py-4 text-center text-sm text-gray-600">
                    {{ $kost->jenis ?? 'Putra' }}
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-[#27AE60] text-white px-4 py-1 rounded-full text-xs font-bold">
                        Aktif
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="#" class="bg-[#0047FF] text-white px-6 py-1.5 rounded-lg text-xs font-bold flex items-center justify-center gap-2 inline-flex">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex justify-center gap-2 mt-8">
    <button class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center"><i class="fa fa-chevron-left text-xs"></i></button>
    <button class="w-8 h-8 bg-orange-400 text-white rounded font-bold">1</button>
    <button class="w-8 h-8 bg-gray-300 text-white rounded font-bold">2</button>
    <button class="w-8 h-8 bg-gray-300 text-white rounded font-bold">3</button>
    <button class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center"><i class="fa fa-chevron-right text-xs"></i></button>
</div>
@endsection