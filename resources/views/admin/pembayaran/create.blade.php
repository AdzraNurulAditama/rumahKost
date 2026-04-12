@extends('admin.layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- TITLE --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Tambah Pembayaran</h1>
        <p class="text-gray-500 text-sm">Input data pembayaran penyewa</p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">

        <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- PENYEWA --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Penyewa</label>
            <select name="penyewa_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                <option disabled selected>-- Pilih Penyewa --</option>
                @foreach($penyewas as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- KAMAR --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Kamar</label>
            <select name="kamar_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                <option disabled selected>-- Pilih Kamar --</option>
                @foreach($kamars as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- JUMLAH --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Jumlah Pembayaran</label>
            <input type="number" name="jumlah"
                   placeholder="Masukkan jumlah (contoh: 500000)"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Tanggal Pembayaran</label>
            <input type="date" name="tanggal"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- UPLOAD BUKTI --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Upload Bukti Transfer</label>

            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-400 transition">
                <input type="file" name="bukti" class="mx-auto">
                <p class="text-xs text-gray-400 mt-2">PNG, JPG maksimal 2MB</p>
            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">

            <a href="{{ route('admin.pembayaran.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50">
                Batal
            </a>

            <button class="bg-[#0047FF] text-white px-6 py-2 rounded-lg hover:opacity-90">
                Simpan
            </button>

        </div>

        </form>

    </div>

</div>

@endsection