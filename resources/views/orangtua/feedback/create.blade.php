@extends('layouts.ortusiswa')

@section('title', 'Kirim Feedback')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('orangtua.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-comment-dots"></i> Kirim Feedback/Saran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orangtua.feedback.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="subjek" class="form-label">Subjek <span class="text-danger">*</span></label>
                        <input type="text" name="subjek" id="subjek" class="form-control @error('subjek') is-invalid @enderror" value="{{ old('subjek') }}" required placeholder="Contoh: Saran untuk peningkatan layanan">
                        @error('subjek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan/Saran <span class="text-danger">*</span></label>
                        <textarea name="pesan" id="pesan" rows="8" class="form-control @error('pesan') is-invalid @enderror" required placeholder="Tuliskan feedback, saran, atau pertanyaan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Feedback Anda akan diterima oleh admin dan akan ditindaklanjuti secepatnya.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Kirim Feedback
                        </button>
                        <a href="{{ route('orangtua.dashboard') }}" class="btn btn-secondary">
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
                <h6 class="mb-3"><i class="fas fa-lightbulb"></i> Tips Memberikan Feedback</h6>
                <ul class="mb-0">
                    <li class="mb-2">Berikan judul yang jelas dan spesifik</li>
                    <li class="mb-2">Jelaskan masalah atau saran dengan detail</li>
                    <li class="mb-2">Berikan contoh jika memungkinkan</li>
                    <li class="mb-2">Gunakan bahasa yang sopan dan konstruktif</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-comments"></i> Topik Feedback</h6>
                <p class="mb-2">Anda dapat memberikan feedback tentang:</p>
                <ul class="mb-0">
                    <li>Kualitas pengajaran</li>
                    <li>Materi pembelajaran</li>
                    <li>Jadwal dan durasi</li>
                    <li>Layanan administrasi</li>
                    <li>Sistem pembayaran</li>
                    <li>Website/aplikasi</li>
                    <li>Lainnya</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3 bg-success text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-phone"></i> Kontak Langsung</h6>
                <p class="mb-3">Untuk hal yang mendesak, Anda dapat menghubungi kami langsung:</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-light w-100">
                    <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection