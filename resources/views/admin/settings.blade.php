<!-- View: admin/settings.blade.php -->
@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Informasi Umum -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Umum</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" name="nama_website" class="form-control" value="{{ old('nama_website', $settings->nama_website) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $settings->email) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $settings->no_telepon) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $settings->alamat) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tentang Bimbel</label>
                        <textarea name="tentang" class="form-control" rows="4">{{ old('tentang', $settings->tentang) }}</textarea>
                        <small class="text-muted">Deskripsi tentang bimbel yang akan ditampilkan di halaman depan</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logo Website</label>
                        @if($settings->logo)
                            <div class="mb-2">
                                <img src="{{ $settings->logo_url }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah logo.</small>
                    </div>
                </div>
            </div>

            <!-- Informasi Bank untuk Pembayaran -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-bank"></i> Informasi Rekening Bank</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Informasi rekening ini akan ditampilkan kepada orang tua saat melakukan pembayaran paket belajar.
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $settings->nama_bank) }}" placeholder="Contoh: BCA">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control" value="{{ old('nomor_rekening', $settings->nomor_rekening) }}" placeholder="1234567890">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="atas_nama" class="form-control" value="{{ old('atas_nama', $settings->atas_nama) }}" placeholder="Nama Pemilik Rekening">
                        </div>
                    </div>

                    @if($settings->nama_bank && $settings->nomor_rekening)
                    <div class="alert alert-success mt-3">
                        <strong>Preview Informasi Bank:</strong><br>
                        {{ $settings->info_bank_formatted }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Button Submit -->
            <div class="card">
                <div class="card-body text-end">
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Preview logo before upload
    $('input[name="logo"]').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                Swal.fire({
                    title: 'Preview Logo',
                    imageUrl: e.target.result,
                    imageAlt: 'Logo Preview',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Ganti'
                }).then((result) => {
                    if (!result.isConfirmed) {
                        $('input[name="logo"]').val('');
                    }
                });
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush