<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RumahKostPutri</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8FAFF]">

@php
function activeMenu($route)
{
    return request()->routeIs($route)
        ? 'bg-pink-50 text-pink-500 border-r-4 border-pink-400'
        : 'text-gray-400 hover:text-pink-500';
}
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed h-full shadow-sm">

        {{-- LOGO --}}
        <div class="p-8">

            <a href="/" class="text-3xl font-extrabold tracking-tight">

                <span class="text-blue-700">Rumah</span>
                <span class="text-orange-400">Kost</span>
                <span class="text-pink-400">Putri</span>

            </a>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.dashboard') }}">

                <i class="fa-solid fa-house-chimney w-5"></i>

                <span class="font-semibold text-sm">
                    Dashboard
                </span>

            </a>

            <a href="{{ route('admin.penyewa.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.penyewa.*') }}">

                <i class="fa-solid fa-users w-5"></i>

                <span class="font-semibold text-sm">
                    Kelola Penyewa
                </span>

            </a>

            <a href="{{ route('admin.kost.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.kost.*') }}">

                <i class="fa-solid fa-file-invoice w-5"></i>

                <span class="font-semibold text-sm">
                    Data Kost
                </span>

            </a>

            <a href="{{ route('admin.kamar.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.kamar.*') }}">

                <i class="fa-solid fa-bed w-5"></i>

                <span class="font-semibold text-sm">
                    Data Kamar
                </span>

            </a>

            <a href="{{ route('admin.chat.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition {{ activeMenu('admin.chat.*') }}">

                <i class="fas fa-comment-dots w-5"></i>

                <span class="font-semibold text-sm">
                    Pesan
                </span>

            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-6 border-t border-gray-50">

            <form action="{{ route('admin.logout') }}" method="POST">

                @csrf

                <button type="submit"
                    class="flex items-center gap-4 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl w-full text-left transition">

                    <i class="fa-solid fa-right-from-bracket rotate-180"></i>

                    <span class="font-bold text-sm">
                        Log out
                    </span>

                </button>

            </form>

        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- TOPBAR --}}
        <header class="h-20 bg-white border-b flex items-center justify-between px-10">

            {{-- SEARCH --}}
            @php
                $searchRoute = request()->routeIs('admin.kamar.*')
                    ? route('admin.kamar.index')
                    : route('admin.kost.index');

                $searchPlaceholder = request()->routeIs('admin.kamar.*')
                    ? 'Cari kamar berdasarkan nama kost...'
                    : 'Cari kost...';
            @endphp

            <form action="{{ $searchRoute }}" method="GET" class="w-1/3">

                <div class="relative">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ $searchPlaceholder }}"
                        class="w-full pl-12 pr-4 py-2 border rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-200"
                    >

                    <button type="submit"
                        class="absolute left-1 top-1 bg-pink-400 w-8 h-8 rounded-full flex items-center justify-center">

                        <i class="fa fa-search text-white text-[10px]"></i>

                    </button>

                </div>

            </form>

            {{-- PROFILE --}}
            <a href="{{ route('admin.profile') }}"
               class="flex items-center gap-3 border px-4 py-1.5 rounded-full bg-white hover:shadow-sm transition">

                <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center">

                    <i class="fa-solid fa-user text-pink-400 text-xs"></i>

                </div>

                <span class="text-xs font-bold text-gray-700">
                    {{ Auth::user()->username ?? Auth::user()->name ?? 'Admin' }}
                </span>

            </a>

        </header>

        {{-- CONTENT --}}
        <div class="p-10">

            @yield('content')

        </div>

    </div>

</div>

</body>
</html>