{{-- resources/views/admin/jadwal/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Jadwal/Materi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jadwal/Materi</h1>
    <div>
        <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal_materi) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi {{ $jadwal->jenis == 'materi' ? 'Materi' : 'Tugas' }}</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Judul</th>
                        <td><strong>{{ $jadwal->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>
                            @if($jadwal->jenis == 'materi')
                                <span class="badge bg-info">Materi</span>
                            @else
                                <span class="badge bg-warning text-dark">Tugas</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Siswa</th>
                        <td>{{ $jadwal->siswa->nama_siswa }} ({{ $jadwal->siswa->jenjang }} - {{ $jadwal->siswa->kelas }})</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
                    </tr>
                    @if($jadwal->deadline)
                    <tr>
                        <th>Deadline</th>
                        <td>{{ $jadwal->getDeadlineFormatted() }}</td>
                    </tr>
                    @endif
                    @if($jadwal->durasi)
                    <tr>
                        <th>Durasi</th>
                        <td>{{ $jadwal->getDurasiFormatted() }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($jadwal->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                    @if($jadwal->deskripsi)
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $jadwal->deskripsi }}</td>
                    </tr>
                    @endif
                    @if($jadwal->file)
                    <tr>
                        <th>File</th>
                        <td>
                            <a href="{{ Storage::url($jadwal->file) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if($jadwal->jenis == 'tugas' && !$jadwal->nilai)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Input Nilai</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal.nilai', $jadwal->id_jadwal_materi) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="nilai" name="nilai" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Komentar</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check"></i> Simpan Nilai
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($jadwal->nilai)
        <div class="card">
            <div class="card-header bg-success text-white">
                <strong>Nilai</strong>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-success">{{ $jadwal->nilai }}</h1>
                <p class="mb-0">Tugas telah dinilai</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection