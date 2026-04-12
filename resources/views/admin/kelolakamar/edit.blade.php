@extends('admin.layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Data Kamar: {{ $kamar->nomor_kamar }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Kosan & Tipe Kamar</label>
                            <input type="text" class="form-control" value="{{ $kamar->kost->nama ?? 'Data Kost' }} - {{ $kamar->tipe_kamar }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="{{ $kamar->harga }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Kamar</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif" {{ $kamar->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ $kamar->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="Penuh" {{ $kamar->status == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection