@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- TOAST --}}
<div id="toast"
     class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-gray-100 shadow-xl rounded-2xl px-5 py-4 transition-all duration-500 opacity-0 translate-y-[20px] pointer-events-none"
     style="min-width:260px">
    <div id="toast-icon" class="w-9 h-9 rounded-full flex items-center justify-center text-lg shrink-0"></div>
    <div>
        <p id="toast-title" class="font-bold text-gray-800 text-sm leading-tight"></p>
        <p id="toast-sub" class="text-xs text-gray-400 mt-0.5"></p>
    </div>
</div>

<div class="min-h-screen bg-[#F4F7FE] py-6 px-8 font-sans">

    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 mb-8 bg-white w-fit px-4 py-2 rounded-full shadow-sm border border-blue-50">
        <div class="bg-blue-50 p-1.5 rounded-lg">
            <i class="fa-solid fa-house text-blue-600 text-xs"></i>
        </div>
        <span class="text-sm font-medium text-gray-500">Beranda</span>
        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
        <span class="text-sm font-bold text-blue-600">Disukai</span>
    </div>

    <div class="max-w-[1400px] mx-auto flex flex-col md:flex-row gap-6 items-start">

        {{-- SIDEBAR --}}
        <div class="w-full md:w-[280px] bg-[#E9F0FF] rounded-[32px] p-4 min-h-[85vh]">

            <div class="bg-white rounded-[24px] p-6 mb-6 flex flex-col items-center text-center">
                <div class="w-16 h-16 mb-3">
                    @php $displayUsername = $user->username ?? $user->email ?? 'User'; @endphp
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($displayUsername) }}&background=DBEAFE&color=2563EB&size=128"
                            class="w-full h-full rounded-full object-cover border-2 border-white">
                    @endif
                </div>
                <h3 class="font-bold text-gray-800 text-sm tracking-tight">{{ $user->username ?? 'User' }}</h3>
                <p class="text-[10px] text-gray-400 break-all">{{ $user->email ?? '' }}</p>
            </div>

            <nav class="space-y-6 px-2">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Aktivitas</p>
                    <div class="space-y-1">

                        <a href="{{ route('user.disukai') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-blue-600 bg-white rounded-xl shadow-sm border border-blue-50 font-bold">
                            <i class="fa-solid fa-heart w-4 text-blue-600"></i> Disukai
                        </a>

                        <a href="{{ route('user.kosan.saya') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-house w-4 text-gray-500"></i> Kosan Saya
                        </a>

                        <a href="{{ route('user.ulasan') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-star w-4 text-gray-500"></i> Ulasan
                        </a>

                        <a href="{{ route('user.chat.room', 1) }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-comment-dots w-4 text-gray-500"></i> Pesan
                        </a>

                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-2">Akun</p>
                    <div class="space-y-1">

                        <a href="{{ route('user.profile') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-user w-4 text-gray-500"></i> Akun
                        </a>

                        <a href="#"
                           class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-gray-600 hover:bg-white/50 transition rounded-xl">
                            <i class="fa-solid fa-bell w-4 text-gray-500"></i> Notifikasi
                        </a>


                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition rounded-xl">
                                <i class="fa-solid fa-right-from-bracket w-4 text-red-400"></i> Keluar
                            </button>
                        </form>

                    </div>
                </div>
            </nav>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 bg-white rounded-[32px] p-10">

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Disukai</h2>
                    <p class="text-sm text-gray-400 mt-1">{{ $likes->count() }} kost tersimpan</p>
                </div>
                @if($likes->count() > 0)
                <span class="bg-red-50 text-red-400 text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-2">
                    <i class="fa-solid fa-heart"></i> {{ $likes->count() }} Favorit
                </span>
                @endif
            </div>

            @if($likes->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="favorites-grid">
                @foreach($likes as $like)
                <div class="group border border-gray-100 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 bg-white"
                     id="card-{{ $like->kost->id }}">

                    <div class="relative overflow-hidden h-44">
                        @php $img = $like->kost->images->first(); @endphp
                        @if($img)
                            <img src="{{ asset('images/kost/' . $img->image) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                                <i class="fa-solid fa-house text-blue-300 text-4xl"></i>
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-blue-600 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                            {{ $like->kost->jenis ?? 'Kost' }}
                        </span>

                        <button onclick="hapusFavorit({{ $like->kost->id }}, '{{ $like->kost->nama }}', this)"
                                data-url="{{ route('user.like.toggle', $like->kost->id) }}"
                                class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200 hover:scale-110">
                            <i class="fa-solid fa-heart text-sm"></i>
                        </button>
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1">{{ $like->kost->nama }}</h3>
                        <p class="text-[11px] text-gray-400 flex items-center gap-1 mb-3">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            {{ $like->kost->alamat }}
                        </p>
                        <p class="text-blue-600 font-bold text-sm mb-4">
                            Rp {{ number_format($like->kost->harga ?? 0, 0, ',', '.') }}
                            <span class="text-gray-400 font-normal text-xs">/bulan</span>
                        </p>
                        <a href="{{ route('kost.detail', $like->kost->id) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl transition duration-200">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fa-regular fa-heart text-red-300 text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Favorit</h3>
                <p class="text-sm text-gray-400 mb-6 max-w-xs">
                    Cari kost idamanmu dan tekan tombol ❤️ untuk menyimpannya di sini.
                </p>
                <a href="{{ route('home') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition duration-200">
                    Jelajahi Kost
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

<script>
function hapusFavorit(kostId, kostNama, btn) {
    const url  = btn.getAttribute('data-url');
    const card = document.getElementById('card-' + kostId);

    btn.classList.add('scale-90', 'opacity-50');
    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'unliked') {
            card.classList.add('opacity-0', 'scale-95', '-translate-y-2');
            card.style.transition = 'all 0.4s ease';
            setTimeout(() => {
                card.remove();
                updateCount();
            }, 400);
            showToast('🤍', 'bg-gray-50', 'text-gray-400', 'Dihapus dari Favorit', kostNama + ' dihapus dari daftar');
        }
    })
    .catch(err => {
        btn.classList.remove('scale-90', 'opacity-50');
        btn.disabled = false;
    });
}

