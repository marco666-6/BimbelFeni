{{-- resources/views/admin/jadwal/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Jadwal & Materi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal & Materi</h1>
    <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jadwal/Materi
    </a>
</div>

{{-- Filter --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.jadwal.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="">Semua</option>
                    <option value="materi" {{ request('jenis') == 'materi' ? 'selected' : '' }}>Materi</option>
                    <option value="tugas" {{ request('jenis') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Siswa</label>
                <input type="text" name="siswa" class="form-control" placeholder="Nama siswa..." value="{{ request('siswa') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Siswa</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Submission</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $index => $jadwal)
                        @php
                            // Cek file submission untuk tugas
                            $hasSubmission = false;
                            if($jadwal->jenis == 'tugas') {
                                $submissionPath = 'assignments/submissions/' . $jadwal->id_jadwal_materi . '_';
                                $submissionFiles = \Illuminate\Support\Facades\Storage::disk('public')->files('assignments/submissions');
                                foreach($submissionFiles as $file) {
                                    if(str_contains($file, $submissionPath)) {
                                        $hasSubmission = true;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $jadwal->judul }}</strong>
                                @if($jadwal->deskripsi)
                                    <br>
                                    <small class="text-muted">{{ Str::limit(strip_tags($jadwal->deskripsi), 40) }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $jadwal->siswa->nama_siswa }}
                                <br>
                                <small class="text-muted">{{ $jadwal->siswa->jenjang }} - {{ $jadwal->siswa->kelas }}</small>
                            </td>
                            <td>
                                @if($jadwal->jenis == 'materi')
                                    <span class="badge bg-info">Materi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Tugas</span>
                                @endif
                            </td>
                            <td>
                                {{ $jadwal->getTanggalAwalFormatted() }}
                                @if($jadwal->deadline)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $jadwal->getDeadlineFormatted() }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($jadwal->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($jadwal->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                @if($jadwal->jenis == 'tugas')
                                    @if($hasSubmission)
                                        <span class="badge bg-success" title="Sudah dikumpulkan">
                                            <i class="fas fa-check-circle"></i> Sudah
                                        </span>
                                    @else
                                        <span class="badge bg-secondary" title="Belum dikumpulkan">
                                            <i class="fas fa-times-circle"></i> Belum
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($jadwal->nilai)
                                    <strong class="text-success">{{ $jadwal->nilai }}</strong>
                                @elseif($jadwal->jenis == 'tugas')
                                    @if($hasSubmission)
                                        <span class="badge bg-warning">Perlu Dinilai</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.jadwal.show', $jadwal->id_jadwal_materi) }}" 
                                       class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal_materi) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal->id_jadwal_materi) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada jadwal/materi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="text-primary text-uppercase mb-1 small fw-bold">Total Materi</div>
                <div class="h5 mb-0">{{ $jadwals->where('jenis', 'materi')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="text-warning text-uppercase mb-1 small fw-bold">Total Tugas</div>
                <div class="h5 mb-0">{{ $jadwals->where('jenis', 'tugas')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="text-info text-uppercase mb-1 small fw-bold">Perlu Dinilai</div>
                <div class="h5 mb-0">
                    {{ $jadwals->where('jenis', 'tugas')->whereNull('nilai')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="text-success text-uppercase mb-1 small fw-bold">Sudah Dinilai</div>
                <div class="h5 mb-0">
                    {{ $jadwals->where('jenis', 'tugas')->whereNotNull('nilai')->count() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection