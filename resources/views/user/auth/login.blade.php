@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-md">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold">
                <span class="text-blue-700">Rumah</span><span class="text-orange-500">Kost</span>
            </h1>
            <p class="text-blue-600 font-semibold mt-1">Login</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email"
                    placeholder="email@example.com"
                    class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    placeholder="minimal 8 karakter"
                    class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button type="submit"
                class="w-full bg-blue-700 text-white py-2 rounded-xl hover:bg-blue-800 transition">
                Masuk
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 font-semibold">Daftar</a>
        </p>

    </div>

</div>
@endsection
