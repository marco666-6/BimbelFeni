<!-- View: siswa/rapor.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Rapor')
@section('page-title', 'Rapor Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Info Siswa -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ $siswa->user->foto_profil_url }}" alt="{{ $siswa->nama_lengkap }}" class="rounded-circle me-3" width="80" height="80">
                    <div>
                        <h4 class="mb-1">{{ $siswa->nama_lengkap }}</h4>
                        <p class="text-muted mb-0">{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bulan -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('siswa.rapor') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-select" onchange="this.form.submit()">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tahun</label>
                            <select name="tahun" class="form-select" onchange="this.form.submit()">
                                @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-check fs-1 text-success"></i>
                        <h3 class="mt-2 mb-1">{{ $persentaseHadir }}%</h3>
                        <p class="text-muted mb-0">Persentase Kehadiran</p>
                        <small class="text-muted">({{ $totalHadir }}/{{ $totalPertemuan }} pertemuan)</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-award fs-1 text-warning"></i>
                        <h3 class="mt-2 mb-1">{{ number_format($rataNilai, 2) }}</h3>
                        <p class="text-muted mb-0">Rata-rata Nilai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kehadiran -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clipboard-check text-success"></i> Kehadiran</h5>
            </div>
            <div class="card-body">
                @if($kehadiran->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada data kehadiran untuk periode ini.
                    </div>
                @else
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
                                @foreach($kehadiran as $k)
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
                @if($nilaiTugas->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada nilai tugas untuk periode ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Judul Tugas</th>
                                    <th>Nilai</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nilaiTugas as $n)
                                <tr>
                                    <td>{{ $n->tanggal_pengumpulan->format('d/m/Y') }}</td>
                                    <td>{{ $n->materiTugas->mata_pelajaran }}</td>
                                    <td>{{ $n->materiTugas->judul }}</td>
                                    <td><strong class="text-primary">{{ $n->nilai }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $n->status_badge_color }}">
                                            {{ $n->grade_label }}
                                        </span>
                                    </td>
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