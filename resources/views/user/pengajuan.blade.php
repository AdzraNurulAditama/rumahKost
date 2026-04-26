@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="max-w-7xl mx-auto px-6 py-10">

{{-- STEP --}}
<div class="flex items-center justify-between mb-12">

    <div class="flex flex-col items-center text-blue-600">
        <div class="w-10 h-10 rounded-full border-4 border-blue-600 flex items-center justify-center">
            <i class="fa-solid fa-check"></i>
        </div>
        <p class="text-sm mt-2 font-medium">Ajukan sewa</p>
    </div>

    <div class="flex-1 h-1 bg-gray-400 mx-2"></div>

    <div class="flex flex-col items-center text-gray-400">
        <div class="w-10 h-10 rounded-full border-4 border-gray-400 flex items-center justify-center">
            <i class="fa-solid fa-clock"></i>
        </div>
        <p class="text-sm mt-2">Menunggu persetujuan</p>
    </div>

    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>

    <div class="flex flex-col items-center text-gray-400">
        <div class="w-10 h-10 rounded-full border-4 border-gray-300"></div>
        <p class="text-sm mt-2">Bayar sewa pertama</p>
    </div>

    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>

    <div class="flex flex-col items-center text-gray-400">
        <div class="w-10 h-10 rounded-full border-4 border-gray-300"></div>
        <p class="text-sm mt-2">Check-in</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

{{-- KIRI --}}
<div class="lg:col-span-2 space-y-8">

<h1 class="text-3xl font-bold">Pengajuan Sewa</h1>

{{-- PILIH KAMAR --}}
<div class="bg-white border rounded-2xl p-6">
<h2 class="font-semibold mb-5">Pilih Tipe Kamar</h2>

@foreach($kamarsKosong as $tipe => $kamars)
<div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-blue-500 tipe-card"
onclick="pilihTipe(this, {{ $kamars->first()->id }}, {{ $kamars->first()->harga }})">

<div class="flex justify-between">
<div>
<p class="font-semibold">{{ $tipe }}</p>
<p class="text-sm text-gray-500">{{ $kamars->count() }} kamar</p>
</div>
<p class="text-blue-600 font-bold">
Rp {{ number_format($kamars->first()->harga,0,',','.') }}
</p>
</div>

</div>
@endforeach

</div>

{{-- ERROR --}}
@if(session('error'))
<div class="bg-red-100 text-red-600 p-3 rounded">
    {{ session('error') }}
</div>
@endif

{{-- FORM --}}
<form method="POST" action="{{ route('user.pengajuan.create', $kost->id) }}" onsubmit="return validasiForm()">
@csrf

<input type="hidden" name="kamar_id" id="kamar_id_input">

<div class="bg-white border rounded-2xl p-6">

<div class="space-y-4">
    <input type="number" name="jumlah_orang" id="jumlah_orang"
        value="1" min="1" max="2"
        class="w-full border rounded-lg px-3 py-2" required>

    <input type="date" name="tgl_masuk" id="tgl_masuk"
        class="w-full border rounded-lg px-3 py-2" required>
</div>

<div id="kamar-terpilih" class="hidden mt-3 text-blue-600 text-sm">
    Kamar: <span id="kamar-terpilih-label"></span>
</div>

<button type="submit"
class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
Ajukan Sewa
</button>

</div>
</form>

</div>

{{-- KANAN --}}
<div>
<div class="bg-white border rounded-2xl p-6 sticky top-6">

<h3 id="harga-display" class="text-2xl font-bold mb-4">
Rp {{ number_format($kost->harga,0,',','.') }}
</h3>

<div class="text-sm space-y-2">
<div class="flex justify-between">
<span>DP</span>
<span id="dp-display">Rp {{ number_format($kost->harga*0.3,0,',','.') }}</span>
</div>

<div class="flex justify-between">
<span>Pelunasan</span>
<span id="pelunasan-display">Rp {{ number_format($kost->harga*0.7,0,',','.') }}</span>
</div>

<div class="flex justify-between font-semibold border-t pt-2">
<span>Total</span>
<span id="total-display">Rp {{ number_format($kost->harga,0,',','.') }}</span>
</div>
</div>

</div>
</div>

</div>
</div>

<script>
function pilihTipe(el, kamarId, harga){

console.log("PILIH KAMAR:", kamarId);

document.querySelectorAll('.tipe-card').forEach(c=>{
c.classList.remove('border-blue-500','bg-blue-50');
});

el.classList.add('border-blue-500','bg-blue-50');

document.getElementById('kamar_id_input').value = kamarId;

document.getElementById('kamar-terpilih-label').textContent =
el.querySelector('p').textContent;

document.getElementById('kamar-terpilih').classList.remove('hidden');

// update harga
document.getElementById('harga-display').textContent =
'Rp '+harga.toLocaleString('id-ID');

document.getElementById('dp-display').textContent =
'Rp '+Math.round(harga*0.3).toLocaleString('id-ID');

document.getElementById('pelunasan-display').textContent =
'Rp '+Math.round(harga*0.7).toLocaleString('id-ID');

document.getElementById('total-display').textContent =
'Rp '+harga.toLocaleString('id-ID');
}

function validasiForm(){
let kamar = document.getElementById('kamar_id_input').value;

if(!kamar){
    alert("Pilih kamar dulu!");
    return false;
}

return true;
}
</script>

@endsection