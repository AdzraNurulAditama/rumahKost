@extends('admin.layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- TITLE --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold">Edit Pembayaran</h1>
        <p class="text-gray-500 text-sm">Perbarui data pembayaran penyewa</p>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm p-8">

        <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- PENYEWA --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Penyewa</label>
            <select name="penyewa_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                @foreach($penyewas as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $pembayaran->penyewa_id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KAMAR --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Kamar</label>
            <select name="kamar_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                @foreach($kamars as $k)
                    <option value="{{ $k->id }}" {{ $k->id == $pembayaran->kamar_id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- JUMLAH --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Jumlah Pembayaran</label>
            <input type="number" name="jumlah"
                   value="{{ $pembayaran->jumlah }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Tanggal Pembayaran</label>
            <input type="date" name="tanggal"
                   value="{{ $pembayaran->tanggal }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- BUKTI --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Bukti Transfer</label>

            {{-- PREVIEW --}}
            @if($pembayaran->bukti)
                <div class="mb-3">
                    <p class="text-xs text-gray-400 mb-1">Bukti saat ini:</p>
                    <img src="{{ asset('storage/'.$pembayaran->bukti) }}" class="w-32 rounded-lg border">
                </div>
            @endif

            {{-- UPLOAD --}}
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-400 transition">
                <input type="file" name="bukti" class="mx-auto">
                <p class="text-xs text-gray-400 mt-2">Upload ulang jika ingin mengganti</p>
            </div>
        </div>

        {{-- STATUS (READ ONLY INFO) --}}
        <div>
            <label class="text-sm font-semibold mb-2 block">Status</label>
            <span class="px-3 py-1 rounded-full text-xs
                {{ $pembayaran->status == 'lunas' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                {{ ucfirst($pembayaran->status) }}
            </span>
            <p class="text-xs text-gray-400 mt-1">
                Status akan otomatis menjadi <b>Lunas</b> jika upload bukti
            </p>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">

            <a href="{{ route('admin.pembayaran.index') }}"
               class="px-5 py-2 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50">
                Batal
            </a>

            <button class="bg-[#0047FF] text-white px-6 py-2 rounded-lg hover:opacity-90">
                Update
            </button>

        </div>

        </form>

    </div>

</div>

@endsection