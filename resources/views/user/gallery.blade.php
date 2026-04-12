@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-10 px-4">

 {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('kost.detail', $kost->id) }}"
       class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Detail Kost
    </a>


    <h1 class="text-2xl font-bold mb-6">Semua Foto - {{ $kost->nama }}</h1>

    {{-- GRID FOTO --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($kost->images as $index => $img)
        <div class="overflow-hidden rounded-xl shadow cursor-pointer">
            <img src="{{ asset('images/kost/'.$img->image) }}"
                 class="w-full h-60 object-cover hover:scale-110 transition"
                 onclick="openModal({{ $index }})">
        </div>
        @endforeach
    </div>

    {{-- VIDEO --}}
    @if($kost->videos && $kost->videos->count() > 0)
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-6">Video Kost</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($kost->videos as $vid)
            <div class="rounded-xl overflow-hidden shadow border border-gray-200">
                <video controls class="w-full max-h-64 bg-black">
                    <source src="{{ asset('videos/kost/'.$vid->video) }}" type="video/mp4">
                    Browser kamu tidak mendukung video.
                </video>
                @if($vid->judul)
                    <p class="text-sm text-gray-600 px-3 py-2">📌 {{ $vid->judul }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- MODAL --}}
<div id="modal" class="fixed inset-0 bg-black/90 hidden z-50 flex items-center justify-center">
    <button onclick="closeModal()" class="absolute top-5 right-5 text-white text-3xl z-50">✕</button>
    <div class="w-full max-w-4xl flex items-center justify-center">
        <div class="swiper w-full">
            <div class="swiper-wrapper">
                @foreach($kost->images as $img)
                <div class="swiper-slide flex items-center justify-center">
                    <img src="{{ asset('images/kost/'.$img->image) }}"
                         class="max-h-[80vh] max-w-full object-contain rounded-lg">
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next !text-white"></div>
            <div class="swiper-button-prev !text-white"></div>
        </div>
    </div>
</div>

<script>
let swiper;

function openModal(index) {
    const modal = document.getElementById("modal");
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    if (!swiper) {
        swiper = new Swiper('.swiper', {
            loop: false,
            centeredSlides: true,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
    swiper.slideTo(index, 0);
}

function closeModal() {
    document.getElementById("modal").classList.add("hidden");
}
</script>

@endsection