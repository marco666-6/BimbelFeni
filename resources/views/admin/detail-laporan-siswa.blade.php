<!-- View: admin/detail-laporan-siswa.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Laporan Siswa')
@section('page-title', 'Detail Laporan - ' . $siswa->nama_lengkap)

@section('content')
<!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('admin.laporan-siswa') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Informasi Siswa -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $siswa->user->foto_profil_url }}" alt="Foto" class="rounded-circle mb-3" width="120" height="120">
                <h5>{{ $siswa->nama_lengkap }}</h5>
                <p class="text-muted mb-1">{{ $siswa->jenjang }} - {{ $siswa->kelas }}</p>
                <p class="text-muted mb-1">{{ $siswa->user->email }}</p>
                <span class="badge bg-{{ $siswa->user->isAktif() ? 'success' : 'danger' }}">
                    {{ $siswa->user->status }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Informasi Lengkap</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Nama Lengkap:</strong><br>
                        {{ $siswa->nama_lengkap }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Tanggal Lahir:</strong><br>
                        {{ $siswa->tanggal_lahir->format('d/m/Y') }} ({{ $siswa->usia }} tahun)
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Orang Tua:</strong><br>
                        {{ $siswa->orangTua->nama_lengkap }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kontak Orang Tua:</strong><br>
                        {{ $siswa->orangTua->no_telepon }}
                    </div>
                    <div class="col-md-12 mb-2">
                        <strong>Alamat:</strong><br>
                        {{ $siswa->orangTua->alamat }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Persentase Kehadiran</h6>
                <h3>{{ $siswa->persentase_kehadiran }}%</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6>Rata-rata Nilai</h6>
                <h3>{{ number_format($siswa->rata_nilai, 1) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Total Tugas Terkumpul</h6>
                <h3>{{ $siswa->total_tugas_terkumpul }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Tugas Tertunda</h6>
                <h3>{{ $siswa->tugas_tertunda }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-tabs mb-3" id="laporanTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button">
            <i class="bi bi-calendar-week"></i> Jadwal
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button">
            <i class="bi bi-clipboard-check"></i> Kehadiran
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button">
            <i class="bi bi-award"></i> Nilai Tugas
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button">
            <i class="bi bi-credit-card"></i> Transaksi
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button">
            <i class="bi bi-chat-left-text"></i> Feedback
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button">
            <i class="bi bi-activity"></i> Log Activity
        </button>
    </li>
</ul>

<!-- Tabs Content -->
<div class="tab-content" id="laporanTabsContent">
    <!-- Jadwal -->
    <div class="tab-pane fade show active" id="jadwal" role="tabpanel">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Jadwal Pembelajaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Jam</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->jadwal as $j)
                            <tr>
                                <td>{{ $j->hari }}</td>
                                <td>{{ $j->mata_pelajaran }}</td>
                                <td>{{ $j->nama_guru }}</td>
                                <td>{{ $j->jam_formatted }}</td>
                                <td>{{ $j->ruangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada jadwal</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kehadiran -->
    <div class="tab-pane fade" id="kehadiran" role="tabpanel">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">Riwayat Kehadiran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->kehadiran as $k)
                            <tr>
                                <td>{{ $k->tanggal_pertemuan->format('d/m/Y') }}</td>
                                <td>{{ $k->jadwal->mata_pelajaran }}</td>
                                <td>
                                    <span class="badge bg-{{ $k->status_badge_color }}">
                                        {{ $k->status_label }}
                                    </span>
                                </td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data kehadiran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai -->
    <div class="tab-pane fade" id="nilai" role="tabpanel">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">Nilai Tugas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul Tugas</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Grade</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->pengumpulanTugas->where('nilai', '!=', null) as $pt)
                            <tr>
                                <td>{{ $pt->tanggal_pengumpulan->format('d/m/Y') }}</td>
                                <td>{{ $pt->materiTugas->judul }}</td>
                                <td>{{ $pt->materiTugas->mata_pelajaran }}</td>
                                <td>
                                    <span class="badge bg-{{ $pt->status_badge_color }} fs-6">
                                        {{ $pt->nilai }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $pt->grade_label }}</span>
                                </td>
                                <td>{{ Str::limit($pt->feedback_guru, 50) ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada nilai</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi -->
    <div class="tab-pane fade" id="transaksi" role="tabpanel">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">Riwayat Transaksi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Paket</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->transaksi as $t)
                            <tr>
                                <td>{{ $t->kode_transaksi }}</td>
                                <td>{{ $t->tanggal_transaksi->format('d/m/Y') }}</td>
                                <td>{{ $t->paketBelajar->nama_paket }}</td>
                                <td>{{ $t->total_pembayaran_formatted }}</td>
                                <td>
                                    <span class="badge bg-{{ $t->status_badge_color }}">
                                        {{ $t->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback -->
    <div class="tab-pane fade" id="feedback" role="tabpanel">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0">Feedback dari Orang Tua</h6>
            </div>
            <div class="card-body">
                @forelse($siswa->feedback as $f)
                <div class="card mb-3 border-{{ $f->isBaru() ? 'warning' : 'success' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>{{ $f->tanggal_feedback_formatted }}</strong>
                            <span class="badge bg-{{ $f->status_badge_color }}">{{ $f->status_label }}</span>
                        </div>
                        <p class="mb-2">{{ $f->isi_feedback }}</p>
                        @if($f->balasan_admin)
                        <div class="alert alert-success mb-0">
                            <strong>Balasan Admin:</strong><br>
                            {{ $f->balasan_admin }}
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-muted">Belum ada feedback</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Log Activity -->
    <div class="tab-pane fade" id="activity" role="tabpanel">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">Log Aktivitas Siswa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa->logActivity->take(50) as $log)
                            <tr>
                                <td><small>{{ $log->waktu_formatted }}</small></td>
                                <td>
                                    <span class="badge bg-{{ $log->badge_color }}">
                                        <i class="bi bi-{{ $log->icon }}"></i> {{ $log->jenis_aktivitas }}
                                    </span>
                                </td>
                                <td><small>{{ $log->deskripsi }}</small></td>
                                <td><small>{{ $log->ip_address }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada log aktivitas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection