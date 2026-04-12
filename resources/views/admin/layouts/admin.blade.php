<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RumahKost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#F8FAFF]">

@php
function activeMenu($route)
{
    return request()->routeIs($route)
        ? 'bg-blue-50 text-[#0047FF] border-r-4 border-[#0047FF]'
        : 'text-gray-400 hover:text-blue-600';
}
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed h-full shadow-sm">
        <div class="p-8">
            <a href="/" class="text-2xl font-bold text-[#0047FF]">
                Rumah<span class="text-[#FFB800]">Kost</span>
            </a>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.dashboard') }}">
                <i class="fa-solid fa-house-chimney w-5"></i>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>
            <a href="{{ route('admin.penyewa.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.penyewa.*') }}">
                <i class="fa-solid fa-users w-5"></i>
                <span class="font-semibold text-sm">Kelola Penyewa</span>
            </a>
            <a href="{{ route('admin.kost.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.kost.*') }}">
                <i class="fa-solid fa-file-invoice w-5"></i>
                <span class="font-semibold text-sm">Data Kost</span>
            </a>
            <a href="{{ route('admin.kamar.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.kamar.*') }}">
                <i class="fa-solid fa-bed w-5"></i>
                <span class="font-semibold text-sm">Data Kamar</span>
            </a>
            <a href="{{ route('admin.chat.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.chat.*') }}">
                <i class="fas fa-comment-dots w-5"></i>
                <span class="font-semibold text-sm">Pesan</span>
            </a>
            <a href="{{ route('admin.pembayaran.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.pembayaran.*') }}">
                <i class="fa-solid fa-money-bill-wave w-5"></i>
                <span class="font-semibold text-sm">Kelola Pembayaran</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-50">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-4 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition w-full text-left">
                    <i class="fa-solid fa-right-from-bracket rotate-180"></i>
                    <span class="font-bold text-sm">Log out</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- TOPBAR --}}
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-10">

            {{-- ✅ CONTEXT-AWARE SEARCH BAR --}}
            @php
                // Tentukan route tujuan search berdasarkan halaman aktif
                $searchRoute = request()->routeIs('admin.kamar.*')
                    ? route('admin.kamar.index')
                    : route('admin.kost.index');

                $searchPlaceholder = request()->routeIs('admin.kamar.*')
                    ? 'Cari kamar berdasarkan nama kost...'
                    : 'Cari kost...';
            @endphp

            <form action="{{ $searchRoute }}" method="GET" class="w-1/3">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="{{ $searchPlaceholder }}"
                           class="w-full pl-12 pr-4 py-2 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                           onkeydown="if(event.key==='Enter')this.form.submit()">
                    <button type="submit"
                            class="absolute left-1 top-1 bg-[#0047FF] w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fa fa-search text-white text-[10px]"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ $searchRoute }}"
                           class="absolute right-3 top-2 text-gray-400 hover:text-gray-600 text-sm">✕</a>
                    @endif
                </div>
            </form>

            {{-- USER PROFILE --}}
            <div class="flex items-center gap-3 border border-gray-200 px-4 py-1.5 rounded-full bg-white cursor-pointer hover:shadow-sm transition">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                </div>
                <span class="text-xs font-bold text-gray-700">
                    {{ auth('admin')->user()->username ?? 'Admin' }}
                </span>
            </div>

        </header>

        {{-- CONTENT --}}
        <div class="p-10">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>