@extends('admin.layouts.admin')

@section('content')
<div class="flex justify-between items-end mb-6">
    <div>
        <h1 class="text-2xl font-bold mb-4">Daftar Penghuni</h1>
    </div>

    <button onclick="openModal()" 
        class="bg-[#0047FF] text-white px-6 py-2 rounded-lg font-bold text-sm shadow-md flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah User
    </button>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="border-b bg-gray-50">
            <tr class="text-gray-500 text-sm font-semibold">
                <th class="px-6 py-4">Nama Lengkap</th>
                <th class="px-6 py-4 text-center">No. Kamar</th>
                <th class="px-6 py-4 text-center">Kost</th>
                <th class="px-6 py-4 text-center">Status Sewa</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($penyewas as $penyewa)
            <tr>
                <td class="px-6 py-4 flex items-center gap-4">

                    {{-- FOTO --}}
                    @if($penyewa->foto)
                        <img src="{{ asset('storage/'.$penyewa->foto) }}" 
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-xs">
                            No Img
                        </div>
                    @endif

                    <span class="font-bold text-gray-800">
                        {{ $penyewa->nama_lengkap }}
                    </span>
                </td>

                <td class="px-6 py-4 text-center text-sm text-gray-600">
                    {{ $penyewa->no_kamar }}
                </td>

                <td class="px-6 py-4 text-center text-sm text-gray-600">
                    {{ $penyewa->nama_kost }}
                </td>

                <td class="px-6 py-4 text-center">
                    @if($penyewa->status == 'Aktif')
                        <span class="bg-[#27AE60] text-white px-4 py-1 rounded-full text-xs font-bold">
                            Aktif
                        </span>
                    @else
                        <span class="bg-red-500 text-white px-4 py-1 rounded-full text-xs font-bold">
                            Tidak Aktif
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-center flex justify-center gap-3">

                    {{-- EDIT --}}
                    <button onclick='openEditModal(@json($penyewa))'
                        class="text-blue-500 hover:text-blue-700">
                        <i class="fa fa-edit"></i>
                    </button>

                    {{-- DELETE --}}
                    <form action="{{ route('admin.penyewa.destroy', $penyewa->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div id="modalTambah" 
     class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

    <div class="bg-white w-[450px] rounded-2xl shadow-lg p-6">

        <h3 class="text-lg font-bold mb-5">Tambah Penyewa</h3>

        <form action="{{ route('admin.penyewa.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="nama" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">No Telepon</label>
                <input type="text" name="nomor_telepon" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">No Kamar</label>
                <input type="text" name="no_kamar" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Kost</label>
                <input type="text" name="nama_kost" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Foto</label>
                <input type="file" name="foto" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg px-3 py-2">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm">
                    Batal
                </button>

                <button type="submit"
                    class="bg-[#0047FF] text-white px-4 py-2 rounded-lg text-sm font-bold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div id="modalEdit" 
     class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

    <div class="bg-white w-[450px] rounded-2xl shadow-lg p-6">

        <h3 class="text-lg font-bold mb-5">Edit Penyewa</h3>

        <form id="formEdit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="nama" id="edit_nama" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="edit_email" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">No Telepon</label>
                <input type="text" name="nomor_telepon" id="edit_nomor_telepon" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">No Kamar</label>
                <input type="text" name="no_kamar" id="edit_no_kamar" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Nama Kost</label>
                <input type="text" name="nama_kost" id="edit_nama_kost" required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Foto</label>
                <input type="file" name="foto" class="w-full border rounded-lg px-3 py-2">
                <small class="text-gray-500">Kosongkan jika tidak diganti</small>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Status</label>
                <select name="status" id="edit_status" class="w-full border rounded-lg px-3 py-2">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm">
                    Batal
                </button>

                <button type="submit"
                    class="bg-[#0047FF] text-white px-4 py-2 rounded-lg text-sm font-bold">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modalTambah').classList.remove('hidden');
    document.getElementById('modalTambah').classList.add('flex');
}

function closeModal() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function openEditModal(data) {
    document.getElementById('modalEdit').classList.remove('hidden');
    document.getElementById('modalEdit').classList.add('flex');

    document.getElementById('edit_nama').value = data.nama_lengkap;
    document.getElementById('edit_email').value = data.email;
    document.getElementById('edit_nomor_telepon').value = data.nomor_telepon;
    document.getElementById('edit_no_kamar').value = data.no_kamar;
    document.getElementById('edit_nama_kost').value = data.nama_kost;
    document.getElementById('edit_status').value = data.status;

    document.getElementById('formEdit').action = `/admin/penyewa/${data.id}`;
}

function closeEditModal() {
    document.getElementById('modalEdit').classList.add('hidden');
}
</script>

@endsection