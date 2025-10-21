{{-- resources/views/admin/orangtua/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Orang Tua - SIDES')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Orang Tua</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Orang Tua</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Hubungan</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orangTuas as $index => $orangTua)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $orangTua->nama_orang_tua }}</strong>
                                @if($orangTua->pekerjaan)
                                    <br>
                                    <small class="text-muted">{{ $orangTua->pekerjaan }}</small>
                                @endif
                            </td>
                            <td>{{ $orangTua->user->email }}</td>
                            <td>{{ $orangTua->user->telepon ?? '-' }}</td>
                            <td>{{ $orangTua->hubungan }}</td>
                            <td>
                                <span class="badge bg-info">{{ $orangTua->siswa_count }} siswa</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orangtua.show', $orangTua->id_orang_tua) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data orang tua</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection