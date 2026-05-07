@extends('layouts.auth')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-blue-50">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">

        <div class="text-center mb-6">

            <h1 class="text-3xl font-bold">
                <span class="text-blue-700">Rumah</span><span class="text-orange-500">Kost</span><span class="text-pink-500">Putri</span>
            </h1>

            <p class="text-blue-600 mt-2 font-semibold">
                Verifikasi OTP
            </p>

        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">

            @csrf

            <input type="text"
                name="otp"
                placeholder="Masukkan 6 digit OTP"
                class="w-full border rounded-xl px-4 py-3 mb-4 focus:ring-2 focus:ring-blue-500 outline-none">

            <button type="submit"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold transition">

                Verifikasi OTP

            </button>

        </form>

    </div>

</div>

@endsection