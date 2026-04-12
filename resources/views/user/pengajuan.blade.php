@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="max-w-7xl mx-auto px-6 py-10">

{{-- STEP PROGRESS --}}
<div class="flex items-center justify-between mb-12">
    <div class="flex flex-col items-center text-blue-600">
        <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-sm mt-2 font-medium">Ajukan sewa</p>
    </div>
    <div class="flex-1 h-1 bg-gray-400"></div>
    <div class="flex flex-col items-center text-gray-400">
        <div class="w-8 h-8 rounded-full border-4 border-gray-400 bg-white flex items-center justify-center">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
            </svg>
        </div>
        <p class="text-sm mt-2">Menunggu persetujuan</p>
    </div>
    <div class="flex-1 h-1 bg-gray-300"></div>
    <div class="flex flex-col items-center text-gray-400">
        <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-white"></div>
        <p class="text-sm mt-2">Bayar sewa pertama</p>
    </div>
    <div class="flex-1 h-1 bg-gray-300"></div>
    <div class="flex flex-col items-center text-gray-400">
        <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-white"></div>
        <p class="text-sm mt-2">Check-in</p>
    </div>
</div>

@if(session('error'))
    <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

    {{-- KIRI --}}
    <div class="lg:col-span-2 space-y-8">

        <h1 class="text-3xl font-bold">Pengajuan Sewa</h1>

        {{-- INFORMASI PENYEWA --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-5">Informasi Penyewa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">
                <div>
                    <p class="text-gray-500">Nama Penyewa</p>
                    <p class="font-semibold">{{ Auth::user()->username ?? 'Nama tidak tersedia' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Nomor HP</p>
                    @if(Auth::user()->nomor_telepon ?? false)
                        <p class="font-semibold">{{ Auth::user()->nomor_telepon }}</p>
                    @else
                        <p class="text-red-500 italic">Nomor HP belum terisi</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold">{{ Auth::user()->jenis_kelamin ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    <p class="font-semibold">{{ Auth::user()->status ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- ✅ TAMBAH: PILIH TIPE KAMAR --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-5">Pilih Tipe Kamar</h2>

            @if($kamarsKosong->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <i class="fa-solid fa-door-closed text-4xl mb-3"></i>
                    <p>Tidak ada kamar tersedia saat ini</p>
                </div>
            @else
                <div class="space-y-3" id="tipe-kamar-list">
                    @foreach($kamarsKosong as $tipe => $kamars)
                    <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-blue-500 transition tipe-card"
                         onclick="pilihTipe(this, {{ $kamars->first()->id }}, {{ $kamars->first()->harga }})">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $tipe }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fa-solid fa-door-open text-blue-500 mr-1"></i>
                                    {{ $kamars->count() }} kamar tersedia
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-600">Rp {{ number_format($kamars->first()->harga, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">/bulan</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- FORM PENGAJUAN --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-5">Form Pengajuan</h2>

            <form action="{{ route('user.pengajuan.create', $kost->id) }}" method="POST">
                @csrf

                {{-- ✅ TAMBAH: hidden input kamar_id --}}
                <input type="hidden" name="kamar_id" id="kamar_id_input">

                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Jumlah Penghuni (max 2 orang)</label>
                        <input type="number" name="jumlah_orang" min="1" max="2" value="1"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                    </div>
                </div>

                {{-- ✅ TAMBAH: Info kamar yang dipilih --}}
                <div id="kamar-terpilih" class="hidden mt-4 bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 text-sm text-blue-700">
                    <i class="fa-solid fa-circle-check mr-1"></i>
                    Kamar terpilih: <span id="kamar-terpilih-label" class="font-semibold"></span>
                </div>

                <button type="submit" id="btn-ajukan"
                    class="w-full mt-6 bg-gray-400 text-white font-medium py-3 rounded-lg cursor-not-allowed transition"
                    disabled>
                    Pilih kamar dulu
                </button>

            </form>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 sticky top-6">
            <div class="border-b pb-4 mb-4">
                <h3 class="text-2xl font-bold" id="harga-display">
                    Rp {{ number_format($kost->harga, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-gray-400 mt-1">Harga akan menyesuaikan tipe kamar</p>
            </div>

            <div class="border border-gray-100 rounded-xl p-4 text-sm text-gray-600 bg-gray-50">
                <p class="mb-3 font-medium">Jika bayar pakai DP:</p>
                <div class="flex justify-between mb-2">
                    <span>Uang muka (DP)</span>
                    <span id="dp-display">Rp {{ number_format($kost->harga * 0.3, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span>Pelunasan</span>
                    <span id="pelunasan-display">Rp {{ number_format($kost->harga * 0.7, 0, ',', '.') }}</span>
                </div>
                <p class="mb-3 font-medium">Jika bayar penuh:</p>
                <div class="flex justify-between mb-4">
                    <span>Pembayaran Penuh</span>
                    <span id="penuh-display">Rp {{ number_format($kost->harga, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-dashed pt-3 flex justify-between font-semibold text-gray-800">
                    <span>Total Pembayaran Pertama</span>
                    <span id="total-display">Rp {{ number_format($kost->harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script>
function pilihTipe(el, kamarId, harga) {
    // Reset semua card
    document.querySelectorAll('.tipe-card').forEach(c => {
        c.classList.remove('border-blue-500', 'bg-blue-50');
        c.classList.add('border-gray-200');
    });

    // Aktifkan card yang dipilih
    el.classList.add('border-blue-500', 'bg-blue-50');
    el.classList.remove('border-gray-200');

    // Set kamar_id
    document.getElementById('kamar_id_input').value = kamarId;

    // Update label
    const tipeLabel = el.querySelector('p.font-semibold').textContent;
    document.getElementById('kamar-terpilih-label').textContent = tipeLabel;
    document.getElementById('kamar-terpilih').classList.remove('hidden');

    // Update harga
    const formatted = 'Rp ' + harga.toLocaleString('id-ID');
    document.getElementById('harga-display').textContent = formatted;
    document.getElementById('dp-display').textContent = 'Rp ' + Math.round(harga * 0.3).toLocaleString('id-ID');
    document.getElementById('pelunasan-display').textContent = 'Rp ' + Math.round(harga * 0.7).toLocaleString('id-ID');
    document.getElementById('penuh-display').textContent = formatted;
    document.getElementById('total-display').textContent = formatted;

    // Aktifkan tombol
    const btn = document.getElementById('btn-ajukan');
    btn.disabled = false;
    btn.textContent = 'Ajukan Sewa';
    btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
    btn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
}
</script>

@endsection