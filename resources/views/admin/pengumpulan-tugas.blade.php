@extends('layouts.admin')

@section('title', 'Pengumpulan Tugas')
@section('page-title', 'Manajemen Pengumpulan Tugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-arrow-up"></i> Daftar Pengumpulan Tugas</h5>
            </div>
            <div class="card-body">
                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.pengumpulan-tugas') }}">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="belum_dinilai" {{ request('status') == 'belum_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
                                <option value="sudah_dinilai" {{ request('status') == 'sudah_dinilai' ? 'selected' : '' }}>Sudah Dinilai</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari siswa, judul tugas...">
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge bg-warning fs-6">
                            Belum Dinilai: {{ $pengumpulan->where('nilai', null)->count() }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tablePengumpulan">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pengumpulan</th>
                                <th>Siswa</th>
                                <th>Judul Tugas</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th>Nilai</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumpulan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <small>{{ \Carbon\Carbon::parse($item->tanggal_pengumpulan)->format('d-m-Y H:i') }}</small>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->siswa->nama_lengkap }}</strong>
                                        <small class="d-block text-muted">{{ $item->siswa->jenjang }} - {{ $item->siswa->kelas }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->materiTugas->judul }}</strong>
                                        @if($item->materiTugas->deadline)
                                            <small class="d-block text-muted">
                                                Deadline: {{ \Carbon\Carbon::parse($item->materiTugas->deadline)->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->materiTugas->mata_pelajaran }}</td>
                                <td>
                                    @if($item->nilai !== null)
                                        <span class="badge bg-success">Sudah Dinilai</span>
                                    @else
                                        <span class="badge bg-warning">Belum Dinilai</span>
                                    @endif
                                    @php
                                        $isTerlambat = $item->materiTugas->deadline && $item->tanggal_pengumpulan > $item->materiTugas->deadline;
                                    @endphp
                                    @if($isTerlambat)
                                        <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Terlambat</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->nilai !== null)
                                        @php
                                            $grade = $item->nilai >= 90 ? 'A' : ($item->nilai >= 80 ? 'B+' : ($item->nilai >= 75 ? 'B' : ($item->nilai >= 70 ? 'C+' : ($item->nilai >= 60 ? 'C' : ($item->nilai >= 50 ? 'D' : 'E')))));
                                            $badgeColor = $item->nilai >= 75 ? 'success' : ($item->nilai >= 60 ? 'warning' : 'danger');
                                        @endphp
                                        <span class="badge bg-{{ $badgeColor }} fs-6">
                                            {{ $item->nilai }} ({{ $grade }})
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->file_path)
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $item->id }}" title="Nilai">
                                        <i class="bi bi-award"></i>
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Detail Pengumpulan --}}
                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title"><i class="bi bi-eye"></i> Detail Pengumpulan Tugas</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-primary">
                                                        <div class="card-header bg-primary text-white">
                                                            <strong>Informasi Siswa</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p><strong>Nama:</strong> {{ $item->siswa->nama_lengkap }}</p>
                                                            <p><strong>Jenjang:</strong> {{ $item->siswa->jenjang }}</p>
                                                            <p><strong>Kelas:</strong> {{ $item->siswa->kelas }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-info">
                                                        <div class="card-header bg-info text-white">
                                                            <strong>Informasi Tugas</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p><strong>Judul:</strong> {{ $item->materiTugas->judul }}</p>
                                                            <p><strong>Mata Pelajaran:</strong> {{ $item->materiTugas->mata_pelajaran }}</p>
                                                            @if($item->materiTugas->deadline)
                                                                <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($item->materiTugas->deadline)->format('d/m/Y H:i') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @php
                                                    $isTerlambat = $item->materiTugas->deadline && $item->tanggal_pengumpulan > $item->materiTugas->deadline;
                                                @endphp
                                                <div class="col-12 mb-3">
                                                    <div class="card {{ $isTerlambat ? 'border-danger' : 'border-success' }}">
                                                        <div class="card-header bg-{{ $isTerlambat ? 'danger' : 'success' }} text-white">
                                                            <strong>Status Pengumpulan</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p><strong>Tanggal Pengumpulan:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pengumpulan)->format('d/m/Y H:i') }}</p>
                                                            @if($isTerlambat)
                                                                <p class="text-danger"><i class="bi bi-exclamation-triangle"></i> <strong>Tugas dikumpulkan terlambat</strong></p>
                                                            @else
                                                                <p class="text-success"><i class="bi bi-check-circle"></i> <strong>Tugas dikumpulkan tepat waktu</strong></p>
                                                            @endif
                                                            @if($item->file_path)
                                                                <p><strong>File:</strong> 
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                        <i class="bi bi-download"></i> Download File
                                                                    </a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($item->nilai !== null)
                                                    @php
                                                        $grade = $item->nilai >= 90 ? 'A' : ($item->nilai >= 80 ? 'B+' : ($item->nilai >= 75 ? 'B' : ($item->nilai >= 70 ? 'C+' : ($item->nilai >= 60 ? 'C' : ($item->nilai >= 50 ? 'D' : 'E')))));
                                                    @endphp
                                                    <div class="col-12 mb-3">
                                                        <div class="card border-warning">
                                                            <div class="card-header bg-warning text-dark">
                                                                <strong>Penilaian</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <p><strong>Nilai:</strong> <span class="badge bg-primary fs-5">{{ $item->nilai }} ({{ $grade }})</span></p>
                                                                @if($item->feedback_guru)
                                                                    <p><strong>Feedback Guru:</strong><br>{{ $item->feedback_guru }}</p>
                                                                @else
                                                                    <p class="text-muted">Tidak ada feedback</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 mb-3">
                                                        <div class="alert alert-warning">
                                                            <i class="bi bi-exclamation-triangle"></i> Tugas ini belum dinilai
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Nilai Tugas --}}
                            <div class="modal fade" id="modalNilai{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.pengumpulan-tugas.nilai', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title"><i class="bi bi-award"></i> Nilai Tugas</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Info Siswa & Tugas -->
                                                <div class="card mb-3 border-info">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <strong>Siswa:</strong> {{ $item->siswa->nama_lengkap }} ({{ $item->siswa->jenjang }} - {{ $item->siswa->kelas }})
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Tanggal Pengumpulan:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pengumpulan)->format('d/m/Y H:i') }}
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <strong>Judul Tugas:</strong> {{ $item->materiTugas->judul }}
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <strong>Mata Pelajaran:</strong> {{ $item->materiTugas->mata_pelajaran }}
                                                            </div>
                                                            @if($item->file_path)
                                                                <div class="col-12 mt-2">
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-download"></i> Download File Tugas
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Form Penilaian -->
                                                <div class="mb-3">
                                                    <label class="form-label">Nilai (0-100) <span class="text-danger">*</span></label>
                                                    <input type="number" name="nilai" class="form-control form-control-lg" min="0" max="100" required placeholder="Masukkan nilai" value="{{ $item->nilai }}">
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            Keterangan: A (90-100), B+ (80-89), B (75-79), C+ (70-74), C (60-69), D (50-59), E (<50)
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Feedback untuk Siswa</label>
                                                    <textarea name="feedback_guru" class="form-control" rows="4" placeholder="Berikan feedback atau komentar untuk siswa (opsional)">{{ $item->feedback_guru }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan Nilai</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada pengumpulan tugas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
        $('#tablePengumpulan tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endpush