function updateCount() {
    const grid  = document.getElementById('favorites-grid');
    const cards = grid ? grid.querySelectorAll('[id^="card-"]') : [];
    const count = cards.length;

    const countEl = document.querySelector('p.text-sm.text-gray-400.mt-1');
    if (countEl) countEl.textContent = count + ' kost tersimpan';

    const badge = document.querySelector('.bg-red-50.text-red-400');
    if (badge) {
        if (count === 0) {
            badge.remove();
            grid.innerHTML = `
                <div class="col-span-3 flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6">
                        <i class="fa-regular fa-heart text-red-300 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Favorit</h3>
                    <p class="text-sm text-gray-400 mb-6 max-w-xs">
                        Cari kost idamanmu dan tekan tombol ❤️ untuk menyimpannya di sini.
                    </p>
                    <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition duration-200">
                        Jelajahi Kost
                    </a>
                </div>`;
        } else {
            badge.innerHTML = `<i class="fa-solid fa-heart"></i> ${count} Favorit`;
        }
    }
}

function showToast(emoji, bgClass, textClass, title, sub) {
    const toast      = document.getElementById('toast');
    const toastIcon  = document.getElementById('toast-icon');
    const toastTitle = document.getElementById('toast-title');
    const toastSub   = document.getElementById('toast-sub');

    toastIcon.className = `w-9 h-9 rounded-full flex items-center justify-center text-lg shrink-0 ${bgClass} ${textClass}`;
    toastIcon.textContent = emoji;
    toastTitle.textContent = title;
    toastSub.textContent   = sub;

    toast.classList.remove('opacity-0', 'translate-y-[20px]', 'pointer-events-none');
    toast.classList.add('opacity-100', 'translate-y-0');

    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(() => {
        toast.classList.remove('opacity-100', 'translate-y-0');
        toast.classList.add('opacity-0', 'translate-y-[20px]', 'pointer-events-none');
    }, 3000);
}
</script>
@endsection