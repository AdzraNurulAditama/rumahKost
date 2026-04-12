@extends('admin.layouts.admin')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Kamar</h1>

    {{-- ✅ Info hasil search --}}
    @if(request('search'))
        <p class="text-sm text-gray-500 mb-4">
            Menampilkan kamar untuk kost: <span class="font-semibold text-blue-600">"{{ request('search') }}"</span>
            — {{ $totalKamar }} kamar ditemukan
            <a href="{{ route('admin.kamar.index') }}" class="ml-2 text-red-400 hover:text-red-600 text-xs">✕ Reset</a>
        </p>
    @endif

    {{-- STAT CARD --}}
    <div class="grid md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Total Kamar</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $totalKamar }}</h2>
            @if(request('search'))<p class="text-xs text-gray-400 mt-1">untuk "{{ request('search') }}"</p>@endif
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Kamar Terisi</p>
            <h2 class="text-2xl font-bold text-green-600">{{ $kamarTerisi }}</h2>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Kamar Kosong</p>
            <h2 class="text-2xl font-bold text-blue-600">{{ $kamarKosong }}</h2>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm">
            <p class="text-sm text-gray-500">Non-aktif / Renovasi</p>
            <h2 class="text-2xl font-bold text-red-500">{{ $kamarNonAktif }}</h2>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="flex justify-between items-center mb-4">
        <div></div>
        <a href="{{ route('admin.kamar.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow">
            + Tambah Kamar
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-6 py-3">Kost</th>
                    <th class="px-6 py-3">No Kamar</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse($kamars as $kamar)
                <tr class="hover:bg-gray-50 transition {{ $kamar->status == 'Non-aktif' ? 'opacity-60' : '' }}">
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ $kamar->kost->nama ?? '-' }}</td>
                    <td class="px-6 py-4 font-medium">{{ $kamar->nomor_kamar }}</td>
                    <td class="px-6 py-4">{{ $kamar->tipe_kamar }}</td>
                    <td class="px-6 py-4 font-semibold text-blue-600">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full inline-block
                                {{ $kamar->status == 'Kosong' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $kamar->status == 'Terisi' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $kamar->status == 'Non-aktif' ? 'bg-red-100 text-red-600' : '' }}">
                                {{ $kamar->status }}
                            </span>
                            @if($kamar->status == 'Non-aktif')
                                <p class="text-xs text-red-400 mt-1">Tidak tersedia untuk disewa</p>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick="openModal({{ $kamar->id }})"
                                class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-xs transition">
                                Edit
                            </button>
                            <button onclick="openDeleteModal({{ $kamar->id }})"
                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs transition">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">
                        @if(request('search'))
                            Tidak ada kamar untuk kost "{{ request('search') }}"
                        @else
                            Belum ada data kamar
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $kamars->links() }}</div>

</div>

{{-- MODAL EDIT & HAPUS --}}
@foreach($kamars as $kamar)
<div id="modal-{{ $kamar->id }}"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold mb-4">Edit Kamar {{ $kamar->nomor_kamar }}</h2>
        <form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="text-sm text-gray-600">Nomor Kamar</label>
                <input type="text" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}"
                       class="w-full border rounded-lg p-2 mt-1" required>
            </div>
            <div class="mb-3">
                <label class="text-sm text-gray-600">Tipe Kamar</label>
                <select name="tipe_kamar" class="w-full border rounded-lg p-2 mt-1" required>
                    <option value="Standar"  {{ $kamar->tipe_kamar == 'Standar'  ? 'selected' : '' }}>Standar</option>
                    <option value="Deluxe"   {{ $kamar->tipe_kamar == 'Deluxe'   ? 'selected' : '' }}>Deluxe</option>
                    <option value="Superior" {{ $kamar->tipe_kamar == 'Superior' ? 'selected' : '' }}>Superior</option>
                    <option value="Premium"  {{ $kamar->tipe_kamar == 'Premium'  ? 'selected' : '' }}>Premium</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="text-sm text-gray-600">Harga</label>
                <input type="number" name="harga" value="{{ $kamar->harga }}"
                       class="w-full border rounded-lg p-2 mt-1" required>
            </div>
            <div class="mb-4">
                <label class="text-sm text-gray-600">Status</label>
                <select name="status" class="w-full border rounded-lg p-2 mt-1">
                    <option value="Kosong"    {{ $kamar->status == 'Kosong'    ? 'selected' : '' }}>Kosong</option>
                    <option value="Terisi"    {{ $kamar->status == 'Terisi'    ? 'selected' : '' }}>Terisi</option>
                    <option value="Non-aktif" {{ $kamar->status == 'Non-aktif' ? 'selected' : '' }}>Non-aktif / Renovasi</option>
                </select>
                @if($kamar->status == 'Non-aktif')
                    <p class="text-xs text-red-400 mt-1">Kamar ini tidak akan muncul di pilihan user</p>
                @endif
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal({{ $kamar->id }})"
                        class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-modal-{{ $kamar->id }}"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-sm rounded-xl shadow-lg p-6 text-center">
        <h2 class="text-lg font-bold mb-2">Hapus Kamar?</h2>
        <p class="text-sm text-gray-500 mb-6">Kamar <strong>{{ $kamar->nomor_kamar }}</strong> akan dihapus permanen.</p>
        <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeDeleteModal({{ $kamar->id }})"
                        class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function openModal(id) {
    document.getElementById('modal-' + id).classList.remove('hidden');
    document.getElementById('modal-' + id).classList.add('flex');
}
function closeModal(id) {
    document.getElementById('modal-' + id).classList.add('hidden');
    document.getElementById('modal-' + id).classList.remove('flex');
}
function openDeleteModal(id) {
    document.getElementById('delete-modal-' + id).classList.remove('hidden');
    document.getElementById('delete-modal-' + id).classList.add('flex');
}
function closeDeleteModal(id) {
    document.getElementById('delete-modal-' + id).classList.add('hidden');
    document.getElementById('delete-modal-' + id).classList.remove('flex');
}
</script>

@endsection