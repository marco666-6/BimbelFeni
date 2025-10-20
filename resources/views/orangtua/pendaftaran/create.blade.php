@extends('layouts.ortusiswa')

@section('title', 'Pendaftaran Siswa Baru')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.pendaftaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-plus"></i> Form Pendaftaran Siswa Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.pendaftaran.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="fas fa-box"></i> Pilih Paket Belajar</h6>
                        <hr>
                    </div>

                    <div class="mb-3">
                        <label for="id_paket" class="form-label">Paket Belajar <span class="text-danger">*</span></label>
                        <select name="id_paket" id="id_paket" class="form-select @error('id_paket') is-invalid @enderror" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach($pakets as $paket)
                                <option value="{{ $paket->id_paket }}" {{ old('id_paket', request('paket')) == $paket->id_paket ? 'selected' : '' }}>
                                    {{ $paket->nama_paket }} - {{ $paket->getFormattedHarga() }} ({{ $paket->durasi }} bulan)
                                </option>
                            @endforeach
                        </select>
                        @error('id_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_jawaban_paket" class="form-label">Mata Pelajaran yang Diminati (Opsional)</label>
                        <textarea name="id_jawaban_paket" id="id_jawaban_paket" rows="3" class="form-control @error('id_jawaban_paket') is-invalid @enderror" placeholder="Contoh: Matematika, Bahasa Indonesia, IPA">{{ old('id_jawaban_paket') }}</textarea>
                        <small class="form-text text-muted">Tuliskan mata pelajaran yang ingin dipelajari</small>
                        @error('id_jawaban_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 mt-4">
                        <h6 class="text-primary"><i class="fas fa-user"></i> Data Siswa</h6>
                        <hr>
                    </div>

                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required>
                        @error('nama_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email_siswa" class="form-label">Email Siswa <span class="text-danger">*</span></label>
                            <input type="email" name="email_siswa" id="email_siswa" class="form-control @error('email_siswa') is-invalid @enderror" value="{{ old('email_siswa') }}" required>
                            <small class="form-text text-muted">Email untuk login siswa</small>
                            @error('email_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_siswa" class="form-label">Password Siswa <span class="text-danger">*</span></label>
                            <input type="password" name="password_siswa" id="password_siswa" class="form-control @error('password_siswa') is-invalid @enderror" required>
                            <small class="form-text text-muted">Minimal 6 karakter</small>
                            @error('password_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenjang" class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select name="jenjang" id="jenjang" class="form-select @error('jenjang') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            </select>
                            @error('jenjang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" placeholder="Contoh: 5" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="telepon_siswa" class="form-label">No. Telepon Siswa</label>
                        <input type="text" name="telepon_siswa" id="telepon_siswa" class="form-control @error('telepon_siswa') is-invalid @enderror" value="{{ old('telepon_siswa') }}" placeholder="08xx-xxxx-xxxx">
                        @error('telepon_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat_siswa" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_siswa" id="alamat_siswa" rows="3" class="form-control @error('alamat_siswa') is-invalid @enderror">{{ old('alamat_siswa') }}</textarea>
                        @error('alamat_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Setelah mendaftar, silakan tunggu konfirmasi dari admin. Anda akan dihubungi melalui WhatsApp atau email.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
                        </button>
                        <a href="{{ route('orangtua.pendaftaran.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-3"><i class="fas fa-lightbulb"></i> Tips Pendaftaran</h5>
                <ul class="mb-0">
                    <li class="mb-2">Pastikan semua data yang diisi benar dan lengkap</li>
                    <li class="mb-2">Email dan password akan digunakan siswa untuk login</li>
                    <li class="mb-2">Simpan password dengan baik</li>
                    <li class="mb-2">Pilih paket yang sesuai dengan kebutuhan anak</li>
                    <li class="mb-2">Proses verifikasi biasanya 1-2 hari kerja</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-question-circle"></i> Butuh Bantuan?</h6>
                <p class="mb-3">Hubungi kami jika Anda mengalami kesulitan dalam pendaftaran.</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success w-100">
                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection