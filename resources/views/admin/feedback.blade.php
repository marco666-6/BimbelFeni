@extends('layouts.admin')

@section('title', 'Kelola Feedback')
@section('page-title', 'Manajemen Feedback')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-chat-left-text"></i> Daftar Feedback dari Orang Tua</h5>
            </div>
            <div class="card-body">
                {{-- Alert sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter & Stats -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.feedback') }}">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="dibaca" {{ request('status') == 'dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari orang tua, siswa...">
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge bg-danger fs-6">
                            Feedback Baru: {{ $feedback->where('status', 'belum_dibaca')->count() }}
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="tableFeedback">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Tanggal</th>
                                <th width="15%">Orang Tua</th>
                                <th width="15%">Siswa</th>
                                <th width="30%">Feedback</th>
                                <th width="10%">Status</th>
                                <th width="13%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedback as $index => $item)
                            <tr class="{{ $item->status === 'belum_dibaca' ? 'table-warning' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <small>{{ \Carbon\Carbon::parse($item->tanggal_feedback)->format('d-m-Y H:i') }}</small>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->orangTua->nama_lengkap ?? '-' }}</strong>
                                        <small class="d-block text-muted">{{ $item->orangTua->no_telepon ?? '-' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->siswa->nama_lengkap ?? '-' }}</strong>
                                        <small class="d-block text-muted">{{ $item->siswa->jenjang ?? '-' }} - {{ $item->siswa->kelas ?? '-' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="feedback-preview">
                                        {{ Str::limit($item->isi_feedback, 80) }}
                                    </div>
                                </td>
                                <td>
                                    @if ($item->status === 'belum_dibaca')
                                        <span class="badge bg-danger">Belum Dibaca</span>
                                    @else
                                        <span class="badge bg-success">Dibaca</span>
                                    @endif
                                    @if($item->balasan_admin)
                                        <br><small class="text-success"><i class="bi bi-check-circle"></i> Dibalas</small>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalBalas{{ $item->id }}" title="Balas">
                                        <i class="bi bi-reply"></i>
                                    </button>
                                    <form action="{{ route('admin.feedback.delete', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title"><i class="bi bi-eye"></i> Detail Feedback</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-primary">
                                                        <div class="card-header bg-primary text-white">
                                                            <strong>Informasi Orang Tua</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p><strong>Nama:</strong> {{ $item->orangTua->nama_lengkap ?? '-' }}</p>
                                                            <p><strong>No. Telepon:</strong> {{ $item->orangTua->no_telepon ?? '-' }}</p>
                                                            <p><strong>Email:</strong> {{ $item->orangTua->user->email ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card border-info">
                                                        <div class="card-header bg-info text-white">
                                                            <strong>Informasi Siswa</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p><strong>Nama:</strong> {{ $item->siswa->nama_lengkap ?? '-' }}</p>
                                                            <p><strong>Jenjang:</strong> {{ $item->siswa->jenjang ?? '-' }}</p>
                                                            <p><strong>Kelas:</strong> {{ $item->siswa->kelas ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 mb-3">
                                                    <div class="card border-warning">
                                                        <div class="card-header bg-warning text-dark">
                                                            <strong>Feedback</strong>
                                                            <small class="float-end">{{ \Carbon\Carbon::parse($item->tanggal_feedback)->format('d-m-Y H:i') }}</small>
                                                        </div>
                                                        <div class="card-body">
                                                            <p style="white-space: pre-wrap;">{{ $item->isi_feedback }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($item->balasan_admin)
                                                <div class="col-12 mb-3">
                                                    <div class="card border-success">
                                                        <div class="card-header bg-success text-white">
                                                            <strong>Balasan Admin</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <p style="white-space: pre-wrap;">{{ $item->balasan_admin }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-12 mb-3">
                                                    <div class="alert alert-warning">
                                                        <i class="bi bi-exclamation-triangle"></i> Feedback ini belum dibalas
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

                            {{-- Modal Balas Feedback --}}
                            <div class="modal fade" id="modalBalas{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.feedback.balas', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title"><i class="bi bi-reply"></i> Balas Feedback</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Info Feedback -->
                                                <div class="card mb-3 border-info">
                                                    <div class="card-header bg-info text-white">
                                                        <strong>Feedback dari Orang Tua</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Orang Tua:</strong></div>
                                                            <div class="col-md-8">{{ $item->orangTua->nama_lengkap ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Siswa:</strong></div>
                                                            <div class="col-md-8">{{ $item->siswa->nama_lengkap ?? '-' }} ({{ $item->siswa->jenjang ?? '-' }} - {{ $item->siswa->kelas ?? '-' }})</div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Tanggal:</strong></div>
                                                            <div class="col-md-8">{{ \Carbon\Carbon::parse($item->tanggal_feedback)->format('d-m-Y H:i') }}</div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <strong>Isi Feedback:</strong>
                                                                <div class="mt-2 p-3 bg-light rounded">{{ $item->isi_feedback }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Form Balasan -->
                                                <div class="mb-3">
                                                    <label class="form-label">Balasan Admin <span class="text-danger">*</span></label>
                                                    <textarea name="balasan_admin" class="form-control" rows="5" required placeholder="Tulis balasan untuk orang tua...">{{ $item->balasan_admin }}</textarea>
                                                </div>

                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle"></i> Orang tua akan menerima notifikasi setelah Anda mengirim balasan ini.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Kirim Balasan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada feedback</td>
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
        $('#tableFeedback tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function confirmDelete(formId) {
    Swal.fire({
        title: 'Hapus Feedback?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush