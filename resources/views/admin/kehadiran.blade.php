@extends('layouts.admin')

@section('title', 'Kelola Kehadiran')
@section('page-title', 'Manajemen Kehadiran')

@section('content')
<!-- Filter Tanggal -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.kehadiran') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Pilih Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" onchange="this.form.submit()">
            </div>
            <div class="col-md-4">
                <div class="alert alert-info mb-0">
                    <i class="bi bi-calendar-check"></i> <strong>Hari: {{ $hari }}</strong>
                    <br><small>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</small>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAbsensiMassal">
                    <i class="bi bi-people-fill"></i> Absensi Massal
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAbsensiJadwal">
                    <i class="bi bi-calendar-check-fill"></i> Absensi per Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3>{{ $kehadiran->where('status', 'hadir')->count() }}</h3>
                <p class="mb-0">Hadir</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h3>{{ $kehadiran->where('status', 'sakit')->count() }}</h3>
                <p class="mb-0">Sakit</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h3>{{ $kehadiran->where('status', 'izin')->count() }}</h3>
                <p class="mb-0">Izin</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h3>{{ $kehadiran->where('status', 'alpha')->count() }}</h3>
                <p class="mb-0">Alpha</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Kehadiran -->
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Daftar Kehadiran</h5>
        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKehadiran">
            <i class="bi bi-plus-circle"></i> Tambah Manual
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tableKehadiran">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Siswa</th>
                        <th width="20%">Mata Pelajaran</th>
                        <th width="15%">Guru</th>
                        <th width="10%">Jam</th>
                        <th width="15%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kehadiran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->siswa->nama_lengkap }}</strong>
                            <small class="d-block text-muted">{{ $item->siswa->jenjang }} - {{ $item->siswa->kelas }}</small>
                        </td>
                        <td>{{ $item->jadwal->mata_pelajaran }}</td>
                        <td>{{ $item->jadwal->nama_guru }}</td>
                        <td><small>{{ $item->jadwal->jam_formatted }}</small></td>
                        <td>
                            <select class="form-select form-select-sm status-select" data-id="{{ $item->id }}" style="width: auto;">
                                <option value="hadir" {{ $item->status == 'hadir' ? 'selected' : '' }}>✓ Hadir</option>
                                <option value="sakit" {{ $item->status == 'sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                                <option value="izin" {{ $item->status == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                <option value="alpha" {{ $item->status == 'alpha' ? 'selected' : '' }}>✗ Alpha</option>
                            </select>
                            @if($item->keterangan)
                            <small class="d-block text-muted mt-1">{{ $item->keterangan }}</small>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editKehadiran({{ $item->id }})" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.kehadiran.delete', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-clipboard-x" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada data kehadiran untuk tanggal ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Absensi Massal per Jadwal Hari Ini -->
<div class="modal fade" id="modalAbsensiJadwal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.kehadiran.absensi-massal-jadwal') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-calendar-check-fill"></i> Absensi Massal - Jadwal Hari Ini</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tanggal_pertemuan" value="{{ $tanggal }}">
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Jadwal untuk: {{ $hari }}</strong>
                        <br>Pilih jadwal yang akan diabsen secara otomatis
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Default</label>
                        <select name="status_default" class="form-select">
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAllJadwal" onclick="toggleAllJadwal()">
                            <label class="form-check-label fw-bold" for="selectAllJadwal">
                                Pilih Semua Jadwal
                            </label>
                        </div>
                        <hr>
                        @forelse($jadwalHariIni as $jadwal)
                        <div class="form-check mb-2">
                            <input class="form-check-input jadwal-checkbox" type="checkbox" name="jadwal_ids[]" value="{{ $jadwal->id }}" id="jadwal{{ $jadwal->id }}">
                            <label class="form-check-label" for="jadwal{{ $jadwal->id }}">
                                <strong>{{ $jadwal->siswa->nama_lengkap }}</strong> - {{ $jadwal->mata_pelajaran }}
                                <br><small class="text-muted">{{ $jadwal->nama_guru }} | {{ $jadwal->jam_formatted }}</small>
                            </label>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-calendar-x"></i> Tidak ada jadwal untuk hari ini
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Buat Absensi Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Absensi Massal Semua Siswa -->
<div class="modal fade" id="modalAbsensiMassal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.kehadiran.absensi-massal-semua') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-people-fill"></i> Absensi Massal - Semua Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tanggal_pertemuan" value="{{ $tanggal }}">
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Absensi ini akan dibuat untuk semua siswa yang memiliki jadwal pada hari <strong>{{ $hari }}</strong>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="selectAllSiswa" onclick="toggleAllSiswa()">
                                    </th>
                                    <th width="35%">Siswa</th>
                                    <th width="30%">Status</th>
                                    <th width="30%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allSiswa as $index => $siswa)
                                @php
                                    $hasJadwal = $jadwalHariIni->where('siswa_id', $siswa->id)->count() > 0;
                                @endphp
                                @if($hasJadwal)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="siswa-checkbox" name="siswa_ids[]" value="{{ $siswa->id }}">
                                    </td>
                                    <td>
                                        <strong>{{ $siswa->nama_lengkap }}</strong>
                                        <small class="d-block text-muted">{{ $siswa->jenjang }} - {{ $siswa->kelas }}</small>
                                    </td>
                                    <td>
                                        <select name="status[{{ $index }}]" class="form-select form-select-sm">
                                            <option value="hadir">Hadir</option>
                                            <option value="sakit">Sakit</option>
                                            <option value="izin">Izin</option>
                                            <option value="alpha">Alpha</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="keterangan[{{ $index }}]" class="form-control form-control-sm" placeholder="Keterangan (opsional)">
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Absensi Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Tambah Kehadiran Manual -->
<div class="modal fade" id="modalTambahKehadiran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.kehadiran.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Kehadiran Manual</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jadwal <span class="text-danger">*</span></label>
                        <select name="jadwal_id" class="form-select" required id="jadwalSelect">
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwalHariIni as $j)
                            <option value="{{ $j->id }}" data-siswa="{{ $j->siswa_id }}">
                                {{ $j->siswa->nama_lengkap }} - {{ $j->mata_pelajaran }} ({{ $j->jam_formatted }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="siswa_id" id="siswaIdInput">

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pertemuan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pertemuan" class="form-control" required value="{{ $tanggal }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kehadiran -->
<div class="modal fade" id="modalEditKehadiran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditKehadiran" method="POST">
                @csrf @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pertemuan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pertemuan" id="editTanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="editStatus" class="form-select" required>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="editKeterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto set siswa_id when jadwal selected
    $('#jadwalSelect').change(function() {
        const siswaId = $(this).find(':selected').data('siswa');
        $('#siswaIdInput').val(siswaId);
    });

    // Quick update status via AJAX
    $('.status-select').change(function() {
        const id = $(this).data('id');
        const status = $(this).val();
        
        $.ajax({
            url: `/admin/kehadiran/${id}/update-status`,
            method: 'PUT',
            data: { status: status },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengupdate status', 'error');
            }
        });
    });
});

// Toggle all jadwal checkboxes
function toggleAllJadwal() {
    const checked = $('#selectAllJadwal').is(':checked');
    $('.jadwal-checkbox').prop('checked', checked);
}

// Toggle all siswa checkboxes
function toggleAllSiswa() {
    const checked = $('#selectAllSiswa').is(':checked');
    $('.siswa-checkbox').prop('checked', checked);
}

// Edit kehadiran
function editKehadiran(id) {
    $.get(`/admin/kehadiran/${id}/data`, function(data) {
        $('#formEditKehadiran').attr('action', `/admin/kehadiran/${id}`);
        $('#editTanggal').val(data.tanggal_pertemuan);
        $('#editStatus').val(data.status);
        $('#editKeterangan').val(data.keterangan);
        $('#modalEditKehadiran').modal('show');
    }).fail(function() {
        Swal.fire('Error', 'Gagal memuat data kehadiran', 'error');
    });
}
</script>
@endpush