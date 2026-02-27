@extends('layouts.app')

@section('content')

@if($pencarians->isEmpty())

    <div class="flex justify-center items-center h-[60vh]">
        <p class="text-gray-500 text-lg">
            Belum ada kost tersedia
        </p>
    </div>

@else

    {{-- LIST KOST --}}
    <div class="space-y-5">
        @foreach($pencarians as $item)
            <div class="bg-white rounded-xl shadow p-4 flex gap-4">

                @if($item->foto)
                    <img src="{{ asset('storage/'.$item->foto) }}"
                         class="w-32 h-24 rounded-lg object-cover">
                @else
                    <div class="w-32 h-24 bg-gray-300 rounded-lg flex items-center justify-center text-xs">
                        No Image
                    </div>
                @endif

                <div class="flex-1">
                    <h2 class="font-bold text-lg">{{ $item->nama_kost }}</h2>
                    <p class="text-sm text-gray-500 mt-1">📍 {{ $item->lokasi }}</p>
                    <p class="text-sm mt-2">{{ $item->fasilitas }}</p>
                    <p class="font-bold mt-3">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        @endforeach
    </div>

@endif

@endsection