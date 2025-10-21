{{-- resources/views/admin/jadwal/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Jadwal/Materi - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal/Materi</h1>
    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.jadwal.update', $jadwal->id_jadwal_materi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_siswa" class="form-label">Siswa <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_siswa') is-invalid @enderror" id="id_siswa" name="id_siswa" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id_siswa }}" {{ old('id_siswa', $jadwal->id_siswa) == $siswa->id_siswa ? 'selected' : '' }}>
                                    {{ $siswa->nama_siswa }} ({{ $siswa->jenjang }} - {{ $siswa->kelas }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="materi" {{ old('jenis', $jadwal->jenis) == 'materi' ? 'selected' : '' }}>Materi</option>
                            <option value="tugas" {{ old('jenis', $jadwal->jenis) == 'tugas' ? 'selected' : '' }}>Tugas</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                       id="judul" name="judul" value="{{ old('judul', $jadwal->judul) }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if($jadwal->file)
            <div class="mb-3">
                <label class="form-label">File Saat Ini</label>
                <div>
                    <a href="{{ Storage::url($jadwal->file) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-download"></i> Lihat File
                    </a>
                </div>
            </div>
            @endif

            <div class="mb-3">
                <label for="file" class="form-label">Upload File Baru (PDF, DOC, PPT, XLS, ZIP - Max 10MB)</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" 
                       id="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah file</small>
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="awal" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('awal') is-invalid @enderror" 
                               id="awal" name="awal" value="{{ old('awal', $jadwal->awal ? $jadwal->awal->format('Y-m-d\TH:i') : '') }}" required>
                        @error('awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" 
                               id="deadline" name="deadline" value="{{ old('deadline', $jadwal->deadline ? $jadwal->deadline->format('Y-m-d\TH:i') : '') }}">
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="durasi" class="form-label">Durasi (menit)</label>
                        <input type="number" class="form-control @error('durasi') is-invalid @enderror" 
                               id="durasi" name="durasi" value="{{ old('durasi', $jadwal->durasi) }}" min="1">
                        @error('durasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $jadwal->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="selesai" {{ old('status', $jadwal->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="terlambat" {{ old('status', $jadwal->status) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection