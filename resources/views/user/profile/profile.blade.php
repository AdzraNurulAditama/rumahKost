@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-10 space-y-14">

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-5 py-3 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-5 py-3 rounded-xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= PROFILE CARD ================= --}}
    <div class="bg-white rounded-[40px] border p-10 flex flex-col md:flex-row gap-10 shadow-sm items-center md:items-start">

        {{-- 🔴 FOTO PROFILE --}}
        {{-- FOTO DISIMPAN OTOMATIS KE DATABASE --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="photoForm">
            @csrf

            <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*">

            <div onclick="document.getElementById('photoInput').click()"
                 class="relative w-40 h-40 group cursor-pointer">

                <img
                    id="photoPreview"
                    src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                    class="w-full h-full rounded-full object-cover border bg-gray-100 transition group-hover:brightness-75"
                >

                <div
                    class="absolute inset-0 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition text-sm font-semibold"
                >
                    Ganti Foto
                </div>
            </div>
        </form>
        {{-- 🔴 FOTO PROFILE --}}

        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-extrabold mb-1">{{ $user->name }}</h1>
            <p class="text-gray-500 mb-6">{{ $user->email }}</p>

            <span class="inline-block bg-blue-50 text-blue-600 text-xs font-semibold px-4 py-1 rounded-full">
                Akun Aktif
            </span>
        </div>

    </div>

    {{-- ================= EDIT PROFILE ================= --}}
    <div class="bg-white rounded-[40px] border p-12 shadow-sm">
        <h2 class="text-2xl font-extrabold mb-10 text-[#0047FF]">
            Edit <span class="text-[#FFB800]">Profil</span>
        </h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-8">

                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border rounded-xl px-5 py-2.5 focus:outline-none focus:ring focus:ring-blue-200">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border rounded-xl px-5 py-2.5 focus:outline-none focus:ring focus:ring-blue-200">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end pt-6">
                <button
                    class="px-10 py-2.5 bg-[#0047FF] text-white rounded-xl font-semibold hover:bg-blue-700 transition"
                >
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- ================= GANTI PASSWORD ================= --}}
    <div class="bg-white rounded-[40px] border p-12 shadow-sm">
        <h2 class="text-2xl font-extrabold mb-10 text-[#0047FF]">
            Ubah <span class="text-[#FFB800]">Password</span>
        </h2>

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-8">

                <div>
                    <label class="block text-sm font-semibold mb-2">Password Lama</label>
                    <input type="password" name="current_password"
                           class="w-full border rounded-xl px-5 py-2.5 focus:outline-none focus:ring focus:ring-blue-200">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Password Baru</label>
                    <input type="password" name="password"
                           class="w-full border rounded-xl px-5 py-2.5 focus:outline-none focus:ring focus:ring-blue-200">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border rounded-xl px-5 py-2.5 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

            </div>

            <div class="flex justify-end pt-6">
                <button
                    class="px-10 py-2.5 bg-[#0047FF] text-white rounded-xl font-semibold hover:bg-blue-700 transition"
                >
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>

{{-- ================= JS FOTO AUTO PREVIEW + AUTO SUBMIT ================= --}}
<script>
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('photoPreview');
    const form = document.getElementById('photoForm');

    input?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(file);

        setTimeout(() => form.submit(), 300);
    });
</script>

@endsection
