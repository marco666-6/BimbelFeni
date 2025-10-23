<!-- View: orangtua/pengumuman.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Pengumuman')
@section('page-title', 'Pengumuman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-megaphone text-primary"></i> Daftar Pengumuman</h5>
            </div>
            <div class="card-body">
                @if($pengumuman->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada pengumuman.
                    </div>
                @else
                    @foreach($pengumuman as $p)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">{{ $p->judul }}</h5>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 
                                        {{ $p->tanggal_publikasi_formatted }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $p->target_badge_color }}">
                                    {{ $p->target_label }}
                                </span>
                            </div>

                            <div class="pengumuman-content">
                                <p class="mb-0">{!! nl2br(e($p->isi)) !!}</p>
                            </div>

                            @if($p->creator)
                            <hr>
                            <small class="text-muted">
                                <i class="bi bi-person-badge"></i> 
                                Dibuat oleh: {{ $p->creator->username }}
                            </small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .pengumuman-content {
        line-height: 1.8;
    }
</style>
@endpush
@endsection