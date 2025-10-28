@extends('layouts.admin')

@section('title', 'Laporan Kehadiran')
@section('page-title', 'Laporan Kehadiran')

@section('content')
<!-- Filter Periode -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.laporan-kehadiran') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="bi bi-search"></i> Tampilkan
                </button>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-success d-block w-100" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary per Siswa -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-bar-chart-fill"></i> Ringkasan Kehadiran per Siswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Jenjang</th>
                        <th class="text-center bg-success-subtle">Hadir</th>
                        <th class="text-center bg-warning-subtle">Sakit</th>
                        <th class="text-center bg-info-subtle">Izin</th>
                        <th class="text-center bg-danger-subtle">Alpha</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($summary as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item['siswa']->nama_lengkap }}</strong>
                            <small class="d-block text-muted">{{ $item['siswa']->kelas }}</small>
                        </td>
                        <td>{{ $item['siswa']->jenjang }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $item['hadir'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning">{{ $item['sakit'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $item['izin'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger">{{ $item['alpha'] }}</span>
                        </td>
                        <td class="text-center fw-bold">{{ $item['total'] }}</td>
                        <td class="text-center">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar 
                                    @if($item['persentase'] >= 80) bg-success 
                                    @elseif($item['persentase'] >= 60) bg-warning 
                                    @else bg-danger 
                                    @endif" 
                                    role="progressbar" 
                                    style="width: {{ $item['persentase'] }}%">
                                    {{ $item['persentase'] }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Kehadiran -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0"><i class="bi bi-list-ul"></i> Detail Kehadiran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tanggal_pertemuan->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_pertemuan->locale('id')->dayName }}</td>
                        <td>
                            <strong>{{ $item->siswa->nama_lengkap }}</strong>
                            <small class="d-block text-muted">{{ $item->siswa->jenjang }} - {{ $item->siswa->kelas }}</small>
                        </td>
                        <td>{{ $item->jadwal->mata_pelajaran }}</td>
                        <td>{{ $item->jadwal->nama_guru }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status_badge_color }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Tidak ada data kehadiran untuk periode ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .sidebar, .navbar, .btn, .card-header .bi-bar-chart-fill, .card-header .bi-list-ul {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        page-break-inside: avoid;
    }
    
    .table {
        font-size: 10pt;
    }
    
    .card-header {
        background: #f8f9fa !important;
        color: black !important;
        border-bottom: 2px solid #000;
    }
}

@page {
    size: A4 landscape;
    margin: 1cm;
}
</style>

@endsection