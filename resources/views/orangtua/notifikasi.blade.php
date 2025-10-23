<!-- View: orangtua/notifikasi.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-bell text-primary"></i> Notifikasi</h5>
                @if($notifikasi->where('dibaca', false)->count() > 0)
                <span class="badge bg-danger">{{ $notifikasi->where('dibaca', false)->count() }} Belum Dibaca</span>
                @endif
            </div>
            <div class="card-body">
                @if($notifikasi->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada notifikasi.
                    </div>
                @else
                    <div class="list-group">
                        @foreach($notifikasi as $n)
                        <div class="list-group-item {{ $n->isBelumDibaca() ? 'list-group-item-light border-start border-primary border-4' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-{{ $n->tipe_badge_color }} text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bi bi-{{ $n->tipe_icon }}"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">
                                                {{ $n->judul }}
                                                @if($n->isBelumDibaca())
                                                <span class="badge bg-danger ms-2">Baru</span>
                                                @endif
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i> {{ $n->waktu_formatted }}
                                            </small>
                                        </div>
                                    </div>
                                    <p class="mb-0 ms-5 ps-2">{{ $n->pesan }}</p>
                                </div>
                                @if($n->isBelumDibaca())
                                <div class="ms-3">
                                    <form action="{{ route('orangtua.notifikasi.read', $n->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Tandai dibaca">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notifikasi->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection