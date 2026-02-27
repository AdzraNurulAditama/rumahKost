@extends('admin.layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">
            Edit <span class="text-[#0047FF]">Kost</span>
        </h1>
        <a href="{{ route('admin.kost.index') }}" 
           class="text-sm text-gray-500 hover:text-blue-600">
           ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border p-10">

        <form action="{{ route('admin.kost.update', $kost->id) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block font-bold mb-2">Nama Kost</label>
                <input type="text" name="nama" 
                       value="{{ $kost->nama }}"
                       class="w-full px-5 py-3 rounded-2xl border">
            </div>

            {{-- Harga --}}
            <div>
                <label class="block font-bold mb-2">Harga</label>
                <input type="number" name="harga" 
                       value="{{ $kost->harga }}"
                       class="w-full px-5 py-3 rounded-2xl border">
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block font-bold mb-2">Lokasi</label>
                <input type="text" name="lokasi" 
                       value="{{ $kost->lokasi }}"
                       class="w-full px-5 py-3 rounded-2xl border">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block font-bold mb-2">Alamat</label>
                <textarea name="alamat"
                    class="w-full px-5 py-3 rounded-2xl border">{{ $kost->alamat }}</textarea>
            </div>

            {{-- Jenis --}}
            <div>
                <label class="block font-bold mb-2">Jenis</label>
                <select name="jenis" class="w-full px-5 py-3 rounded-2xl border">
                    <option value="Putri" {{ $kost->jenis == 'Putri' ? 'selected' : '' }}>Putri</option>
                </select>
            </div>

            {{-- FOTO LAMA --}}
            <div>
                <label class="block font-bold mb-4">Foto Saat Ini</label>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($kost->images as $img)
                        <div class="relative group">
                            <img src="{{ asset('images/kost/' . $img->image) }}"
                                 class="rounded-xl h-32 w-full object-cover">

                            <form action="{{ route('admin.kost.image.delete', $img->id) }}"
                                  method="POST"
                                  class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 text-xs rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tambah Foto Baru --}}
            <div>
                <label class="block font-bold mb-2">Tambah Foto Baru</label>
                <input type="file" name="gambar[]" multiple
                       class="w-full">
            </div>

            <div class="pt-6">
                <button type="submit"
                        class="w-full bg-[#0047FF] text-white py-4 rounded-3xl font-bold">
                    Update Kost
                </button>
            </div>

        </form>

    </div>
</div>
@endsection