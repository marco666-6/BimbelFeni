@extends('layouts.ortusiswa')

@section('title', 'Daftar Anak')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4 text-gray-800">Daftar Anak Saya</h1>
    </div>
</div>

<div class="row">
    @forelse($siswas as $siswa)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($siswa->user->foto_profil)
                        <img src="{{ asset($siswa->user->foto_profil) }}" alt="{{ $siswa->nama_siswa }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
                            {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <h5 class="mb-2">{{ $siswa->nama_siswa }}</h5>
                
                <div class="mb-3">
                    @if($siswa->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Non-Aktif</span>
                    @endif
                </div>

                <div class="text-start mb-3">
                    <p class="mb-1"><i class="fas fa-school text-primary"></i> <strong>Jenjang:</strong> {{ $siswa->jenjang }}</p>
                    <p class="mb-1"><i class="fas fa-chalkboard text-primary"></i> <strong>Kelas:</strong> {{ $siswa->kelas }}</p>
                    <p class="mb-1"><i class="fas fa-birthday-cake text-primary"></i> <strong>Usia:</strong> {{ $siswa->getUmur() }} tahun</p>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('orangtua.siswa.show', $siswa->id_siswa) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('orangtua.laporan-anak', $siswa->id_siswa) }}" class="btn btn-outline-info">
                        <i class="fas fa-chart-line"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Anak Terdaftar</h5>
                <p class="text-muted">Daftarkan anak Anda untuk memulai program bimbingan belajar</p>
                <a href="{{ route('orangtua.pendaftaran.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Daftarkan Anak
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection