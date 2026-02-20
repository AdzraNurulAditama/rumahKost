@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#E9F0FF]">
    <aside class="w-64 bg-white min-h-screen p-6 flex flex-col shadow-sm fixed overflow-y-auto">
        <div class="text-2xl font-bold text-blue-600 mb-10">Rumah<span class="text-orange-500">Kost</span></div>
        
        <nav class="flex-1 space-y-2">
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-blue-50 text-blue-600 font-semibold">
                <i class="fa fa-th-large w-5"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                <i class="fa fa-users w-5"></i> Kelola Penyewa
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                <i class="fa fa-calendar-check w-5"></i> Kelola Pemesanan
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                <i class="fa fa-wallet w-5"></i> Data Keuangan
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                <i class="fa fa-door-open w-5"></i> Kamar
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-500 hover:bg-gray-50 transition">
                <i class="fa fa-database w-5"></i> Data Kost
            </a>
        </nav>

        <div class="mt-auto pt-10">
            <a href="#" class="flex items-center gap-3 p-3 text-red-500 font-medium hover:bg-red-50 rounded-xl transition">
                <i class="fa fa-sign-out-alt"></i> Log out
            </a>
        </div>
    </aside>

    <main class="flex-1 ml-64 p-8">
        <header class="flex items-center justify-between mb-8">
            <div class="relative w-96">
                <input type="text" placeholder="Cari kost atau kamar" class="w-full pl-12 pr-4 py-2 rounded-full border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <i class="fa fa-search absolute left-4 top-3 text-blue-600"></i>
            </div>
            <div class="flex items-center gap-3 bg-white border px-4 py-2 rounded-xl shadow-sm">
                <i class="fa fa-user-circle text-2xl"></i>
                <span class="font-bold text-gray-800">Kim seonho</span>
            </div>
        </header>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Hi, Admin!</h1>
            <p class="text-gray-500">Selamat datang di panel admin RumahKost</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
                <div class="p-3 bg-gray-50 rounded-lg text-xl"><i class="fa fa-home"></i></div>
                <div>
                    <div class="text-2xl font-bold">5</div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Total Kost</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
                <div class="p-3 bg-gray-50 rounded-lg text-xl"><i class="fa fa-door-closed"></i></div>
                <div>
                    <div class="text-2xl font-bold">12</div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Kamar Kosong</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4">
                <div class="p-3 bg-gray-50 rounded-lg text-xl"><i class="fa fa-users"></i></div>
                <div>
                    <div class="text-2xl font-bold">23</div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Penyewa Aktif</div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[20px] shadow-sm flex items-center gap-4 border-l-4 border-blue-500">
                <div class="p-3 bg-gray-50 rounded-lg text-xl"><i class="fa fa-wallet text-blue-600"></i></div>
                <div>
                    <div class="text-2xl font-bold">Rp23.000.000</div>
                    <div class="text-sm text-gray-400 uppercase tracking-wider">Pendapatan</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-[25px] p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Booking Terbaru</h2>
                    <button class="bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-blue-600 transition">Lihat Semua</button>
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
                            @foreach(range(1, 7) as $i)
                            <tr>
                                <td class="px-4 py-4 text-gray-600">Go yanjung</td>
                                <td class="px-4 py-4 text-gray-600">Kost Mama {{ $i == 1 ? 'Ata' : 'Ryu' }}</td>
                                <td class="px-4 py-4 text-gray-600">Kamar 0{{ $i }}</td>
                                <td class="px-4 py-4 text-gray-400">08 Mei 2024</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-4 py-1 rounded-lg text-xs font-bold {{ $i == 1 ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-500' }}">
                                        {{ $i == 1 ? 'Aktif' : 'Menunggu' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

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
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection