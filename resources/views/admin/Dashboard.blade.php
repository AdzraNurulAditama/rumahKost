@extends('admin.layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Hi, Admin!</h1>
    <p class="text-gray-500">Selamat datang di panel admin RumahKost</p>
</div>

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-gray-50 rounded-lg text-xl">
            <i class="fa fa-home"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $totalKost }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Total Kost</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-gray-50 rounded-lg text-xl">
            <i class="fa fa-door-closed"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $kamarKosong }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Kamar Kosong</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
        <div class="p-3 bg-gray-50 rounded-lg text-xl">
            <i class="fa fa-users"></i>
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $penyewaAktif }}</div>
            <div class="text-sm text-gray-400 uppercase tracking-wider">Penyewa Aktif</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4 border-l-4 border-blue-500">
        <div class="p-3 bg-gray-50 rounded-lg text-xl">
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
            <button class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-blue-600 transition">
                Lihat Semua
            </button>
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

                    @foreach(range(1,7) as $i)
                    <tr>
                        <td class="px-4 py-4 text-gray-600">Go yanjung</td>
                        <td class="px-4 py-4 text-gray-600">
                            Kost Mama {{ $i == 1 ? 'Ata' : 'Ryu' }}
                        </td>
                        <td class="px-4 py-4 text-gray-600">
                            Kamar 0{{ $i }}
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            08 Mei 2024
                        </td>

                        <td class="px-4 py-4 text-center">
                            <span class="px-4 py-1 rounded-lg text-xs font-bold
                                {{ $i == 1 ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-500' }}">
                                {{ $i == 1 ? 'Aktif' : 'Menunggu' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>


    {{-- Chart --}}
    <div class="bg-white rounded-[25px] p-6 shadow-sm">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Pendapatan Bulanan</h2>

            <select class="border-none bg-gray-50 text-xs font-bold rounded-lg px-2 py-1">
                <option>2024</option>
            </select>
        </div>

        <div class="relative h-64 w-full">

            <div class="absolute inset-0 flex items-end justify-between px-2">

                <div class="w-2 bg-blue-100 h-1/4 rounded-t-full"></div>
                <div class="w-2 bg-blue-200 h-2/4 rounded-t-full"></div>
                <div class="w-2 bg-blue-300 h-3/4 rounded-t-full"></div>
                <div class="w-2 bg-blue-500 h-full rounded-t-full"></div>
                <div class="w-2 bg-blue-400 h-4/5 rounded-t-full"></div>

            </div>

        </div>

        <div class="mt-4 flex justify-between text-[10px] text-gray-400">
            <span>Jan</span>
            <span>Feb</span>
            <span>Mar</span>
            <span>Apr</span>
            <span>Mei</span>
            <span>Jun</span>
        </div>

    </div>

</div>

@endsection