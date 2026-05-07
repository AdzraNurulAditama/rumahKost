<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKostPutri</title>

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
                
                <a href="{{ route('home') }}" class="text-3xl font-extrabold tracking-tight">

                    <span class="text-blue-700">
                        Rumah<span class="text-orange-400">Kost</span><span class="text-pink-400">Putri</span>
                    </span>

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

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="w-full border border-blue-200 rounded-full py-2 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                            placeholder="Cari kost..."
                        >

                    </div>

                </form>

            </div>

            {{-- MENU --}}
            <div class="flex items-center space-x-6">

                <a href="{{ route('home') }}"
                   class="text-sm font-semibold hover:text-blue-600 transition">
                    Beranda
                </a>

                @auth

                    <a href="{{ route('user.disukai') }}"
                       class="text-sm font-semibold hover:text-blue-600 transition">
                        Favorit
                    </a>

                    {{-- CHAT --}}
                    @if(Auth::user()->role == 'admin')

                        <a href="{{ route('admin.chat.index') }}"
                           class="text-sm font-semibold hover:text-blue-600 transition">
                            Chat
                        </a>

                    @else

                        <a href="{{ route('user.chat.room', 1) }}"
                           class="text-sm font-semibold hover:text-blue-600 transition">
                            Chat
                        </a>

                    @endif

                    {{-- SEWA --}}
                    <a href="{{ route('user.sewa') }}"
                       class="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-2 rounded-xl text-sm font-semibold shadow">
                        Sewa
                    </a>

                    {{-- PROFILE --}}
                    @if(Auth::user()->role == 'admin')

                        <a href="{{ route('admin.profile') }}"
                           class="flex items-center gap-2 border px-3 py-1 rounded-xl relative z-50 cursor-pointer hover:shadow transition">

                    @else

                        <a href="{{ route('user.profile') }}"
                           class="flex items-center gap-2 border px-3 py-1 rounded-xl relative z-50 cursor-pointer hover:shadow transition">

                    @endif

                        @if(Auth::user()->photo)

                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                 class="w-7 h-7 rounded-full object-cover">

                        @else

                            <i class="fas fa-user-circle text-xl text-gray-600"></i>

                        @endif

                        <span class="text-sm font-semibold">
                            {{ Auth::user()->username ?? Auth::user()->name }}
                        </span>

                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold hover:text-blue-600">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded-xl text-sm font-semibold shadow">
                        Daftar
                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>

{{-- ================= CONTENT ================= --}}
<<<<<<< HEAD
<main class="min-h-screen pb-10">
=======
<main class="min-h-screen pb-10 relative z-0">

>>>>>>> a83547f3d4e94dc5f75ccd4b6d2ebccbc4708697
    @yield('content')

</main>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white border-t mt-10 py-6 text-center text-sm text-gray-500">

    © 2024 RumahKostPutri

</footer>

@stack('scripts')

</body>
</html>