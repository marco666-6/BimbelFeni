<!-- View: orangtua/paket-belajar.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Paket Belajar')
@section('page-title', 'Paket Belajar')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-info-circle text-primary"></i> Informasi Pembelian Paket</h5>
                <p class="text-muted mb-0">Pilih paket belajar yang sesuai untuk anak Anda, kemudian upload bukti pembayaran untuk verifikasi admin.</p>
            </div>
        </div>

        <!-- Paket SD -->
        @if($paketSD->isNotEmpty())
        <h5 class="mb-3"><i class="bi bi-mortarboard text-primary"></i> Paket SD</h5>
        <div class="row mb-4">
            @foreach($paketSD as $paket)
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $paket->nama_paket }}</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-primary mb-3">{{ $paket->harga_formatted }}</h3>
                        <p class="text-muted">{{ $paket->deskripsi }}</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success"></i> Durasi: {{ $paket->durasi_bulan }} Bulan</li>
                            <li><i class="bi bi-check-circle text-success"></i> Jenjang: {{ $paket->jenjang }}</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-primary w-100" onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                            <i class="bi bi-cart-plus"></i> Beli Paket
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Paket SMP -->
        @if($paketSMP->isNotEmpty())
        <h5 class="mb-3"><i class="bi bi-mortarboard text-info"></i> Paket SMP</h5>
        <div class="row mb-4">
            @foreach($paketSMP as $paket)
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">{{ $paket->nama_paket }}</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="text-info mb-3">{{ $paket->harga_formatted }}</h3>
                        <p class="text-muted">{{ $paket->deskripsi }}</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success"></i> Durasi: {{ $paket->durasi_bulan }} Bulan</li>
                            <li><i class="bi bi-check-circle text-success"></i> Jenjang: {{ $paket->jenjang }}</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-info w-100" onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                            <i class="bi bi-cart-plus"></i> Beli Paket
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Paket Kombo -->
        @if($paketKombo->isNotEmpty())
        <h5 class="mb-3"><i class="bi bi-mortarboard text-success"></i> Paket Kombo (SD & SMP)</h5>
        <div class="row mb-4">
            @foreach($paketKombo as $paket)
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">{{ $paket->nama_paket }}</h5>
                        <small><i class="bi bi-star-fill"></i> Recommended</small>
                    </div>
                    <div class="card-body">
                        <h3 class="text-success mb-3">{{ $paket->harga_formatted }}</h3>
                        <p class="text-muted">{{ $paket->deskripsi }}</p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success"></i> Durasi: {{ $paket->durasi_bulan }} Bulan</li>
                            <li><i class="bi bi-check-circle text-success"></i> Jenjang: {{ $paket->jenjang }}</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-success w-100" onclick="showBeliModal({{ $paket->id }}, '{{ $paket->nama_paket }}', '{{ $paket->harga_formatted }}', '{{ $paket->jenjang }}')">
                            <i class="bi bi-cart-plus"></i> Beli Paket
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Modal Beli Paket -->
<div class="modal fade" id="beliModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('orangtua.paket-belajar.beli') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Beli Paket Belajar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="paket_id" id="paket_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Paket</label>
                        <input type="text" class="form-control" id="paket_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Pembayaran</label>
                        <input type="text" class="form-control" id="paket_price" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Anak <span class="text-danger">*</span></label>
                        <select name="siswa_id" class="form-select" id="siswa_select" required>
                            <option value="">-- Pilih Anak --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}" data-jenjang="{{ $s->jenjang }}">
                                {{ $s->nama_lengkap }} ({{ $s->jenjang }} - Kelas {{ $s->kelas }})
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih anak yang akan mengikuti paket ini</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                        <small class="text-muted">Upload bukti transfer (JPG, PNG, max 2MB)</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informasi Rekening:</strong><br>
                        Silakan transfer ke rekening yang tersedia di halaman kontak atau hubungi admin untuk info rekening.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload Bukti Bayar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let paketJenjang = '';
    
    function showBeliModal(id, name, price, jenjang) {
        paketJenjang = jenjang;
        $('#paket_id').val(id);
        $('#paket_name').val(name);
        $('#paket_price').val(price);
        
        // Filter siswa berdasarkan jenjang paket
        filterSiswaByJenjang(jenjang);
        
        $('#beliModal').modal('show');
    }

    function filterSiswaByJenjang(jenjang) {
        const select = document.getElementById('siswa_select');
        const options = select.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
                return;
            }
            
            const siswaJenjang = option.getAttribute('data-jenjang');
            
            // Jika paket untuk SD & SMP, tampilkan semua
            if (jenjang === 'SD & SMP') {
                option.style.display = 'block';
            } else {
                // Tampilkan hanya yang sesuai jenjang
                option.style.display = siswaJenjang === jenjang ? 'block' : 'none';
            }
        });
        
        // Reset pilihan
        select.value = '';
    }
</script>
@endpush
@endsection