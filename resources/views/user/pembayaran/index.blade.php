@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4">
    <div class="flex items-center justify-between mb-12">

        {{-- STEP 1 --}}
        <div class="flex flex-col items-center text-blue-600">
            <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-sm mt-2 font-medium">Ajukan sewa</p>
        </div>
    
        <div class="flex-1 h-1 bg-blue-600"></div>
    
        {{-- STEP 2 --}}
        <div class="flex flex-col items-center text-blue-600">
            <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                </svg>
            </div>
            <p class="text-sm mt-2 font-medium">Menunggu persetujuan</p>
        </div>
    
        <div class="flex-1 h-1 bg-blue-600"></div>
    
        {{-- STEP 3 --}}
        <div class="flex flex-col items-center text-gray-400">
            <div class="w-8 h-8 rounded-full border-4 border-blue-600 bg-white flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                </svg>
            </div>
            <p class="text-sm mt-2">Bayar sewa pertama</p>
        </div>
    
        <div class="flex-1 h-1 bg-gray-300"></div>
    
        {{-- STEP 4 --}}
        <div class="flex flex-col items-center text-gray-400">
            <div class="w-8 h-8 rounded-full border-4 border-gray-300 bg-white"></div>
            <p class="text-sm mt-2">Check-in</p>
        </div>
    
    </div>
    {{-- DETAIL KOST --}}
    <div class="bg-white rounded-2xl shadow p-5 mb-8 flex gap-4 items-center">

        @if($sewa->kost)

        <img 
        src="{{ asset('images/kost/'.$sewa->kost->images->first()->image) }}" 
        class="w-24 h-24 object-cover rounded-xl">
    
    
        <div>
            <h3 class="font-bold text-lg">
                {{ $sewa->kost->nama }}
            </h3>
    
            <p class="text-sm text-gray-500">
                {{ $sewa->kost->alamat }}
            </p>
    
            <p class="text-blue-600 font-bold mt-2">
                Rp {{ number_format($sewa->kost->harga, 0, ',', '.') }}
            </p>
        </div>
    
    @else
        <p class="text-red-500">Data kost tidak ditemukan</p>
    @endif

    </div>
    {{-- PAYMENT --}}
    <div class="bg-white p-6 rounded-2xl shadow max-w-xl mx-auto text-center">
    
        <h2 class="text-xl font-bold mb-6">
            Bayar Sewa Pertama
        </h2>
    
        <p class="text-gray-500 mb-6">
            Klik tombol di bawah untuk melakukan pembayaran 
        </p>
    
        <button onclick="payNow()"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">
            Bayar Sekarang
        </button>

        <div class="flex flex-col items-center {{ $sewa->status == 'approved' ? 'text-blue-600' : 'text-gray-400' }}">
    
    </div>

</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
function payNow() {
    snap.pay(@json($snapToken), {
        onSuccess: function(result){
            alert("Pembayaran berhasil!");
            console.log(result);
        },
        onPending: function(result){
            alert("Menunggu pembayaran...");
        },
        onError: function(result){
            alert("Pembayaran gagal!");
        }
    });
}
</script>

@endsection