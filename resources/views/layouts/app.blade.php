<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- ✅ dipindah ke dalam head --}}
    <title>RumahKost</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
   {{-- Pusher --}}
   <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    
    {{-- FontAwesome untuk Icon (Penting untuk icon di Navbar & Footer) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-white text-gray-800 font-sans antialiased">

    {{-- ================= NAVBAR ================= --}}
    <nav class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                {{-- Kiri: Logo --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                        <span class="text-blue-600">Rumah</span><span class="text-yellow-500">Kost</span>
                    </a>
                </div>
    
              {{-- Search bar --}}
<div class="flex-1 max-w-sm mx-auto hidden md:block px-4">
    <form action="{{ route('home') }}" method="GET">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <div class="bg-blue-600 w-6 h-6 flex items-center justify-center rounded-full text-white shrink-0">
                    <i class="fas fa-search text-[10px]"></i>
                </div>
            </span>
            <button type="submit" class="hidden"></button>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="w-full border border-blue-200 rounded-full py-2 pl-11 pr-4 focus:outline-none focus:border-blue-500 text-sm text-gray-600 shadow-sm"
                placeholder="Cari kost atau kamar"
                onkeydown="if(event.key==='Enter')this.form.submit()">
        </div>
    </form>
</div>
                {{-- Kanan --}}
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-800 font-semibold text-sm hover:text-blue-600 transition">Beranda</a>
                    
                    @auth
                        <a href="{{ route('user.disukai') }}" class="text-gray-800 font-semibold text-sm hover:text-blue-600 transition">Favorit</a>
                        
                        <a href="{{ route('user.sewa') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                            Sewa
                        </a>
    
                        {{-- PROFILE --}}
                        <div class="flex items-center gap-3 ml-2">
                            <a href="{{ route('user.profile') }}"
                               class="flex items-center space-x-2 border border-gray-300 px-3 py-1.5 rounded-xl hover:bg-gray-50 transition">
    
                                @if(Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                         class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <i class="fas fa-user-circle text-gray-600 text-lg"></i>
                                @endif
    
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ Auth::user()->username ?? 'User' }}
                                </span>
                            </a>
                        </div>
    
                    @else
                        <a href="{{ route('login') }}" class="text-gray-800 font-semibold text-sm hover:text-blue-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Daftar</a>
                    @endauth
                </div>
    
            </div>
        </div>
    </nav>


    {{-- ================= KONTEN UTAMA ================= --}}
    <main class="min-h-screen pb-10">
        @yield('content')
    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="bg-white pt-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between gap-10">
                
                {{-- Kolom 1: Logo, Social, App Store --}}
                <div class="md:w-1/3">
                    <div class="text-3xl font-bold mb-4">
                        <span class="text-blue-600">Rumah</span><span class="text-yellow-500">Kost</span>
                    </div>
                    <p class="text-gray-500 text-[11px] mb-6 leading-relaxed max-w-xs">
                        Temukan "info kost murah" dan hunian nyaman hanya di RumahKost. Mau cari kost idaman?
                    </p>

                    <p class="font-bold text-xs mb-3 text-gray-800">Dapatkan update seputar RumahKost</p>
                    <div class="flex space-x-2 mb-8">
                        <a href="#" class="w-7 h-7 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs hover:opacity-80"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs hover:opacity-80"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center text-xs hover:opacity-80"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-blue-400 text-white flex items-center justify-center text-xs hover:opacity-80"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-black text-white flex items-center justify-center text-xs hover:opacity-80"><i class="fab fa-tiktok"></i></a>
                    </div>

                    <p class="font-bold text-xs mb-3 text-gray-800">Sewa Kosan makin mudah menggunakan aplikasi</p>
                    <div class="flex space-x-2">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-8 cursor-pointer">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" class="h-8 cursor-pointer">
                    </div>
                </div>

                {{-- Kolom Kanan: Links (Grid) --}}
                <div class="md:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-6 pt-2">
                    
                    {{-- RumahKost --}}
                    <div>
                        <h3 class="font-bold text-xs text-gray-800 mb-4">RumahKost</h3>
                        <ul class="space-y-3 text-[11px] text-gray-500">
                            <li><a href="#" class="hover:text-blue-600">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-blue-600">Pusat Bantuan</a></li>
                        </ul>
                    </div>

                    {{-- Kebijakan --}}
                    <div>
                        <h3 class="font-bold text-xs text-gray-800 mb-4">Kebijakan</h3>
                        <ul class="space-y-3 text-[11px] text-gray-500">
                            <li><a href="#" class="hover:text-blue-600">Syarat dan Ketentuan</a></li>
                            <li><a href="#" class="hover:text-blue-600">Kebijakan Privasi</a></li>
                        </ul>
                    </div>

                    {{-- Customer Care --}}
                    <div>
                        <h3 class="font-bold text-xs text-gray-800 mb-4">Customer Care</h3>
                        <ul class="space-y-3 text-[11px] text-gray-500">
                            <li><a href="#" class="hover:text-blue-600">Hubungi Kami</a></li>
                            <li><a href="#" class="hover:text-blue-600">Konfirmasi Pembayaran</a></li>
                            <li><a href="#" class="hover:text-blue-600">FAQ / Bantuan</a></li>
                        </ul>
                    </div>

                    {{-- Kontak Kami --}}
                    <div>
                        <h3 class="font-bold text-xs text-gray-800 mb-4">Kontak Kami</h3>
                        <ul class="space-y-3 text-[11px] text-gray-500">
                            <li class="flex items-center space-x-2">
                                <i class="far fa-envelope text-blue-600 text-sm w-4"></i>
                                <span>customercare@RumahKost.co.id</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fab fa-whatsapp text-blue-600 text-sm w-4"></i>
                                <span>0859-3547-1777 (09:00 - 18:00 WIB)</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <i class="fas fa-phone text-blue-600 text-sm w-4"></i>
                                <span>0857-3547-1777 (09:00 - 18:00 WIB)</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        {{-- Bottom Copyright --}}
        <div class="bg-blue-600 text-white text-center py-3 mt-12 text-[11px]">
            © Copyright Seduhan 2024. All right reserved
        </div>
    </footer>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    
    @stack('scripts')

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@auth
<script>
const _pusherGlobal = new Pusher("{{ env('PUSHER_APP_KEY') }}", { cluster: "{{ env('PUSHER_APP_CLUSTER') }}" });
_pusherGlobal.subscribe('chat-global').bind('App\\Events\\MessageSent', function(data) {
    const badge = document.getElementById('chat-badge');
    if (badge) {
        let count = parseInt(badge.textContent) || 0;
        count++;
        badge.textContent = count > 9 ? '9+' : count;
        badge.classList.remove('hidden');
    } else {
        const chatLink = document.querySelector('a[href="/chat"]');
        if (chatLink) {
            const newBadge = document.createElement('span');
            newBadge.id = 'chat-badge';
            newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold rounded-full min-w-[16px] h-4 flex items-center justify-center px-0.5';
            newBadge.textContent = '1';
            chatLink.classList.add('relative');
            chatLink.appendChild(newBadge);
        }
    }
});
</script>
@endauth

</body>
</html>