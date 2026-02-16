<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RumahKost</title>
    
    {{-- Tailwind & FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFF]">

    <div class="flex min-h-screen">
        
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed h-full shadow-sm">
            <div class="p-8">
                <a href="/" class="text-2xl font-bold text-[#0047FF]">
                    Rumah<span class="text-[#FFB800]">Cewe</span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-400 hover:text-blue-600 rounded-xl transition">
                    <i class="fa-solid fa-house-chimney w-5"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-400 hover:text-blue-600 rounded-xl transition">
                    <i class="fa-solid fa-users w-5"></i>
                    <span class="font-semibold text-sm">Kelola Penyewa</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-400 hover:text-blue-600 rounded-xl transition">
                    <i class="fa-solid fa-calendar-check w-5"></i>
                    <span class="font-semibold text-sm">Kelola Pemesanan</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-gray-400 hover:text-blue-600 rounded-xl transition">
                    <i class="fa-solid fa-wallet w-5"></i>
                    <span class="font-semibold text-sm">Data Keuangan</span>
                </a>
                
                {{-- Link Aktif (Data Kost) --}}
                <a href="#" class="flex items-center gap-4 px-4 py-3 bg-blue-50 text-[#0047FF] rounded-xl border-r-4 border-[#0047FF] transition">
                    <i class="fa-solid fa-file-invoice w-5"></i>
                    <span class="font-bold text-sm">Data Kost</span>
                </a>
            </nav>

            <div class="p-6 border-t border-gray-50">
                <a href="#" class="flex items-center gap-4 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition">
                    <i class="fa-solid fa-right-from-bracket rotate-180"></i>
                    <span class="font-bold text-sm">Log out</span>
                </a>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 ml-64 flex flex-col">
            
            {{-- TOPBAR --}}
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-10">
                <div class="relative w-1/3">
                    <input type="text" 
                        placeholder="Cari kost atau kamar" 
                        class="w-full pl-12 pr-4 py-2 bg-white border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <div class="absolute left-1 top-1 bg-[#0047FF] w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fa fa-search text-white text-[10px]"></i>
                    </div>
                </div>

                <div class="flex items-center gap-3 border border-gray-200 px-4 py-1.5 rounded-full bg-white cursor-pointer hover:shadow-sm transition">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-gray-700">Kim seonho</span>
                </div>
            </header>

            {{-- CONTENT WRAPPER --}}
            <div class="p-10">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>