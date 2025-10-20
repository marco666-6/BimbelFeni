@extends('layouts.ortusiswa')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.transaksi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.transaksi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="id_siswa" class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                        <select name="id_siswa" id="id_siswa" class="form-select @error('id_siswa') is-invalid @enderror" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id_siswa }}" {{ old('id_siswa') == $siswa->id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_siswa }} - {{ $siswa->jenjang }} Kelas {{ $siswa->kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Pembayaran <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" min="1000" required>
                        </div>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control @error('tanggal_bayar') is-invalid @enderror" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                        @error('tanggal_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bukti_bayar" class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control @error('bukti_bayar') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        @error('bukti_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Contoh: Pembayaran bulan Januari 2025">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Informasi:</strong> Bukti pembayaran akan diverifikasi oleh admin. Anda akan menerima notifikasi setelah verifikasi selesai.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-upload"></i> Upload Bukti Pembayaran
                        </button>
                        <a href="{{ route('orangtua.transaksi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-university"></i> Informasi Rekening</h6>
                <p class="mb-2"><strong>Bank:</strong> BCA</p>
                <p class="mb-2"><strong>No. Rekening:</strong> 1234567890</p>
                <p class="mb-3"><strong>Atas Nama:</strong> Bimbel Oriana Enilin</p>
                <hr class="bg-white">
                <small>Pastikan transfer ke rekening yang benar</small>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-lightbulb"></i> Tips Upload</h6>
                <ul class="mb-0">
                    <li class="mb-2">Pastikan foto bukti transfer jelas</li>
                    <li class="mb-2">Nama pengirim dan jumlah terlihat</li>
                    <li class="mb-2">Format file: JPG, PNG</li>
                    <li class="mb-2">Ukuran maksimal 2MB</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-question-circle"></i> Butuh Bantuan?</h6>
                <p class="mb-3">Hubungi admin jika mengalami kesulitan</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success w-100">
                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection