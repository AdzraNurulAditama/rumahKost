@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

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
        class="relative rounded-[40px] overflow-hidden h-80 flex items-center justify-center"
    >

        <template x-for="(img, index) in images" :key="index">
            <img
                x-show="active === index"
                :src="img"
                x-transition.opacity.duration.700ms
                class="absolute inset-0 w-full h-full object-cover brightness-50"
            >
        </template>

        <div class="relative text-center text-white z-10">
            <h1 class="text-6xl font-bold mb-2 italic">
                Rumah<span class="text-orange-300">Kost</span>
            </h1>
            <p class="text-xl font-light mb-8">
                Kosan nyaman & strategis di Karawang
            </p>

            <div class="flex justify-center gap-16 text-center">
                <div>
                    <span class="block text-3xl font-bold">{{ $kosts->count() }}</span>
                    <span class="text-xs">Pilihan kost</span>
                </div>

                <div class="border-l border-white/30 px-16">
                    <span class="block text-3xl font-bold italic">Karawang</span>
                    <span class="text-xs">Lokasi strategis</span>
                </div>

                <div class="border-l border-white/30 pl-16">
                    <span class="block text-3xl font-bold">100</span>
                    <span class="text-xs">Penghuni puas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 ml-12">
        <button
            class="px-6 py-2 border border-blue-400 text-blue-500 rounded-xl
                   flex items-center gap-2 font-medium hover:bg-blue-50 transition"
        >
            <i class="fa fa-sliders"></i> Filter Kost
        </button>
    </div>

    <div class="mt-12 space-y-16">

        @forelse ($kosts as $kost)
        <div>

            <div class="flex items-center gap-4 mb-6">
                <h2 class="text-3xl font-extrabold text-[#0047FF] whitespace-nowrap">
                    @php
                        $nama = explode(' ', $kost->nama);
                        $lastWord = array_pop($nama);
                        $firstName = implode(' ', $nama);
                    @endphp
                    {{ strtoupper($firstName) }}
                    <span class="text-[#FFB800]">{{ strtoupper($lastWord) }}</span>
                </h2>
                <div class="h-[1.5px] bg-gray-200 w-full"></div>
            </div>

            <a href="{{ route('kost.detail', $kost->id) }}" class="block group">
                <div
                    class="bg-white rounded-[40px] border p-6 flex flex-col md:flex-row gap-8
                           shadow-sm group-hover:shadow-md transition"
                >

                    <div class="w-full md:w-[450px] h-64 overflow-hidden rounded-[30px] bg-gray-100">
                        <img
                            src="{{ asset('images/kost/' . $kost->foto) }}"
                            alt="{{ $kost->nama }}"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <div class="flex-1 flex flex-col justify-between py-2">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">
                                {{ $kost->nama }}
                            </h3>

                            <p class="text-sm text-gray-500 flex items-start gap-2 mb-4 leading-relaxed">
                                <i class="fa fa-map-marker-alt mt-1 text-blue-600"></i>
                                {{ $kost->lokasi }}
                            </p>

                            <div class="flex flex-wrap gap-2">
                                @foreach ($kost->fasilitas as $f)
                                    <span
                                        class="text-[10px] bg-gray-100 text-gray-700 px-3 py-1.5
                                               rounded-md border border-gray-200 font-medium"
                                    >
                                        {{ $f }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <p class="text-lg font-bold">
                                <span class="text-sm font-normal">Rp</span>
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
            <p>Tidak ada kost ditemukan.</p>
        </div>
        @endforelse

    </div>
</div>

@endsection
