{{-- resources/views/admin/siswa/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Siswa - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Siswa</h1>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Siswa
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Jenjang/Kelas</th>
                        <th>Orang Tua</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $siswa->nama_siswa }}</strong>
                                <br>
                                <small class="text-muted">{{ $siswa->getTanggalLahirFormatted() }}</small>
                            </td>
                            <td>{{ $siswa->user->email }}</td>
                            <td>{{ $siswa->jenjang }} - Kelas {{ $siswa->kelas }}</td>
                            <td>{{ $siswa->orangTua->nama_orang_tua }}</td>
                            <td>
                                @if($siswa->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.siswa.show', $siswa->id_siswa) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.siswa.edit', $siswa->id_siswa) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id_siswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
                            <td colspan="7" class="text-center">Belum ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection