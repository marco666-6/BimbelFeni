<!-- View: admin/kehadiran.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Kehadiran')
@section('page-title', 'Manajemen Kehadiran')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Daftar Kehadiran</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKehadiran">
                    <i class="bi bi-plus-circle"></i> Tambah Kehadiran
                </button>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari siswa, jadwal...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="hadir">Hadir</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tableKehadiran">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kehadiran as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tanggal_pertemuan->format('d/m/Y') }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $item->siswa->nama_lengkap }}</strong>
                                        <small class="d-block text-muted">{{ $item->siswa->jenjang }} - {{ $item->siswa->kelas }}</small>
                                    </div>
                                </td>
                                <td>{{ $item->jadwal->mata_pelajaran }}</td>
                                <td>{{ $item->jadwal->nama_guru }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status_badge_color }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editKehadiran({{ $item->id }})" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.kehadiran.delete', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data kehadiran</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kehadiran -->
<div class="modal fade" id="modalTambahKehadiran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.kehadiran.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Kehadiran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jadwal <span class="text-danger">*</span></label>
                        <select name="jadwal_id" class="form-select" required id="jadwalSelect">
                            <option value="">Pilih Jadwal</option>
                            @foreach($jadwal as $j)
                            <option value="{{ $j->id }}" data-siswa="{{ $j->siswa_id }}">
                                {{ $j->siswa->nama_lengkap }} - {{ $j->mata_pelajaran }} ({{ $j->hari }}, {{ $j->jam_formatted }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="siswa_id" id="siswaIdInput">

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pertemuan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pertemuan" class="form-control" required value="{{ date('Y-m-d') }}">
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
                @csrf
                @method('PUT')
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

    // Search functionality
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#tableKehadiran tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Filter by status
    $('#filterStatus').change(function() {
        const status = $(this).val().toLowerCase();
        $('#tableKehadiran tbody tr').each(function() {
            if (status === '') {
                $(this).show();
            } else {
                const rowStatus = $(this).find('td:eq(5)').text().toLowerCase();
                $(this).toggle(rowStatus.indexOf(status) > -1);
            }
        });
    });
});

function editKehadiran(id) {
    // Fetch data via AJAX
    $.get(`/admin/kehadiran/${id}/edit`, function(data) {
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