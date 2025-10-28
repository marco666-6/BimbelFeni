<!-- View: admin/materi-tugas.blade.php -->
@extends('layouts.admin')

@section('title', 'Kelola Materi & Tugas')
@section('page-title', 'Manajemen Materi & Tugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-book"></i> Daftar Materi & Tugas</h5>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMateriTugas">
                    <i class="bi bi-plus-circle"></i> Tambah Materi/Tugas
                </button>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" onchange="window.location.href='?tipe=' + this.value + '&jenjang={{ request('jenjang', 'all') }}'">
                            <option value="all" {{ request('tipe') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                            <option value="materi" {{ request('tipe') == 'materi' ? 'selected' : '' }}>Materi</option>
                            <option value="tugas" {{ request('tipe') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" onchange="window.location.href='?tipe={{ request('tipe', 'all') }}&jenjang=' + this.value">
                            <option value="all" {{ request('jenjang') == 'all' ? 'selected' : '' }}>Semua Jenjang</option>
                            <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari judul, mata pelajaran...">
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tableMateriTugas">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Mata Pelajaran</th>
                                <th>Jenjang</th>
                                <th>Deadline</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materiTugas as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->tipe_badge_color }}">
                                        {{ $item->tipe_label }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->judul }}</strong>
                                        <small class="d-block text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                    </div>
                                </td>
                                <td>{{ $item->mata_pelajaran }}</td>
                                <td><span class="badge bg-info">{{ $item->jenjang }}</span></td>
                                <td>
                                    @if($item->deadline)
                                        <small>{{ $item->deadline_formatted }}</small>
                                        @if($item->isDeadlinePassed())
                                            <br><span class="badge bg-danger">Deadline Lewat</span>
                                        @else
                                            <br><span class="text-success">{{ $item->sisa_waktu_deadline }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->file_path)
                                        <a href="{{ $item->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.materi-tugas.delete', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
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
                                <td colspan="8" class="text-center text-muted">Tidak ada data materi/tugas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($materiTugas as $item)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.materi-tugas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit {{ $item->tipe_label }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tipe" value="{{ $item->tipe }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenjang <span class="text-danger">*</span></label>
                            <select name="jenjang" class="form-select" required>
                                <option value="SD" {{ $item->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ $item->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mata_pelajaran" class="form-control" value="{{ $item->mata_pelajaran }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" required>{{ $item->deskripsi }}</textarea>
                    </div>

                    @if($item->tipe === 'tugas')
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" value="{{ $item->deadline ? $item->deadline->format('Y-m-d\TH:i') : '' }}">
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Upload File Baru (Opsional)</label>
                        <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                        @if($item->file_path)
                            <small class="text-success d-block mt-1"><i class="bi bi-check-circle"></i> File saat ini: {{ basename($item->file_path) }}</small>
                        @endif
                        <small class="text-muted d-block">Kosongkan jika tidak ingin mengganti file</small>
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
                <h5 class="modal-title"><i class="bi bi-eye"></i> Detail {{ $item->tipe_label }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Tipe:</strong></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-{{ $item->tipe_badge_color }}">{{ $item->tipe_label }}</span></div>
                    
                    <div class="col-md-6 mb-2"><strong>Jenjang:</strong></div>
                    <div class="col-md-6 mb-2"><span class="badge bg-info">{{ $item->jenjang }}</span></div>
                    
                    <div class="col-md-6 mb-2"><strong>Mata Pelajaran:</strong></div>
                    <div class="col-md-6 mb-2">{{ $item->mata_pelajaran }}</div>
                    
                    <div class="col-12 mb-2"><hr></div>
                    
                    <div class="col-12 mb-2"><strong>Judul:</strong></div>
                    <div class="col-12 mb-3">{{ $item->judul }}</div>
                    
                    <div class="col-12 mb-2"><strong>Deskripsi:</strong></div>
                    <div class="col-12 mb-3">{{ $item->deskripsi }}</div>
                    
                    @if($item->deadline)
                    <div class="col-12 mb-2"><hr></div>
                    <div class="col-md-6 mb-2"><strong>Deadline:</strong></div>
                    <div class="col-md-6 mb-2">{{ $item->deadline->format('d/m/Y H:i') }}</div>
                    <div class="col-md-6 mb-2"><strong>Status:</strong></div>
                    <div class="col-md-6 mb-2">
                        @if($item->isDeadlinePassed())
                            <span class="badge bg-danger">Deadline Lewat</span>
                        @else
                            <span class="badge bg-success">{{ $item->sisa_waktu_deadline }}</span>
                        @endif
                    </div>
                    @endif
                    
                    @if($item->file_path)
                    <div class="col-12 mb-2"><hr></div>
                    <div class="col-12 mb-2">
                        <strong>File:</strong><br>
                        <a href="{{ $item->file_url }}" target="_blank" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-download"></i> Download File
                        </a>
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
@endforeach

<!-- Modal Tambah Materi/Tugas -->
<div class="modal fade" id="modalTambahMateriTugas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.materi-tugas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Materi/Tugas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select name="tipe" class="form-select" required id="tipeSelect">
                                <option value="materi">Materi</option>
                                <option value="tugas">Tugas</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenjang <span class="text-danger">*</span></label>
                            <select name="jenjang" class="form-select" required>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" name="mata_pelajaran" class="form-control" required placeholder="Contoh: Matematika">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required placeholder="Judul materi/tugas">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Deskripsi detail materi/tugas"></textarea>
                    </div>

                    <div class="mb-3" id="deadlineField" style="display:none;">
                        <label class="form-label">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control">
                        <small class="text-muted">Opsional untuk tugas</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input type="file" name="file_path" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                        <small class="text-muted">Maksimal 10MB. Format: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG</small>
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
    // Show/hide deadline field based on tipe
    $('#tipeSelect').change(function() {
        if ($(this).val() === 'tugas') {
            $('#deadlineField').show();
        } else {
            $('#deadlineField').hide();
        }
    });

    // Search functionality
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#tableMateriTugas tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function confirmDelete(formId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
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