@extends('admin.layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-10 rounded-3xl shadow-md">

    <h1 class="text-2xl font-bold mb-6 text-center">Tambah Kamar</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 mb-6 rounded">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
  
    <form action="{{ route('admin.kamar.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- PILIH KOST -->
        <select name="kost_id"
                class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                required>
            <option value="" disabled selected>-- Pilih Kost --</option>
            @foreach($kosts as $kost)
                <option value="{{ $kost->id }}" {{ old('kost_id') == $kost->id ? 'selected' : '' }}>
                    {{ $kost->nama }}
                </option>
            @endforeach
        </select>

        <!-- NOMOR KAMAR -->
        <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar') }}"
               placeholder="Nomor Kamar (Contoh: A-01 / 101)"
               class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
               required>

        <!-- TIPE -->
        <select name="tipe_kamar"
                class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                required>
            <option value="" disabled selected>-- Pilih Tipe Kamar --</option>
            <option value="Deluxe" {{ old('tipe_kamar') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
            <option value="Superior" {{ old('tipe_kamar') == 'Superior' ? 'selected' : '' }}>Superior</option>
            <option value="Premium" {{ old('tipe_kamar') == 'Premium' ? 'selected' : '' }}>Premium</option>
        </select>

        <!-- HARGA -->
        <input type="number" name="harga" value="{{ old('harga') }}"
               placeholder="Harga per Bulan (contoh: 1500000)"
               class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
               required>

        <!-- BUTTON -->
        <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            Simpan Kamar
        </button>

    </form>
</div>
@endsection