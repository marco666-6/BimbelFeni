<!-- View: admin/pengumuman.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page-title', 'Manajemen Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-megaphone"></i> Daftar Pengumuman</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengumuman">
                    <i class="bi bi-plus-circle"></i> Tambah Pengumuman
                </button>
            </div>
            <div class="card-body">
                <!-- Search & Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari judul pengumuman...">
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tablePengumuman">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Judul</th>
                                <th width="30%">Isi</th>
                                <th width="10%">Target</th>
                                <th width="12%">Tanggal</th>
                                <th width="8%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumuman as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $item->judul }}</strong></td>
                                <td>{{ Str::limit($item->isi, 80) }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->target_badge_color }}">
                                        {{ $item->target_label }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        @if($item->tanggal_publikasi)
                                            {{ $item->tanggal_publikasi_formatted }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $item->status_badge_color }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.pengumuman.delete', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
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
                                <td colspan="7" class="text-center text-muted">Tidak ada pengumuman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($pengumuman as $item)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.pengumuman.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control" rows="6" required>{{ $item->isi }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target <span class="text-danger">*</span></label>
                            <select name="target" class="form-select" required>
                                <option value="semua" {{ $item->target == 'semua' ? 'selected' : '' }}>Semua Pengguna</option>
                                <option value="orangtua" {{ $item->target == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                                <option value="siswa" {{ $item->target == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $item->status == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
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

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-eye"></i> Detail Pengumuman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="mb-3">{{ $item->judul }}</h4>
                        <div class="mb-3">
                            <span class="badge bg-{{ $item->status_badge_color }}">{{ $item->status_label }}</span>
                            <span class="badge bg-{{ $item->target_badge_color }} ms-2">Target: {{ $item->target_label }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> Dibuat oleh: {{ $item->creator->username }}
                                @if($item->tanggal_publikasi)
                                    <br><i class="bi bi-calendar"></i> Dipublikasikan: {{ $item->tanggal_publikasi->format('d/m/Y H:i') }}
                                @endif
                            </small>
                        </div>
                        <hr>
                        <div style="white-space: pre-wrap;">{{ $item->isi }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="modalTambahPengumuman" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Pengumuman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required placeholder="Judul pengumuman">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control" rows="6" required placeholder="Tulis isi pengumuman di sini..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Target <span class="text-danger">*</span></label>
                            <select name="target" class="form-select" required>
                                <option value="semua">Semua Pengguna</option>
                                <option value="orangtua">Orang Tua</option>
                                <option value="siswa">Siswa</option>
                            </select>
                            <small class="text-muted">Pilih siapa yang akan menerima pengumuman</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="draft">Draft (Simpan saja)</option>
                                <option value="published">Published (Langsung kirim)</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Jika status "Published", pengumuman akan langsung dikirim ke target pengguna dan mereka akan menerima notifikasi.
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#tablePengumuman tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function confirmDelete(formId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Pengumuman yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush