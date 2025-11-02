<!-- View: admin/jadwal.blade.php -->
@extends('layouts.admin')
@section('title', 'Jadwal')
@section('page-title', 'Jadwal Pembelajaran')
@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-circle"></i> Tambah Jadwal</button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom"><h5 class="fw-bold mb-0"><i class="bi bi-calendar-week"></i> Daftar Jadwal</h5></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Siswa</th><th>Mata Pelajaran</th><th>Guru</th><th>Hari</th><th>Jam</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($jadwal as $j)
                    <tr>
                        <td><strong>{{ $j->siswa->nama_lengkap }}</strong><br><small class="text-muted">{{ $j->siswa->jenjang }} - {{ $j->siswa->kelas }}</small></td>
                        <td>{{ $j->mata_pelajaran }}</td>
                        <td>{{ $j->nama_guru }}</td>
                        <td><span class="badge bg-primary">{{ $j->hari }}</span></td>
                        <td>{{ $j->jam_formatted }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $j->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.jadwal.delete', $j->id) }}" method="POST" id="del-{{ $j->id }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('del-{{ $j->id }}')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    
                    
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-calendar-x" style="font-size: 3rem;"></i><p class="mt-2">Belum ada jadwal</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($jadwal as $j)
<div class="modal fade" id="editModal{{ $j->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.jadwal.update', $j->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header"><h5 class="modal-title fw-bold">Edit Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Siswa *</label><select class="form-select" name="siswa_id" required>@foreach($siswa as $s)<option value="{{ $s->id }}" {{ $j->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }} ({{ $s->jenjang }} - {{ $s->kelas }})</option>@endforeach</select></div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Mata Pelajaran *</label><input type="text" class="form-control" name="mata_pelajaran" value="{{ $j->mata_pelajaran }}" required></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Nama Guru *</label><input type="text" class="form-control" name="nama_guru" value="{{ $j->nama_guru }}" required></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="mb-3"><label>Hari *</label><select class="form-select" name="hari" required><option value="Senin" {{ $j->hari == 'Senin' ? 'selected' : '' }}>Senin</option><option value="Selasa" {{ $j->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option><option value="Rabu" {{ $j->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option><option value="Kamis" {{ $j->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option><option value="Jumat" {{ $j->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option><option value="Sabtu" {{ $j->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option><option value="Minggu" {{ $j->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option></select></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Jam Mulai *</label><input type="time" class="form-control" name="jam_mulai" value="{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}" required></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Jam Selesai *</label><input type="time" class="form-control" name="jam_selesai" value="{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}" required></div></div>
                    </div>
                    <!--<div class="mb-3"><label>Ruangan</label><input type="text" class="form-control" name="ruangan" value="{{ $j->ruangan }}"></div>-->
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Update</button></div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Siswa *</label><select class="form-select" name="siswa_id" required><option value="">Pilih Siswa</option>@foreach($siswa as $s)<option value="{{ $s->id }}">{{ $s->nama_lengkap }} ({{ $s->jenjang }} - {{ $s->kelas }})</option>@endforeach</select></div>
                    <div class="row">
                        <div class="col-md-6"><div class="mb-3"><label>Mata Pelajaran *</label><input type="text" class="form-control" name="mata_pelajaran" required></div></div>
                        <div class="col-md-6"><div class="mb-3"><label>Nama Guru *</label><input type="text" class="form-control" name="nama_guru" required></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><div class="mb-3"><label>Hari *</label><select class="form-select" name="hari" required><option value="">Pilih Hari</option><option value="Senin">Senin</option><option value="Selasa">Selasa</option><option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option><option value="Sabtu">Sabtu</option><option value="Minggu">Minggu</option></select></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Jam Mulai *</label><input type="time" class="form-control" name="jam_mulai" required></div></div>
                        <div class="col-md-4"><div class="mb-3"><label>Jam Selesai *</label><input type="time" class="form-control" name="jam_selesai" required></div></div>
                    </div>
                    <!--<div class="mb-3"><label>Ruangan</label><input type="text" class="form-control" name="ruangan"></div>-->
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endsection