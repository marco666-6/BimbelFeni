{{-- resources/views/admin/informasi/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Informasi & Pengumuman - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Informasi & Pengumuman</h1>
    <a href="{{ route('admin.informasi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Informasi
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Untuk Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informasis as $index => $informasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $informasi->getDibuat() }}</td>
                            <td>
                                <strong>{{ $informasi->judul }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($informasi->isi, 60) }}</small>
                            </td>
                            <td>
                                @if($informasi->jenis == 'pengumuman')
                                    <span class="badge bg-info">Pengumuman</span>
                                @else
                                    <span class="badge bg-warning text-dark">Notifikasi</span>
                                @endif
                            </td>
                            <td>
                                @if($informasi->siswa)
                                    {{ $informasi->siswa->nama_siswa }}
                                @else
                                    <span class="badge bg-secondary">Semua Siswa</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.informasi.destroy', $informasi->id_informasi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                            <td colspan="6" class="text-center">Belum ada informasi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection