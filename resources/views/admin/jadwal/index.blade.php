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
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $index => $jadwal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $jadwal->judul }}</strong>
                                @if($jadwal->deskripsi)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($jadwal->deskripsi, 40) }}</small>
                                @endif
                            </td>
                            <td>{{ $jadwal->siswa->nama_siswa }}</td>
                            <td>
                                @if($jadwal->jenis == 'materi')
                                    <span class="badge bg-info">Materi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Tugas</span>
                                @endif
                            </td>
                            <td>{{ $jadwal->getTanggalAwalFormatted() }}</td>
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
                                @if($jadwal->nilai)
                                    <strong class="text-success">{{ $jadwal->nilai }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.jadwal.show', $jadwal->id_jadwal_materi) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal_materi) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id_jadwal_materi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada jadwal/materi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection