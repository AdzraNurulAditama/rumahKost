@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-pink-50 to-orange-50">

    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-gray-100">

        {{-- LOGO --}}
        <div class="text-center mb-8">

            <h1 class="text-4xl font-extrabold tracking-tight">

                <span class="text-blue-700">
                    Rumah<span class="text-orange-400">Kost</span><span class="text-pink-400">Putri</span>
                </span>

            </h1>

            <p class="text-blue-600 font-semibold mt-2 text-sm">
                Login
            </p>

        </div>

        {{-- FORM --}}
        <form action="{{ route('login.process') }}" method="POST" class="space-y-5">

            @csrf

            {{-- EMAIL --}}
            <div>

                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="email@example.com"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >

            </div>

            {{-- PASSWORD --}}
            <div>

                <label class="block text-sm font-semibold mb-2 text-gray-700">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full border border-gray-300 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                >

            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 transition text-white py-3 rounded-2xl font-semibold shadow-md"
            >
                Masuk
            </button>

        </form>

        {{-- REGISTER --}}
        <p class="text-center mt-6 text-sm text-gray-600">

            Belum punya akun?

            <a href="{{ route('register') }}"
               class="text-blue-600 font-bold hover:underline">
                Daftar
            </a>

        </p>

    </div>

</div>

@endsection