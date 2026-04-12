@extends('admin.layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Penyewa</h1>
        <p class="text-sm text-gray-500">Kelola pengajuan penyewa kost</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <table class="w-full text-left">
        <thead class="bg-blue-50 border-b text-sm text-gray-600 font-semibold">
            <tr>
                <th class="px-6 py-4">Nama Penyewa</th>
                <th class="px-6 py-4 text-center">Kost</th>
                <th class="px-6 py-4 text-center">Jumlah Orang</th>
                <th class="px-6 py-4 text-center">Tanggal Masuk</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($penyewas as $penyewa)
                <tr class="hover:bg-blue-50 transition">

                    {{-- USER --}}
                    <td class="px-6 py-4 flex items-center gap-4">
                        @if($penyewa->user->photo ?? false)
                            <img src="{{ asset('storage/'.$penyewa->user->photo) }}"
                                class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-600">
                                {{ strtoupper(substr($penyewa->user->username ?? 'U',0,1)) }}
                            </div>
                        @endif

                        <span class="font-semibold text-gray-800">
                            {{ $penyewa->user->username ?? $penyewa->user->name ?? 'User Tidak Ada' }}
                        </span>
                    </td>

                    {{-- KOST --}}
                    <td class="px-6 py-4 text-center text-gray-600 text-sm">
                        {{ $penyewa->kost->nama ?? '-' }}
                    </td>

                    {{-- JUMLAH --}}
                    <td class="px-6 py-4 text-center text-gray-600 text-sm">
                        {{ $penyewa->jumlah_orang }}
                    </td>

                    {{-- TANGGAL --}}
                    <td class="px-6 py-4 text-center text-gray-600 text-sm">
                        {{ \Carbon\Carbon::parse($penyewa->tgl_masuk)->format('d M Y') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.penyewa.update', $penyewa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <select name="status"
                                onchange="this.form.submit()"
                                class="px-2 py-2 rounded-full text-sm font-semibold border shadow-sm cursor-pointer
                                @if($penyewa->status == 'menunggu')
                                    bg-yellow-100 text-yellow-700 border-yellow-300
                                @elseif($penyewa->status == 'disetujui')
                                    bg-green-100 text-green-700 border-green-300
                                @elseif($penyewa->status == 'ditolak')
                                    bg-red-100 text-red-700 border-red-300
                                @endif">

                                <option value="menunggu" {{ $penyewa->status == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu
                                </option>

                                <option value="disetujui" {{ $penyewa->status == 'disetujui' ? 'selected' : '' }}>
                                    Disetujui
                                </option>

                                <option value="ditolak" {{ $penyewa->status == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                        </form>
                    </td>

                    {{-- DELETE --}}
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.penyewa.destroy', $penyewa->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus penyewa ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-gray-400">
                        Belum ada pengajuan penyewa
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="p-6 border-t bg-gray-50 flex justify-center">
        @if ($penyewas->hasPages())
            <nav class="flex items-center gap-2">

                {{-- PREVIOUS --}}
                @if ($penyewas->onFirstPage())
                    <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 text-sm">‹</span>
                @else
                    <a href="{{ $penyewas->previousPageUrl() }}"
                        class="px-3 py-2 rounded-lg bg-yellow-100 text-blue-700 hover:bg-yellow-200 text-sm">
                        ‹
                    </a>
                @endif

                {{-- PAGES --}}
                @foreach ($penyewas->getUrlRange(1, $penyewas->lastPage()) as $page => $url)
                    @if ($page == $penyewas->currentPage())
                        <span class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-bold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 text-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- NEXT --}}
                @if ($penyewas->hasMorePages())
                    <a href="{{ $penyewas->nextPageUrl() }}"
                        class="px-3 py-2 rounded-lg bg-yellow-100 text-blue-700 hover:bg-yellow-200 text-sm">
                        ›
                    </a>
                @else
                    <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 text-sm">›</span>
                @endif

            </nav>
        @endif
    </div>

</div>


{{-- <script>

document.getElementById('checkAll').onclick = function() {
let checkboxes = document.querySelectorAll('.checkbox-item');
checkboxes.forEach(cb => cb.checked = this.checked);
}

function submitDelete(){

let checked = document.querySelectorAll('.checkbox-item:checked');

if(checked.length === 0){
alert('Pilih minimal 1 penyewa');
return;
}

if(confirm('Hapus penyewa yang dipilih?')){
document.getElementById('deleteForm').submit();
}

}

</script> --}}

@endsection