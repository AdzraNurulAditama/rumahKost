@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F4F7FE] py-6 px-8 font-sans">
    
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 mb-8 bg-white w-fit px-4 py-2 rounded-full shadow-sm border border-blue-50">
        <div class="bg-blue-50 p-1.5 rounded-lg">
            <i class="fa-solid fa-house text-blue-600 text-xs"></i>
        </div>
        <span class="text-sm font-medium text-gray-500">Beranda</span>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-sm font-bold text-blue-600">Akun</span>
    </div>

    <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">
        
          {{-- SIDEBAR KIRI (Tetap Sama) --}}
          <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">
            {{-- User Mini Card --}}
            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php
                        $displayUsername = $user->username ?? $user->email ?? 'User';
                    @endphp
                    
                    {{-- Logika Tampilan Foto --}}
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                            class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm"
                            alt="Avatar">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=DBEAFE&color=2563EB&size=128" 
                            class="w-full h-full rounded-full object-cover border-2 border-white"
                            alt="Avatar">
                    @endif
                </div>
                <h3 class="font-bold text-gray-800 text-sm tracking-tight">{{ $user->username ?? 'Kim Seonho' }}</h3>
                <p class="text-[10px] text-gray-400 break-all">{{ $user->email ?? 'Seonho@gmail.com' }}</p>
            </div>

            {{-- Navigasi Menu --}}
            <nav class="space-y-6 px-2">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Aktivitas</p>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 bg-white rounded-xl shadow-sm border border-gray-50">
                            <i class="fa-solid fa-clipboard-list w-4 text-gray-500"></i> Daftar Transaksi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-ticket w-4 text-gray-500"></i> Voucher
                        </a>
                        <a href="{{ route('user.disukai') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-heart w-4 text-gray-500"></i> Disukai
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-house w-4 text-gray-500"></i> Kosan Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-star w-4 text-gray-500"></i> Ulasan
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-comment-dots w-4 text-gray-500"></i> Pesan
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Akun</p>
                    <div class="space-y-1">
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
                            <i class="fa-solid fa-user w-4 text-blue-600"></i> Akun
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-location-dot w-4 text-gray-500"></i> Alamat
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-bell w-4 text-gray-500"></i> Notifikasi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-wallet w-4 text-gray-500"></i> Pembayaran
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition rounded-xl">
                                <i class="fa-solid fa-right-from-bracket w-4 text-red-400"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        {{-- MAIN CONTENT --}}
        <div class="flex-1 bg-white rounded-[32px] shadow-sm border border-gray-100 min-h-[85vh] p-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-black text-gray-800">Akun</h2>
                <button onclick="openModal()" class="p-2 border border-blue-50 rounded-lg text-blue-600 hover:bg-blue-50 transition shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>
            <hr class="border-gray-100 mb-10">

            {{-- MODAL POPUP --}}
            <div id="editModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
                <div onclick="closeModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>
                <div class="relative bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0" id="modalContent">
                    
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-blue-50/30">
                        <div>
                            <h3 class="text-xl font-black text-gray-800">Lengkapi Profil</h3>
                            <p class="text-xs text-gray-400 mt-1">Perbarui informasi akun Anda</p>
                        </div>
                        <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-gray-400 hover:text-red-500 transition-all shadow-sm">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
            
                    <div class="p-8">
                        {{-- TOMBOL HAPUS FOTO --}}
                        @if($user->photo)
                        <div class="mb-6 flex items-center justify-between p-4 bg-red-50 rounded-2xl border border-red-100">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $user->photo) }}" class="w-12 h-12 rounded-lg object-cover border border-white">
                                <div>
                                    <p class="text-[12px] font-bold text-red-700">Foto profil aktif</p>
                                    <p class="text-[10px] text-red-400">Klik hapus untuk reset ke default</p>
                                </div>
                            </div>
                            <form action="{{ route('user.profile.photo.delete') }}" method="POST" onsubmit="return confirm('Hapus foto profil?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-white text-red-500 text-[11px] font-black rounded-xl border border-red-200 hover:bg-red-500 hover:text-white transition-all uppercase">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                        @endif

                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-3 border-gray-200 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border-gray-200 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Nomor HP</label>
                                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" class="w-full px-4 py-3 border-gray-200 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Status</label>
                                    <input type="text" name="status" value="{{ old('status', $user->status) }}" class="w-full px-4 py-3 border-gray-200 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" class="w-full px-4 py-3 border-gray-200 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[13px] font-bold text-gray-700">Jenis Kelamin</label>
                                    <div class="flex gap-4 py-2">
                                        <label class="text-sm"><input type="radio" name="jenis_kelamin" value="Laki-laki" @checked($user->jenis_kelamin == 'Laki-laki')> Laki-laki</label>
                                        <label class="text-sm"><input type="radio" name="jenis_kelamin" value="Perempuan" @checked($user->jenis_kelamin == 'Perempuan')> Perempuan</label>
                                    </div>
                                </div>
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-2xl border border-dashed border-gray-200">
                                    <label class="text-[13px] font-bold text-gray-700 block mb-2">Unggah Foto Baru</label>
                                    <input type="file" name="photo" class="text-xs">
                                </div>
                            </div>
                            <div class="mt-8 flex gap-4">
                                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 rounded-2xl border font-black text-gray-400 uppercase tracking-widest">Batal</button>
                                <button type="submit" class="flex-1 px-6 py-3 rounded-2xl bg-blue-600 text-white font-black hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all uppercase tracking-widest">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- DISPLAY DATA --}}
            <div class="flex flex-col lg:flex-row gap-16">
                <div class="w-full lg:w-[260px] flex flex-col items-center">
                    <div class="bg-[#EEF4FF] rounded-[24px] p-8 w-full flex flex-col items-center border border-blue-50">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" class="w-24 h-24 rounded-full border-4 border-white shadow-sm mb-4 object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=FFFFFF&color=2563EB&size=128" class="w-24 h-24 rounded-full border-4 border-white shadow-sm mb-4">
                        @endif
                        <div class="text-center">
                            <h4 class="font-bold text-gray-800 text-lg">{{ $user->username ?? 'User' }}</h4>
                            <p class="text-[11px] text-gray-400 tracking-wide">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 max-w-[500px] space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-1 block">Nama Lengkap</label>
                            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-gray-600 text-sm font-medium">{{ $user->username ?? '-' }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-1 block">Gender</label>
                                <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-gray-600 text-sm capitalize">{{ $user->jenis_kelamin ?? '-' }}</div>
                            </div>
                            <div>
                                <label class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-1 block">Lahir</label>
                                <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-gray-600 text-sm">{{ $user->tanggal_lahir ? date('d M Y', strtotime($user->tanggal_lahir)) : '-' }}</div>
                            </div>
                        </div>
                        <div>
                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-1 block">Kontak</label>
                            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-gray-600 text-sm">{{ $user->nomor_telepon ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-[2px] mb-1 block">Status</label>
                            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 text-gray-600 text-sm">{{ $user->status ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('editModal');
    const modalContent = document.getElementById('modalContent');
    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); modalContent.classList.add('scale-100', 'opacity-100'); }, 10);
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 200);
        document.body.style.overflow = 'auto';
    }
</script>
@endsection