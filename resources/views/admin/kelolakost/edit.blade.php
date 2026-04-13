@extends('admin.layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-10 rounded-3xl shadow-md">

    <h1 class="text-2xl font-bold mb-6 text-center">Edit Kost</h1>

    @foreach($kost->images as $img)
    <form id="form-hapus-foto-{{ $img->id }}" action="{{ route('admin.kost.image.delete', $img->id) }}" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>
    @endforeach

    @foreach($kost->videos as $vid)
    <form id="form-hapus-video-{{ $vid->id }}" action="{{ route('admin.kost.video.delete', $vid->id) }}" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>
    @endforeach

    <form action="{{ route('admin.kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <input type="text" name="nama" value="{{ old('nama', $kost->nama) }}" placeholder="Nama Kost" class="w-full border rounded-xl px-5 py-3" required>

        <input type="number" name="harga" value="{{ old('harga', $kost->harga) }}" placeholder="Harga per Bulan" class="w-full border rounded-xl px-5 py-3" required>

        {{-- ✅ TAMBAH: Input jumlah kamar --}}
        <input type="number" name="jumlah_kamar" value="{{ old('jumlah_kamar', $kost->jumlah_kamar) }}" placeholder="Jumlah Kamar" min="1"
               class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500 outline-none" required>

        <input type="text" name="lokasi" value="{{ old('lokasi', $kost->lokasi) }}" placeholder="Lokasi" class="w-full border rounded-xl px-5 py-3" required>

        <textarea name="alamat" rows="3" placeholder="Alamat Lengkap" class="w-full border rounded-xl px-5 py-3" required>{{ old('alamat', $kost->alamat) }}</textarea>

        <select name="jenis" class="w-full border rounded-xl px-5 py-3">
            <option value="Putra"  {{ $kost->jenis=='Putra'  ? 'selected' : '' }}>Putra</option>
            <option value="Putri"  {{ $kost->jenis=='Putri'  ? 'selected' : '' }}>Putri</option>
            <option value="Campur" {{ $kost->jenis=='Campur' ? 'selected' : '' }}>Campur</option>
        </select>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            @php $facilities = ['AC','WiFi','Lemari','CCTV','Dapur','Parkir','Kamar Mandi Dalam','Mesin Cuci']; @endphp
            @foreach($facilities as $f)
            <label class="flex items-center gap-2">
                <input type="checkbox" name="fasilitas[]" value="{{ $f }}" {{ in_array($f, old('fasilitas', $kost->fasilitas ?? [])) ? 'checked' : '' }}>
                <span>{{ $f }}</span>
            </label>
            @endforeach
        </div>

        <div>
            <label class="block font-medium mb-2">Foto Saat Ini</label>
            <div class="grid grid-cols-3 gap-2">
                @foreach($kost->images as $img)
                <div class="relative">
                    <img src="{{ asset('images/kost/'.$img->image) }}" class="w-full h-32 object-cover rounded-xl">
                    <button type="button"
                            onclick="if(confirm('Hapus foto?')) document.getElementById('form-hapus-foto-{{ $img->id }}').submit()"
                            class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 text-xs rounded">Hapus</button>
                </div>
                @endforeach
            </div>
        </div>

       <div>
    <label class="block font-medium mb-2">Tambah Foto Baru</label>
    <div id="drop-area"
        class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-500 transition">
        <p class="text-gray-500"> Drag & Drop foto di sini atau <span class="text-blue-500 underline">klik untuk memilih</span></p>
        <!-- <p class="text-xs text-gray-400 mt-1">Bisa pilih banyak foto sekaligus</p> -->
        <input type="file" name="gambar[]" id="gambar" multiple class="hidden">
    </div>
    <div id="preview-gambar" class="grid grid-cols-3 gap-2 mt-4"></div>
</div>

        @if($kost->videos->count() > 0)
        <div class="border-t pt-6">
            <label class="block font-semibold text-gray-700 mb-3">🎥 Video Saat Ini</label>
            <div class="space-y-4">
                @foreach($kost->videos as $vid)
                <div class="border border-gray-200 rounded-xl p-3">
                    <video controls class="w-full rounded-xl max-h-48 mb-2">
                        <source src="{{ asset('videos/kost/'.$vid->video) }}" type="video/mp4">
                    </video>
                    @if($vid->judul)<p class="text-sm text-gray-600 mb-2">📌 {{ $vid->judul }}</p>@endif
                    <button type="button"
                            onclick="if(confirm('Hapus video ini?')) document.getElementById('form-hapus-video-{{ $vid->id }}').submit()"
                            class="bg-red-500 text-white px-3 py-1 text-xs rounded-lg hover:bg-red-600">🗑 Hapus Video</button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="border-t pt-6">
            <label class="block font-semibold text-gray-700 mb-2">Tambah Video Baru</label>
            <p class="text-sm text-gray-400 mb-3">Format: MP4, AVI, MOV. Maksimal 50MB per video.</p>
            <div id="video-wrapper" class="space-y-3">
                <div class="video-row flex gap-3 items-center">
                    <input type="file" name="video[]" accept="video/mp4,video/avi,video/quicktime"
                           class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm"
                           onchange="previewVideoSingle(this)">
                    <input type="text" name="judul_video[]" placeholder="Judul video (opsional)"
                           class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm">
                    <button type="button" onclick="hapusRowVideo(this)"
                            class="text-red-400 hover:text-red-600 font-bold text-xl leading-none">✕</button>
                </div>
            </div>
            <button type="button" onclick="tambahRowVideo()"
                    class="mt-3 text-blue-600 hover:underline text-sm font-medium">+ Tambah Video Lain</button>
            <div id="preview-video" class="grid grid-cols-1 gap-4 mt-4"></div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition mt-4">Update Kost</button>
    </form>
</div>

<script>
const dropArea = document.getElementById("drop-area");
const inputGambar = document.getElementById("gambar");
const previewGambar = document.getElementById("preview-gambar");

dropArea.addEventListener("click", () => inputGambar.click());
inputGambar.addEventListener("change", function(e) { showPreviewGambar(e.target.files); });
dropArea.addEventListener("dragover", (e) => { e.preventDefault(); dropArea.classList.add("border-blue-500","bg-blue-50"); });
dropArea.addEventListener("dragleave", () => { dropArea.classList.remove("border-blue-500","bg-blue-50"); });
dropArea.addEventListener("drop", (e) => {
    e.preventDefault();
    dropArea.classList.remove("border-blue-500","bg-blue-50");
    inputGambar.files = e.dataTransfer.files;
    showPreviewGambar(e.dataTransfer.files);
});

function showPreviewGambar(files) {
    previewGambar.innerHTML = "";
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            let img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("w-full","h-32","object-cover","rounded-xl","shadow");
            previewGambar.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

function tambahRowVideo() {
    const wrapper = document.getElementById("video-wrapper");
    const row = document.createElement("div");
    row.className = "video-row flex gap-3 items-center";
    row.innerHTML = `
        <input type="file" name="video[]" accept="video/mp4,video/avi,video/quicktime"
               class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm"
               onchange="previewVideoSingle(this)">
        <input type="text" name="judul_video[]" placeholder="Judul video (opsional)"
               class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm">
        <button type="button" onclick="hapusRowVideo(this)"
                class="text-red-400 hover:text-red-600 font-bold text-xl leading-none">✕</button>
    `;
    wrapper.appendChild(row);
}

function hapusRowVideo(btn) {
    const row = btn.closest(".video-row");
    if (document.querySelectorAll(".video-row").length > 1) row.remove();
}

function previewVideoSingle(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const url = URL.createObjectURL(file);
    const wrapper = document.createElement("div");
    wrapper.className = "rounded-xl overflow-hidden shadow border border-gray-200";
    wrapper.innerHTML = `
        <video controls class="w-full rounded-xl max-h-48"><source src="${url}" type="${file.type}"></video>
        <p class="text-xs text-gray-500 px-2 py-1 truncate">${file.name}</p>
    `;
    document.getElementById("preview-video").appendChild(wrapper);
}
</script>
@endsection