@extends('admin.layouts.admin')

@section('content')

<div class="flex justify-between items-end mb-6">
    <div>
        <h1 class="text-2xl font-bold mb-2">Kelola Kost</h1>
        {{-- ✅ Info hasil search --}}
        @if(request('search'))
            <p class="text-sm text-gray-500">
                Hasil pencarian: <span class="font-semibold text-blue-600">"{{ request('search') }}"</span>
                — {{ $kosts->count() }} kost ditemukan
                <a href="{{ route('admin.kost.index') }}" class="ml-2 text-red-400 hover:text-red-600 text-xs">✕ Reset</a>
            </p>
        @endif
    </div>

    <a href="{{ route('admin.kost.create') }}"
       class="bg-[#0047FF] text-white px-6 py-2 rounded-lg font-bold text-sm shadow-md flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah Kost
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b bg-gray-50">
            <tr class="text-gray-500 text-sm font-semibold">
                <th class="px-6 py-4">Foto</th>
                <th class="px-6 py-4">Nama Kost</th>
                <th class="px-6 py-4 text-center">Jenis</th>
                <th class="px-6 py-4 text-center">Kamar Kosong</th>
                <th class="px-6 py-4 text-center">Kamar Terisi</th>
                <th class="px-6 py-4 text-center">Non-aktif</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($kosts as $kost)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    @if($kost->images->count() > 0)
                        <img src="{{ asset('images/kost/'.$kost->images->first()->image) }}"
                             class="w-32 h-20 object-cover rounded-xl">
                    @else
                        <div class="w-32 h-20 bg-gray-200 rounded-xl flex items-center justify-center text-xs text-gray-400">
                            No Image
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <h3 class="font-bold text-gray-800">{{ $kost->nama }}</h3>
                    <p class="text-[10px] text-gray-400 leading-tight max-w-xs">{{ $kost->alamat }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total: <span class="font-semibold">{{ $kost->jumlah_kamar }}</span> kamar</p>
                </td>
                <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $kost->jenis }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-blue-100 text-blue-700 font-bold text-sm px-3 py-1 rounded-full">
                        {{ $kost->kamars->where('status', 'Kosong')->count() }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-green-100 text-green-700 font-bold text-sm px-3 py-1 rounded-full">
                        {{ $kost->kamars->where('status', 'Terisi')->count() }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-red-100 text-red-600 font-bold text-sm px-3 py-1 rounded-full">
                        {{ $kost->kamars->where('status', 'Non-aktif')->count() }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.kost.edit', $kost->id) }}"
                           class="bg-[#0047FF] text-white px-4 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST"
                              onsubmit="return confirm('Yakin mau hapus kost ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold inline-flex items-center gap-1">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-10 text-gray-400">
                    @if(request('search'))
                        Kost "{{ request('search') }}" tidak ditemukan
                    @else
                        Belum ada data kost
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection