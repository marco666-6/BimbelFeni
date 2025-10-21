{{-- resources/views/admin/pendaftaran/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pendaftaran - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pendaftaran Siswa</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Daftar</th>
                        <th>Orang Tua</th>
                        <th>Nama Siswa</th>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftarans as $index => $pendaftaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pendaftaran->getTanggalDaftarFormatted() }}</td>
                            <td>
                                <strong>{{ $pendaftaran->orangTua->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $pendaftaran->orangTua->user->email }}</small>
                            </td>
                            <td>{{ $pendaftaran->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $pendaftaran->paketBelajar->nama_paket }}</td>
                            <td>
                                @if($pendaftaran->status == 'menunggu')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($pendaftaran->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id_pendaftaran) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pendaftaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection