@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Carousel Hero --}}
    <div
        x-data="{
            images: [
                '{{ asset('images/carouselhero/car1.png') }}',
                '{{ asset('images/carouselhero/car2.png') }}',
                '{{ asset('images/carouselhero/car3.png') }}',
                '{{ asset('images/carouselhero/car4.png') }}'
            ],
            active: 0,
            start() {
                setInterval(() => {
                    this.active = (this.active + 1) % this.images.length
                }, 3500)
            }
        }"
        x-init="start()"
        class="relative rounded-[10px] overflow-hidden h-80 flex items-center justify-center"
    >
        {{-- Background Images --}}
        <template x-for="(img, index) in images" :key="index">
            <img
                x-show="active === index"
                :src="img"
                x-transition.opacity.duration.700ms
                class="absolute inset-0 w-full h-full object-cover "
            >
        </template>

        {{-- Text Overlay (Sesuai Gambar Referensi) --}}
        {{-- Removed as per user request --}}
    </div>

    {{-- Filter Button --}}
    <div class="mt-8">
        <button
            class="px-6 py-2 border border-blue-400 text-blue-500 rounded-xl
                   flex items-center gap-2 font-medium hover:bg-blue-50 transition"
        >
            <i class="fa fa-sliders"></i> Filter Kost
        </button>
    </div>

    {{-- List Kost --}}
    <div class="mt-12 space-y-16">
        @forelse ($kosts as $kost)
        <div>
            {{-- Header Nama Kost dengan Garis --}}
            <div class="flex items-center gap-4 mb-6">
                <h2 class="text-3xl font-extrabold text-[#0047FF] whitespace-nowrap">
                    @php
                        $namaArray = explode(' ', $kost->nama);
                        $lastWord = array_pop($namaArray);
                        $firstName = implode(' ', $namaArray);
                    @endphp
                    {{ strtoupper($firstName) }}
                    <span class="text-[#FFB800]">{{ strtoupper($lastWord) }}</span>
                </h2>
                <div class="h-[1.5px] bg-gray-200 w-full"></div>
            </div>

            {{-- Card Kost --}}
            <a href="{{ route('kost.detail', $kost->id) }}" class="block group">
                <div
                    class="bg-white rounded-[40px] border p-6 flex flex-col md:flex-row gap-8
                           shadow-sm group-hover:shadow-md transition"
                >
                    {{-- Image --}}
                    <div class="w-full md:w-[450px] h-72 overflow-hidden rounded-[30px] bg-gray-100">
                        <img
                            src="{{ asset('images/kost/' . $kost->foto) }}"
                            alt="{{ $kost->nama }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 flex flex-col justify-between py-2">
                        <div>
                            <h3 class="text-2xl font-bold mb-1 text-gray-800">
                                {{ $kost->nama }}
                            </h3>

                            <p class="text-sm text-gray-500 flex items-start gap-2 mb-6 leading-relaxed">
                                <i class="fa fa-map-marker-alt mt-1 text-blue-600"></i>
                                {{ $kost->lokasi }}
                            </p>

                            {{-- Facilities Tags --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach ($kost->fasilitas as $f)
                                    <span
                                        class="text-[11px] bg-gray-50 text-gray-600 px-4 py-1.5
                                               rounded-md border border-gray-100 font-medium"
                                    >
                                        {{ $f }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="text-right mt-6">
                            <p class="text-xl font-bold text-gray-900">
                                <span class="text-sm font-normal text-gray-500">Rp</span>
                                {{ number_format($kost->harga, 0, ',', '.') }}
                                <span class="text-sm font-normal text-gray-500">/ tahun</span>
                            </p>
                        </div>
                    </div>

                </div>
            </a>
        </div>

        @empty
        <div class="text-center py-20 text-gray-400">
            <i class="fa fa-search text-4xl mb-4"></i>
            <p>Tidak ada kost ditemukan.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection