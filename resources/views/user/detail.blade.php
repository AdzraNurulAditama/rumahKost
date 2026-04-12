@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="max-w-6xl mx-auto px-6 py-10 text-gray-800">

    @php
        $isLiked = \App\Models\Like::where('user_id', auth()->id())
                    ->where('kost_id', $kost->id)
                    ->exists();
    @endphp

    {{-- FOTO --}}
    @php $images = $kost->images; @endphp

    <div class="mb-6">
        <div class="w-full h-[300px] md:h-[400px] bg-gray-200 rounded-xl mb-4 overflow-hidden">
            @if($images && $images->count())
                <img id="mainImage"
                     src="{{ asset('images/kost/' . $images->first()->image) }}"
                     class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full text-gray-400">Tidak ada gambar</div>
            @endif
        </div>

        <div class="grid grid-cols-3 gap-4 h-[120px]">
            @for($i = 1; $i <= 3; $i++)
                <div class="bg-gray-200 rounded-xl overflow-hidden relative">
                    @if(isset($images[$i]))
                        <img src="{{ asset('images/kost/'.$images[$i]->image) }}"
                             onclick="changeImage(this.src)"
                             class="w-full h-full object-cover cursor-pointer">
                    @endif
                    @if($i == 3)
                        <a href="{{ route('user.gallery',$kost->id) }}"
                           class="absolute bottom-2 right-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                            Lihat Semua
                        </a>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-2">
        <div>
            <h1 class="text-3xl font-bold">{{ $kost->nama }}</h1>
            {{-- ✅ Badge jenis kost --}}
            <span class="inline-block mt-1 bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                {{ $kost->jenis }}
            </span>
        </div>
        <div class="flex gap-4 text-xl text-gray-500">
            <button onclick="toggleLike(this)" data-url="{{ route('user.like.toggle', $kost->id) }}">
                <i class="fa-heart {{ $isLiked ? 'fa-solid text-red-500' : 'fa-regular text-gray-400' }}"></i>
            </button>
            <button onclick="sharePage()">
                <i class="fa-solid fa-share-nodes"></i>
            </button>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-8 border-b pb-6">
        <div><i class="fa-solid fa-location-dot"></i> {{ $kost->lokasi }}</div>
        <div><i class="fa-solid fa-house"></i> {{ $kost->alamat }}</div>
        <div class="text-yellow-500">
            <i class="fa-solid fa-star"></i> {{ number_format($kost->reviews->avg('rating'), 1) ?? '0.0' }}
            <span class="text-gray-400">({{ $kost->reviews->count() }} ulasan)</span>
        </div>
        {{-- ✅ Sisa kamar --}}
        <div class="{{ $sisaKamar == 0 ? 'text-red-500' : 'text-green-600' }} font-semibold">
            <i class="fa-solid fa-bed"></i>
            @if($sisaKamar == 0) Kamar penuh
            @else Tersisa {{ $sisaKamar }} kamar
            @endif
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-10">

        {{-- LEFT --}}
        <div class="md:col-span-2">

            {{-- DESKRIPSI --}}
            <div class="mb-8">
                <h2 class="font-bold mb-2">Deskripsi</h2>
                <p class="text-sm text-gray-600">{{ $kost->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
            </div>

            {{-- ✅ TAMBAH: TIPE KAMAR TERSEDIA --}}
            @php
                $tipeKamar = \App\Models\Kamar::where('kost_id', $kost->id)
                    ->where('status', 'Kosong')
                    ->get()
                    ->groupBy('tipe_kamar');
            @endphp

            @if($tipeKamar->isNotEmpty())
            <div class="mb-8">
                <h2 class="font-bold mb-3">Tipe Kamar Tersedia</h2>
                <div class="space-y-3">
                    @foreach($tipeKamar as $tipe => $kamars)
                    <div class="border border-gray-200 rounded-xl p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $tipe }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fa-solid fa-door-open text-blue-500 mr-1"></i>
                                {{ $kamars->count() }} kamar tersedia
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-blue-600">Rp {{ number_format($kamars->first()->harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">/bulan</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- FASILITAS --}}
            <div class="mb-8">
                <h2 class="font-bold mb-3">Fasilitas</h2>
                @php
                    $fasilitas = is_array($kost->fasilitas) ? $kost->fasilitas : explode(',', $kost->fasilitas);
                @endphp
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                    @foreach($fasilitas as $item)
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-blue-500"></i>
                            {{ trim($item) }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- REVIEW --}}
            <div class="mt-12">
                <h2 class="text-xl font-bold mb-6">Ulasan Penghuni</h2>

                @auth
                <div class="bg-white p-5 rounded-xl shadow mb-8">
                    <form action="{{ route('review.store', $kost->id) }}" method="POST">
                        @csrf
                        <textarea name="komentar" rows="3"
                            class="w-full border rounded-lg p-3 text-sm"
                            placeholder="Tulis ulasan kamu..." required></textarea>
                        <div class="flex justify-between items-center mt-3">
                            @php $currentRating = old('rating') ?? ($kost->rating ?? 0); @endphp
                            <div class="flex gap-1 text-2xl cursor-pointer" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <span data-value="{{ $i }}"
                                        class="star {{ $i <= $currentRating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" required>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Kirim</button>
                        </div>
                    </form>
                </div>
                @else
                    <p class="text-sm text-gray-500 mb-6">Login dulu untuk memberi ulasan</p>
                @endauth

                <div class="space-y-4">
                    @forelse($kost->reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-xl border">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ strtoupper(substr($review->user->username ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-sm">{{ $review->user->username ?? 'tidak diketahui' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-yellow-500 text-sm">⭐ {{ $review->rating }}</span>
                                    @auth
                                        @if(auth()->id() == $review->user_id)
                                            <form action="{{ route('review.delete', $review->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="text-red-500 text-xs">Hapus</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2 ml-11">{{ $review->komentar }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada ulasan</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div>
            <div class="bg-white p-5 rounded-2xl shadow border sticky top-6">

                <h3 class="text-2xl font-bold mb-1 text-blue-600">
                    Rp {{ number_format($kost->harga ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-gray-400 mb-4">/bulan</p>

                @if($sisaKamar > 0)
                    <a href="{{ route('user.pengajuan', $kost->id) }}"
                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-semibold transition duration-200 shadow">
                        Ajukan Sewa
                    </a>
                @else
                    <button disabled
                       class="block w-full bg-gray-400 text-white text-center py-3 rounded-xl font-semibold cursor-not-allowed">
                        Kamar Penuh
                    </button>
                @endif

                <div class="mt-3">
                    <a href="{{ route('user.chat.kost', $kost->id) }}"
                       class="flex items-center justify-center gap-2 w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition duration-200 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.8L3 20l1.2-3.2A7.93 7.93 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Chat Admin
                    </a>
                    <p class="text-xs text-gray-500 mt-2 text-center">Tanya ketersediaan kamar langsung ke admin</p>
                </div>

            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    window.changeImage = function(src) {
        document.getElementById('mainImage').src = src;
    }

    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('ratingInput');
    let selectedRating = 0;

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            selectedRating = index + 1;
            ratingInput.value = selectedRating;
            updateStars(selectedRating);
        });
        star.addEventListener('mouseover', () => { updateStars(index + 1); });
        star.addEventListener('mouseleave', () => { updateStars(selectedRating); });
    });

    function updateStars(rating){
        stars.forEach((s, i) => {
            if(i < rating){ s.classList.add('text-yellow-400'); s.classList.remove('text-gray-300'); }
            else { s.classList.add('text-gray-300'); s.classList.remove('text-yellow-400'); }
        });
    }

    window.toggleLike = function(btn){
        const icon = btn.querySelector('i');
        const url = btn.getAttribute('data-url');
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'liked'){ icon.classList.remove('fa-regular'); icon.classList.add('fa-solid', 'text-red-500'); }
            else if(data.status === 'unliked'){ icon.classList.remove('fa-solid', 'text-red-500'); icon.classList.add('fa-regular'); }
        })
        .catch(err => console.log('ERROR:', err));
    }

    window.sharePage = function(){
        navigator.clipboard.writeText(window.location.href);
        alert("Link berhasil disalin!");
    }

});
</script>

@endsection