@extends('layouts.ortusiswa')

@section('title', 'Daftar Pendaftaran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Pendaftaran</h1>
            <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Daftar Baru
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($pendaftarans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <th>Nama Siswa</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendaftarans as $pendaftaran)
                                <tr>
                                    <td>{{ $pendaftaran->getTanggalDaftarFormatted() }}</td>
                                    <td>{{ $pendaftaran->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $pendaftaran->paketBelajar->nama_paket ?? '-' }}</td>
                                    <td>
                                        @if($pendaftaran->status === 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($pendaftaran->status === 'diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('orangtua.pendaftaran.show', $pendaftaran->id_pendaftaran) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Pendaftaran</h5>
                        <p class="text-muted">Klik tombol "Daftar Baru" untuk mendaftarkan anak Anda</p>
                        <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Daftar Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection