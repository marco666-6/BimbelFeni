{{-- resources/views/admin/pendaftaran/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pendaftaran - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftaran</h1>
    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pendaftaran</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Tanggal Daftar</th>
                        <td>{{ $pendaftaran->getTanggalDaftarFormatted() }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($pendaftaran->status == 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($pendaftaran->status == 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Paket Belajar</th>
                        <td>
                            <strong>{{ $pendaftaran->paketBelajar->nama_paket }}</strong>
                            <br>
                            <small>{{ $pendaftaran->paketBelajar->getFormattedHarga() }} / {{ $pendaftaran->paketBelajar->durasi }} bulan</small>
                        </td>
                    </tr>
                    @if($pendaftaran->tanggal_selesai)
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $pendaftaran->getTanggalSelesaiFormatted() }}</td>
                    </tr>
                    @endif
                    @if($pendaftaran->catatan)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $pendaftaran->catatan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Orang Tua</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama</th>
                        <td>{{ $pendaftaran->orangTua->nama_orang_tua }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pendaftaran->orangTua->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $pendaftaran->orangTua->user->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hubungan</th>
                        <td>{{ $pendaftaran->orangTua->hubungan }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $pendaftaran->orangTua->pekerjaan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($pendaftaran->siswa)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Siswa</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama Siswa</th>
                        <td>{{ $pendaftaran->siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $pendaftaran->siswa->getTanggalLahirFormatted() }}</td>
                    </tr>
                    <tr>
                        <th>Jenjang</th>
                        <td>{{ $pendaftaran->siswa->jenjang }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $pendaftaran->siswa->kelas }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        @if($pendaftaran->status == 'menunggu')
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <strong>Setujui Pendaftaran</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.approve', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Setujui pendaftaran ini?')">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-danger text-white">
                <strong>Tolak Pendaftaran</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pendaftaran.reject', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="catatan_tolak" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan_tolak" name="catatan" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Tolak pendaftaran ini?')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection