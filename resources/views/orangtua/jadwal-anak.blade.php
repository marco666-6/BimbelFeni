<!-- View: orangtua/jadwal-anak.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Jadwal Anak')
@section('page-title', 'Jadwal Pembelajaran - ' . $siswa->nama_lengkap)

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

        <!-- Jadwal Table -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-calendar-week text-primary"></i> Jadwal Mingguan</h5>
            </div>
            <div class="card-body">
                @if($jadwal->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada jadwal pembelajaran untuk siswa ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Hari</th>
                                    <th width="20%">Mata Pelajaran</th>
                                    <th width="20%">Guru</th>
                                    <th width="20%">Waktu</th>
                                    <th width="15%">Ruangan</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hariUrutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    $jadwalSorted = $jadwal->sortBy(function($item) use ($hariUrutan) {
                                        return array_search($item->hari, $hariUrutan);
                                    })->sortBy('jam_mulai');
                                @endphp
                                
                                @foreach($jadwalSorted as $j)
                                <tr>
                                    <td>
                                        <strong>{{ $j->hari }}</strong>
                                        @if($j->isToday())
                                            <span class="badge bg-success ms-1">Hari Ini</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-book text-primary me-1"></i>
                                        {{ $j->mata_pelajaran }}
                                    </td>
                                    <td>
                                        <i class="bi bi-person text-secondary me-1"></i>
                                        {{ $j->nama_guru }}
                                    </td>
                                    <td>
                                        <i class="bi bi-clock text-info me-1"></i>
                                        {{ $j->jam_formatted }}
                                        <small class="text-muted d-block">{{ $j->durasi_menit }} menit</small>
                                    </td>
                                    <td>
                                        @if($j->ruangan)
                                            <i class="bi bi-door-open text-warning me-1"></i>
                                            {{ $j->ruangan }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($j->total_pertemuan > 0)
                                            <span class="badge bg-info" data-bs-toggle="tooltip" title="Persentase Kehadiran">
                                                {{ $j->persentase_kehadiran }}%
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Baru</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Statistik -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-primary">{{ $jadwal->count() }}</h3>
                                    <small class="text-muted">Total Jadwal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-success">{{ $jadwal->unique('mata_pelajaran')->count() }}</h3>
                                    <small class="text-muted">Mata Pelajaran</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0 text-info">{{ $jadwal->sum('durasi_menit') }}</h3>
                                    <small class="text-muted">Total Menit/Minggu</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush
@endsection