<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RumahKost</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-800">


{{-- ================= NAVBAR ================= --}}
<nav class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-[#0047FF]">
                Rumah<span class="text-[#FFB800]">Kost</span>
            </a>
        </div>

        <div class="flex-1 max-w-md px-8">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <div class="bg-[#0047FF] rounded-full w-8 h-8 flex items-center justify-center">
                        <i class="fa fa-search text-white text-xs"></i>
                    </div>
                </div>
                <input type="text" 
                    class="block w-full pl-14 pr-4 py-2.5 border border-gray-300 rounded-full text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm" 
                    placeholder="Cari kost atau kamar">
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <a href="{{ route('user.disukai') }}" class="hover:text-blue-600">Favorit</a>
            </div>
            
            <button class="bg-[#0047FF] text-white px-7 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-blue-700 transition">
                Sewa
            </button>

            {{-- USER DROPDOWN --}}
            <a href="{{ route('user.profile') }}" class="flex items-center gap-2 border border-gray-300 px-2 py-1 rounded-full shadow-sm cursor-pointer hover:shadow-md transition bg-white">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border border-gray-50">
                    @auth
                        @php
                            $user = Auth::user();
                            $navName = $user->username ?? $user->email ?? 'U';
                        @endphp

                        {{-- Logika Foto vs Inisial di Navbar --}}
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" 
                                 class="w-full h-full object-cover" 
                                 alt="Profile Photo">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($navName) }}&background=DBEAFE&color=2563EB&size=64"
                                 class="w-full h-full object-cover"
                                 alt="User Inisial">
                        @endif
                    @else
                        <i class="fa fa-user text-gray-400"></i>
                    @endauth
                </div>
                
                @auth
                    <span class="text-xs font-bold pr-2">
                        {{ Auth::user()->username ?? explode('@', Auth::user()->email)[0] }}
                    </span>
                @endauth
            </a>
        </div>
    </div>
</nav>

{{-- ================= CONTENT ================= --}}
<main>
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white pt-20 border-t mt-32">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 pb-20">
            
            <div class="md:col-span-4">
                <h2 class="text-3xl font-bold text-[#0047FF] mb-4">Rumah<span class="text-[#FFB800]">Kost</span></h2>
                <p class="text-gray-500 text-sm leading-relaxed mb-6 max-w-xs">
                    Temukan "info kost murah" dan hunian nyaman hanya di RumahKost. Mau cari kost idaman?
                </p>
                
                <h4 class="font-bold text-sm mb-4">Dapatkan update seputar RumahKost</h4>
                <div class="flex gap-4 mb-8">
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-red-600 text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-sky-400 text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white"><i class="fab fa-tiktok"></i></a>
                </div>

                <h4 class="font-bold text-sm mb-4">Sewa Kosan makin mudah menggunakan aplikasi</h4>
                <div class="flex gap-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Play Store" class="h-10">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store" class="h-10">
                </div>
            </div>

            <div class="md:col-span-2">
                <h4 class="font-bold mb-6">RumahKost</h4>
                <ul class="space-y-4 text-gray-500 text-sm">
                    <li><a href="#" class="hover:text-blue-600">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-blue-600">Pusat Bantuan</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="font-bold mb-6">Kebijakan</h4>
                <ul class="space-y-4 text-gray-500 text-sm">
                    <li><a href="#" class="hover:text-blue-600">Syarat dan Ketentuan</a></li>
                    <li><a href="#" class="hover:text-blue-600">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="font-bold mb-6">Customer Care</h4>
                <ul class="space-y-4 text-gray-500 text-sm">
                    <li><a href="#" class="hover:text-blue-600">Hubungi Kami</a></li>
                    <li><a href="#" class="hover:text-blue-600">Konfirmasi Pembayaran</a></li>
                    <li><a href="#" class="hover:text-blue-600">FAQ / Bantuan</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="font-bold mb-6">Kontak Kami</h4>
                <ul class="space-y-4 text-xs">
                    <li class="flex items-center gap-2 text-gray-600">
                        <i class="far fa-envelope text-blue-600"></i> customer.care@RumahKost.co.id
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <i class="fab fa-whatsapp text-blue-600"></i> 0812-3167-1777 (08.00 - 18.00 WIB)
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <i class="fab fa-whatsapp text-blue-600"></i> 0857-3147-1777 (08.00 - 18.00 WIB)
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg-[#0047FF] py-4">
        <p class="text-white text-center text-xs font-light">
            © Copyright RumahKost 2024. All right reserved
        </p>
    </div>
</footer>

</body>
</html>