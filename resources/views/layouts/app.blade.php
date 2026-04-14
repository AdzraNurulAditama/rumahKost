<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKost</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

{{-- ================= NAVBAR ================= --}}
<nav class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- LOGO --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold">
                    <span class="text-blue-600">Rumah</span><span class="text-yellow-500">Kost</span>
                </a>
            </div>

            {{-- SEARCH --}}
            <div class="flex-1 max-w-sm mx-auto hidden md:block px-4">
                <form action="{{ route('home') }}" method="GET">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <div class="bg-blue-600 w-6 h-6 flex items-center justify-center rounded-full text-white">
                                <i class="fas fa-search text-[10px]"></i>
                            </div>
                        </span>
                        <input type="text" name="search"
                            value="{{ request('search') }}"
                            class="w-full border border-blue-200 rounded-full py-2 pl-11 pr-4 text-sm"
                            placeholder="Cari kost...">
                    </div>
                </form>
            </div>

            {{-- MENU --}}
            <div class="flex items-center space-x-6">

                <a href="{{ route('home') }}" class="text-sm font-semibold hover:text-blue-600">Beranda</a>

                @auth

                    <a href="{{ route('user.disukai') }}" class="text-sm font-semibold hover:text-blue-600">Favorit</a>

                    {{-- CHAT --}}
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.chat.index') }}" class="text-sm font-semibold hover:text-blue-600">
                            Chat
                        </a>
                    @else
                        <a href="{{ route('user.chat.room', 1) }}" class="text-sm font-semibold hover:text-blue-600">
                            Chat
                        </a>
                    @endif

                    <a href="{{ route('user.sewa') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        Sewa
                    </a>

                    {{-- PROFILE (FIX TOTAL) --}}
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.profile') }}"
                           class="flex items-center gap-2 border px-3 py-1 rounded-xl relative z-50 cursor-pointer"
                           style="pointer-events: auto;">
                    @else
                        <a href="{{ route('user.profile') }}"
                           class="flex items-center gap-2 border px-3 py-1 rounded-xl relative z-50 cursor-pointer"
                           style="pointer-events: auto;">
                    @endif

                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                 class="w-6 h-6 rounded-full object-cover">
                        @else
                            <i class="fas fa-user-circle text-lg"></i>
                        @endif

                        <span class="text-sm font-semibold">
                            {{ Auth::user()->username ?? Auth::user()->name }}
                        </span>

                    </a>

                @else

                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Daftar
                    </a>

                @endauth

            </div>

        </div>
    </div>
</nav>

{{-- ================= CONTENT ================= --}}
<main class="min-h-screen pb-10 relative z-0">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white border-t mt-10 py-6 text-center text-sm text-gray-500">
    © 2024 RumahKost
</footer>

@stack('scripts')

</body>
</html>