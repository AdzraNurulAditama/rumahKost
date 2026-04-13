@extends('admin.layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Hi, Admin!</h1>
    <p class="text-gray-500">Selamat datang di panel admin RumahKost</p>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-blue-50 rounded-lg text-xl">
            <i class="fa fa-home text-blue-500"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $totalKost }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Total Kost</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-green-50 rounded-lg text-xl">
            <i class="fa fa-door-open text-green-500"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $kamarKosong }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Kamar Kosong</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-purple-50 rounded-lg text-xl">
            <i class="fa fa-users text-purple-500"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $penyewaAktif }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Penyewa Aktif</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4 border-l-4 border-blue-500">
        <div class="p-3 bg-blue-50 rounded-lg text-xl">
            <i class="fa fa-wallet text-blue-600"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ number_format($pendapatan, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Pendapatan</div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Booking Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-[25px] p-6 shadow-sm">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Booking Terbaru</h2>
            <a href="{{ route('admin.penyewa.index') }}"
               class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-blue-600 transition">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-400 text-xs uppercase font-medium">
                    <tr>
                        <th class="px-4 py-3">Penyewa</th>
                        <th class="px-4 py-3">Kost</th>
                        <th class="px-4 py-3">Kamar</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($bookings as $b)
                    <tr>
                        <td class="px-4 py-4 text-gray-700 font-medium">
                            {{ $b->user->username ?? $b->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-gray-600">
                            {{ $b->kost->nama ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-gray-600">
                            {{ $b->kamar->nomor_kamar ?? 'Belum ditentukan' }}
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            {{ \Carbon\Carbon::parse($b->tgl_masuk)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($b->status == 'lunas')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-600">Lunas</span>
                            @elseif($b->status == 'disetujui')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-600">Disetujui</span>
                            @elseif($b->status == 'menunggu')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-500">Menunggu</span>
                            @elseif($b->status == 'ditolak')
                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-500">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400">Belum ada booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart Pendapatan Bulanan --}}
    <div class="bg-white rounded-[25px] p-6 shadow-sm">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Pendapatan Bulanan</h2>
            <span class="bg-gray-50 text-xs font-bold rounded-lg px-3 py-1 text-gray-500">{{ $tahun }}</span>
        </div>

        <canvas id="chartPendapatan" height="220"></canvas>

        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">Total {{ $tahun }}</p>
            <p class="text-lg font-bold text-blue-600">Rp {{ number_format(array_sum($chartData), 0, ',', '.') }}</p>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPendapatan').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Pendapatan',
            data: @json(array_values($chartData)),
            backgroundColor: function(context) {
                const value = context.raw;
                return value > 0 ? 'rgba(59, 130, 246, 0.8)' : 'rgba(219, 234, 254, 0.5)';
            },
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.04)' },
                ticks: {
                    callback: function(value) {
                        if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(0) + 'jt';
                        if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                        return value;
                    },
                    font: { size: 10 }
                }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});
</script>

</div>

@endsection