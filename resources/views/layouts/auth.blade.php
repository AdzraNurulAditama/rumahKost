<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RumahKost') }}</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine JS (buat carousel) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100 text-gray-800">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="text-2xl font-bold">
                <span class="text-blue-600">Rumah</span>
                <span class="text-orange-400">Kost</span>
            </a>

            {{-- MENU --}}
            <div class="flex items-center gap-6">

                <a href="{{ route('home') }}" class="hover:text-blue-600">
                    Beranda
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-red-500 hover:underline">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-600">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Register
                    </a>
                @endauth

            </div>

        </div>
    </nav>

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

</body>
</html>
