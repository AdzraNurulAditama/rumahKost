@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-md">

        {{-- LOGO --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-600">Rumah</span><span class="text-orange-400">Kost</span>
            </h1>
            <p class="text-blue-600 font-semibold">Register</p>
        </div>

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 p-3 rounded-lg text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium mb-1">Username</label>
                <input type="text" name="username"
                    value="{{ old('username') }}"
                    placeholder="Username unik"
                    class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="email@example.com"
                    class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nomor Telepon</label>
                <input type="text" name="nomor_telepon"
                    value="{{ old('nomor_telepon') }}"
                    placeholder="08xxxxxxx"
                    class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            {{-- Jenis Kelamin & Status --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status"
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Mahasiswa">Mahasiswa</option>
                        <option value="Karyawan">Karyawan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

            </div>

            {{-- Password --}}
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password"
                        placeholder="minimal 8 karakter"
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        placeholder="ulangi password"
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">
                Daftar Akun
            </button>

        </form>

        {{-- LOGIN LINK --}}
        <p class="text-center text-sm mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>

</div>

@endsection
