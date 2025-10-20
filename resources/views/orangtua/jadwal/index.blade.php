@extends('layouts.ortusiswa')

@section('title', 'Jadwal Belajar')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Jadwal Belajar</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('orangtua.jadwal.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label for="siswa_id" class="form-label">Filter Berdasarkan Anak:</label>
                        <select name="siswa_id" id="siswa_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Anak --</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id_siswa }}" {{ request('siswa_id') == $s->id_siswa ? 'selected' : '' }}>
                                    {{ $s->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($jadwals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
                                <td>{{ $jadwal->siswa->nama_siswa ?? '-' }}</td>
                                <td>
                                    <strong>{{ $jadwal->judul }}</strong>
                                    @if($jadwal->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($jadwal->deskripsi, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->jenis === 'materi')
                                        <span class="badge bg-info">Materi</span>
                                    @else
                                        <span class="badge bg-warning">Tugas</span>
                                    @endif
                                </td>
                                <td>{{ $jadwal->getDurasiFormatted() }}</td>
                                <td>
                                    @if($jadwal->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($jadwal->status === 'terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                    @if($jadwal->jenis === 'tugas' && $jadwal->deadline)
                                    <br><small class="text-muted">Deadline: {{ $jadwal->getDeadlineFormatted() }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($jadwal->nilai)
                                        <span class="badge bg-primary">{{ $jadwal->nilai }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Jadwal</h5>
                    <p class="text-muted">
                        @if(request('siswa_id'))
                            Belum ada jadwal untuk anak yang dipilih
                        @else
                            Belum ada jadwal untuk semua anak
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($jadwals->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6><i class="fas fa-info-circle"></i> Keterangan Status</h6>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <span class="badge bg-info">Materi</span> - Materi pembelajaran
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-warning">Tugas</span> - Tugas yang harus dikerjakan
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-success">Selesai</span> - Sudah selesai
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-danger">Terlambat</span> - Dikumpulkan terlambat
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection