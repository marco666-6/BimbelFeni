@extends('layouts.ortusiswa')

@section('title', 'Detail Pendaftaran')

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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clipboard-check"></i> Detail Pendaftaran</h5>
                @if($pendaftaran->status === 'menunggu')
                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                @elseif($pendaftaran->status === 'diterima')
                    <span class="badge bg-success">Diterima</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Pendaftaran:</strong>
                        <p>{{ $pendaftaran->getTanggalDaftarFormatted() }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            @if($pendaftaran->status === 'menunggu')
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @elseif($pendaftaran->status === 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr>

                <h6 class="text-primary mb-3"><i class="fas fa-box"></i> Informasi Paket</h6>
                @if($pendaftaran->paketBelajar)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Nama Paket:</strong>
                        <p>{{ $pendaftaran->paketBelajar->nama_paket }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Harga:</strong>
                        <p>{{ $pendaftaran->paketBelajar->getFormattedHarga() }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Durasi:</strong>
                        <p>{{ $pendaftaran->paketBelajar->durasi }} bulan</p>
                    </div>
                    @if($pendaftaran->id_jawaban_paket)
                    <div class="col-12">
                        <strong>Mata Pelajaran yang Diminati:</strong>
                        <p>{{ $pendaftaran->id_jawaban_paket }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <hr>

                <h6 class="text-primary mb-3"><i class="fas fa-user"></i> Informasi Siswa</h6>
                @if($pendaftaran->siswa)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Nama Siswa:</strong>
                        <p>{{ $pendaftaran->siswa->nama_siswa }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong>
                        <p>{{ $pendaftaran->siswa->user->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Lahir:</strong>
                        <p>{{ $pendaftaran->siswa->getTanggalLahirFormatted() }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Usia:</strong>
                        <p>{{ $pendaftaran->siswa->getUmur() }} tahun</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jenjang:</strong>
                        <p>{{ $pendaftaran->siswa->jenjang }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Kelas:</strong>
                        <p>{{ $pendaftaran->siswa->kelas }}</p>
                    </div>
                    @if($pendaftaran->siswa->user->telepon)
                    <div class="col-md-6">
                        <strong>Telepon:</strong>
                        <p>{{ $pendaftaran->siswa->user->telepon }}</p>
                    </div>
                    @endif
                    @if($pendaftaran->siswa->user->alamat)
                    <div class="col-12">
                        <strong>Alamat:</strong>
                        <p>{{ $pendaftaran->siswa->user->alamat }}</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($pendaftaran->catatan)
                <hr>
                <div class="alert alert-info">
                    <strong><i class="fas fa-sticky-note"></i> Catatan dari Admin:</strong>
                    <p class="mb-0 mt-2">{{ $pendaftaran->catatan }}</p>
                </div>
                @endif

                @if($pendaftaran->status === 'diterima' && $pendaftaran->tanggal_selesai)
                <hr>
                <div class="alert alert-success">
                    <strong><i class="fas fa-calendar-check"></i> Masa Aktif Program:</strong>
                    <p class="mb-0 mt-2">
                        Berlaku hingga: <strong>{{ $pendaftaran->getTanggalSelesaiFormatted() }}</strong>
                        @if($pendaftaran->getSisaDurasi() > 0)
                            <br>Sisa waktu: <strong>{{ $pendaftaran->getSisaDurasi() }} hari</strong>
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($pendaftaran->status === 'menunggu')
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-clock"></i> Status Menunggu</h6>
                <p>Pendaftaran Anda sedang dalam proses verifikasi oleh admin. Anda akan segera dihubungi melalui WhatsApp atau email.</p>
                <small>Estimasi: 1-2 hari kerja</small>
            </div>
        </div>
        @elseif($pendaftaran->status === 'diterima')
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-check-circle"></i> Pendaftaran Diterima</h6>
                <p>Selamat! Pendaftaran Anda telah disetujui. Siswa sudah dapat mulai belajar.</p>
                <hr class="bg-white">
                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.siswa.show', $pendaftaran->id_siswa) }}" class="btn btn-light">
                        <i class="fas fa-user"></i> Lihat Profil Siswa
                    </a>
                    <a href="{{ route('orangtua.transaksi.create') }}" class="btn btn-light">
                        <i class="fas fa-money-bill"></i> Upload Pembayaran
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-times-circle"></i> Pendaftaran Ditolak</h6>
                <p>Maaf, pendaftaran Anda tidak dapat diproses.</p>
                @if($pendaftaran->catatan)
                <p><strong>Alasan:</strong> {{ $pendaftaran->catatan }}</p>
                @endif
            </div>
        </div>
        @endif

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="fas fa-question-circle"></i> Butuh Bantuan?</h6>
                <p class="mb-3">Hubungi admin untuk informasi lebih lanjut tentang pendaftaran Anda.</p>
                <a href="{{ route('orangtua.whatsapp') }}" class="btn btn-success w-100">
                    <i class="fab fa-whatsapp"></i> Hubungi Admin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection