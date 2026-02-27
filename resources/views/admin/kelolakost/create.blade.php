@extends('admin.layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold">
                Tambah <span class="text-[#0047FF]">Kost Baru</span>
            </h1>
            <p class="text-sm text-gray-500">
                Masukkan detail informasi kosan secara lengkap.
            </p>
        </div>
        <a href="{{ route('admin.kost.index') }}"
           class="text-sm text-gray-500 hover:text-blue-600 transition flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border p-10">
        <form action="{{ route('admin.kost.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">

            @csrf

            {{-- Nama & Harga --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold mb-3">Nama Kost</label>
                    <input type="text"
                           name="nama"
                           value="{{ old('nama') }}"
                           required
                           class="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="Contoh: Kost MAMA ATA">
                </div>

                <div>
                    <label class="block text-sm font-bold mb-3">Harga per Tahun (Rp)</label>
                    <input type="number"
                           name="harga"
                           value="{{ old('harga') }}"
                           required
                           class="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none"
                           placeholder="1500000">
                </div>
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="block text-sm font-bold mb-3">Lokasi</label>
                <input type="text"
                       name="lokasi"
                       value="{{ old('lokasi') }}"
                       required
                       class="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Contoh: Bandung, dekat Telkom University">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-bold mb-3">Alamat Lengkap</label>
                <textarea name="alamat"
                          rows="3"
                          required
                          class="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none"
                          placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
            </div>

            {{-- Jenis & Upload --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>
                    <label class="block text-sm font-bold mb-3">Jenis Kost</label>
                    <select name="jenis"
                            class="w-full px-5 py-3 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Putri" {{ old('jenis') == 'Putri' ? 'selected' : '' }}>Putri</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-3">Foto Kost</label>
                    <input type="file"
                           name="gambar[]"
                           id="gambar"
                           multiple
                           required
                           class="w-full px-3 py-2 text-sm text-gray-500 
                                  file:mr-4 file:py-2 file:px-4 
                                  file:rounded-full file:border-0 
                                  file:text-sm file:font-semibold 
                                  file:bg-blue-50 file:text-blue-700 
                                  hover:file:bg-blue-100 transition">

                    @error('gambar.*')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Preview Image --}}
            <div id="preview" class="grid grid-cols-3 gap-4"></div>

            {{-- Fasilitas --}}
            <div>
                <label class="block text-sm font-bold mb-4">Fasilitas Kamar</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $facilities = ['AC', 'WiFi', 'Lemari', 'CCTV', 'Dapur', 'Parkir', 'Kamar Mandi Dalam', 'Mesin Cuci'];
                    @endphp

                    @foreach($facilities as $f)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox"
                               name="fasilitas[]"
                               value="{{ $f }}"
                               {{ in_array($f, old('fasilitas', [])) ? 'checked' : '' }}
                               class="w-5 h-5 rounded-lg border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-600 group-hover:text-blue-600">
                            {{ $f }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-6">
                <button type="submit"
                        class="w-full bg-[#0047FF] text-white font-bold py-4 rounded-3xl shadow-lg hover:bg-blue-700 transition">
                    Simpan Data Kost
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Script Preview Multiple Image --}}
<script>
document.getElementById('gambar').addEventListener('change', function(event) {
    let preview = document.getElementById('preview');
    preview.innerHTML = '';

    Array.from(event.target.files).forEach(file => {
        let reader = new FileReader();
        reader.onload = function(e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-full','h-32','object-cover','rounded-xl','shadow');
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});
</script>

@endsection