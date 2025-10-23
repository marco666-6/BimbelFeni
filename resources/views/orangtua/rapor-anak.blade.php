<!-- View: orangtua/rapor-anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Rapor Anak')
@section('page-title', 'Rapor - ' . $siswa->nama_lengkap)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Info Siswa -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="{{ $siswa->user->foto_profil_url }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-circle" width="60" height="60">
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $siswa->nama_lengkap }}</h5>
                        <p class="text-muted mb-0">{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('orangtua.anak') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Periode Rapor -->
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="mb-3">Periode Rapor</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-primary">
                            <i class="bi bi-calendar-event me-2"></i>
                            <strong>Bulan:</strong> {{ \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->isoFormat('MMMM') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Kehadiran -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clipboard-check text-success"></i> Kehadiran</h5>
            </div>
            <div class="card-body">
                @if($kehadiranBulanIni->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada data kehadiran untuk bulan ini.
                    </div>
                @else
                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-primary">{{ $kehadiranBulanIni->count() }}</h3>
                                    <small class="text-muted">Total Pertemuan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-success">{{ $kehadiranBulanIni->where('status', 'hadir')->count() }}</h3>
                                    <small class="text-muted">Hadir</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-warning">{{ $kehadiranBulanIni->whereIn('status', ['sakit', 'izin'])->count() }}</h3>
                                    <small class="text-muted">Sakit/Izin</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-danger">{{ $kehadiranBulanIni->where('status', 'alpha')->count() }}</h3>
                                    <small class="text-muted">Alpha</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kehadiranBulanIni as $k)
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Nilai Tugas -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-award text-warning"></i> Nilai Tugas</h5>
            </div>
            <div class="card-body">
                @if($nilaiTugasBulanIni->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada nilai tugas untuk bulan ini.
                    </div>
                @else
                    @php
                        $rataNilai = $nilaiTugasBulanIni->avg('nilai');
                        $nilaiTertinggi = $nilaiTugasBulanIni->max('nilai');
                        $nilaiTerendah = $nilaiTugasBulanIni->min('nilai');
                    @endphp

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-primary">{{ number_format($rataNilai, 2) }}</h3>
                                    <small class="text-muted">Rata-rata Nilai</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-success">{{ $nilaiTertinggi }}</h3>
                                    <small class="text-muted">Nilai Tertinggi</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-danger">{{ $nilaiTerendah }}</h3>
                                    <small class="text-muted">Nilai Terendah</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Judul Tugas</th>
                                    <th width="10%">Nilai</th>
                                    <th>Grade</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nilaiTugasBulanIni as $n)
                                <tr>
                                    <td>{{ $n->tanggal_pengumpulan->format('d/m/Y') }}</td>
                                    <td>{{ $n->materiTugas->mata_pelajaran }}</td>
                                    <td>{{ $n->materiTugas->judul }}</td>
                                    <td>
                                        <strong class="text-primary">{{ $n->nilai }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $n->status_badge_color }}">
                                            {{ $n->grade_label }}
                                        </span>
                                    </td>
                                    <td>{{ $n->feedback_guru ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection