<!-- View: admin/profile.blade.php -->
@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->foto_profil_url }}" alt="Foto Profil" class="rounded-circle mb-3" width="150" height="150">
                <h5>{{ $user->username }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                <span class="badge bg-{{ $user->isAktif() ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="foto_profil" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Ubah Password</h6>
                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" minlength="6" placeholder="Minimal 6 karakter">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru">
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Preview foto before upload
    $('input[name="foto_profil"]').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.rounded-circle').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Validate password confirmation
    $('form').submit(function(e) {
        const password = $('input[name="password"]').val();
        const confirmation = $('input[name="password_confirmation"]').val();
        
        if (password && password !== confirmation) {
            e.preventDefault();
            Swal.fire('Error', 'Konfirmasi password tidak cocok!', 'error');
            return false;
        }
    });
});
</script>
@endpush