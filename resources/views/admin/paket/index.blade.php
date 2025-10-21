{{-- resources/views/admin/paket/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Paket Belajar - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Paket Belajar</h1>
    <a href="{{ route('admin.paket.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Paket
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Total Pendaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pakets as $index => $paket)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $paket->nama_paket }}</strong>
                                @if($paket->deskripsi)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($paket->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $paket->getFormattedHarga() }}</td>
                            <td>{{ $paket->durasi }} bulan</td>
                            <td>
                                <span class="badge bg-info">{{ $paket->pendaftaran_count }} pendaftar</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.paket.edit', $paket->id_paket) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.paket.destroy', $paket->id_paket) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
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
                            <td colspan="6" class="text-center">Belum ada paket belajar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection