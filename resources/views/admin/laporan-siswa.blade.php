<!-- View: admin/laporan-siswa.blade.php -->
@extends('layouts.admin')

@section('title', 'Laporan Siswa')
@section('page-title', 'Laporan & Monitoring Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Rekapitulasi Data Siswa</h5>
            </div>
            <div class="card-body">
                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari nama siswa, orang tua, kelas...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterJenjang" class="form-select">
                            <option value="">Semua Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tableLaporan">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Jenjang/Kelas</th>
                                <th>Orang Tua</th>
                                <th>Kehadiran</th>
                                <th>Rata-rata Nilai</th>
                                <th>Total Tugas</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $s->nama_lengkap }}</strong>
                                        <small class="d-block text-muted">{{ $s->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $s->jenjang }}</span>
                                    <span class="badge bg-secondary">{{ $s->kelas }}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $s->orangTua->nama_lengkap }}</strong>
                                        <small class="d-block text-muted">{{ $s->orangTua->no_telepon }}</small>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $totalKehadiran = $s->kehadiran->count();
                                        $persenKehadiran = $totalKehadiran > 0 ? round(($s->kehadiran->where('status', 'hadir')->count() / $totalKehadiran) * 100, 1) : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $persenKehadiran >= 80 ? 'bg-success' : ($persenKehadiran >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                             style="width: {{ $persenKehadiran }}%">
                                            {{ $persenKehadiran }}%
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $s->kehadiran->where('status', 'hadir')->count() }}/{{ $totalKehadiran }} pertemuan</small>
                                </td>
                                <td>
                                    @php
                                        $rataNilai = $s->rata_nilai;
                                    @endphp
                                    @if($rataNilai > 0)
                                        <span class="badge bg-{{ $rataNilai >= 75 ? 'success' : ($rataNilai >= 60 ? 'warning' : 'danger') }} fs-6">
                                            {{ number_format($rataNilai, 1) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <span class="badge bg-primary">{{ $s->total_tugas_terkumpul }} terkumpul</span>
                                        @if($s->tugas_tertunda > 0)
                                            <span class="badge bg-danger">{{ $s->tugas_tertunda }} tertunda</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $transaksiTerakhir = $s->transaksi()->latest('tanggal_transaksi')->first();
                                    @endphp
                                    @if($transaksiTerakhir)
                                        <span class="badge bg-{{ $transaksiTerakhir->status_badge_color }}">
                                            {{ $transaksiTerakhir->status_label }}
                                        </span>
                                    @else
                                        <span class="text-muted">Belum ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.laporan-siswa.detail', $s->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Siswa</h5>
                <h2>{{ $siswa->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Siswa SD</h5>
                <h2>{{ $siswa->where('jenjang', 'SD')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Siswa SMP</h5>
                <h2>{{ $siswa->where('jenjang', 'SMP')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Rata-rata Kehadiran</h5>
                <h2>
                    @php
                        $avgKehadiran = $siswa->avg('persentase_kehadiran');
                    @endphp
                    {{ number_format($avgKehadiran, 1) }}%
                </h2>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#tableLaporan tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Filter by jenjang
    $('#filterJenjang').change(function() {
        const jenjang = $(this).val();
        $('#tableLaporan tbody tr').each(function() {
            if (jenjang === '') {
                $(this).show();
            } else {
                const rowJenjang = $(this).find('td:eq(2)').text();
                $(this).toggle(rowJenjang.indexOf(jenjang) > -1);
            }
        });
    });
});
</script>
@endpush