<!-- View: orangtua/feedback.blade.php -->
@extends('layouts.ortusiswa')

@section('title', 'Feedback')
@section('page-title', 'Feedback & Komunikasi')

@push('styles')
<style>
    .feedback-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    
    .feedback-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.4;
    }
    
    .form-card-enhanced {
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
    }
    
    .form-card-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .form-card-enhanced:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
        border-color: var(--primary-blue);
    }
    
    .feedback-card {
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .feedback-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        transition: all 0.3s ease;
    }
    
    .feedback-card.status-baru::before {
        background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
    }
    
    .feedback-card.status-dibaca::before {
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }
    
    .feedback-card:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-blue);
    }
    
    .feedback-message-box {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-radius: 15px;
        padding: 1.2rem;
        border: 2px solid #bfdbfe;
        position: relative;
    }
    
    .feedback-message-box::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: -8px;
        width: 16px;
        height: 16px;
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        border-left: 2px solid #bfdbfe;
        border-top: 2px solid #bfdbfe;
        transform: rotate(45deg);
    }
    
    .reply-box {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-radius: 15px;
        padding: 1.2rem;
        border: 2px solid #6ee7b7;
        position: relative;
    }
    
    .reply-box::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: -8px;
        width: 16px;
        height: 16px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-left: 2px solid #6ee7b7;
        border-top: 2px solid #6ee7b7;
        transform: rotate(45deg);
    }
    
    .waiting-reply-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 2px solid #fbbf24;
        border-radius: 50px;
        padding: 0.5rem 1.2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .student-badge {
        background: white;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-weight: 600;
    }
    
    .student-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #667eea;
    }
    
    .timestamp-badge {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50px;
        padding: 0.3rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #64748b;
    }
    
    .form-control-enhanced, .form-select-enhanced {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .form-control-enhanced:focus, .form-select-enhanced:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
    }
    
    .textarea-enhanced {
        resize: none;
        min-height: 140px;
    }
    
    .submit-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 0.9rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        padding: 0.6rem 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #64748b;
    }
    
    .filter-tab:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .stats-mini {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .stat-mini-item {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .stat-mini-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .stat-mini-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    .icon-gradient-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .icon-gradient-2 {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .icon-gradient-3 {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .feedback-search {
        border-radius: 50px;
        border: 2px solid #e2e8f0;
        padding: 0.7rem 1.5rem 0.7rem 3rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .feedback-search:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
    }
    
    .search-wrapper {
        position: relative;
    }
    
    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
    }
</style>
@endpush

@section('content')
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card feedback-header-card border-0">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h4 class="text-white mb-2">
                            <i class="bi bi-chat-left-text-fill"></i> Feedback & Komunikasi
                        </h4>
                        <p class="text-white opacity-90 mb-0">
                            Sampaikan feedback atau kendala mengenai perkembangan anak Anda
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-mini justify-content-md-end">
                            <div class="stat-mini-item">
                                <div class="stat-mini-icon icon-gradient-1">
                                    <i class="bi bi-chat-dots-fill text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total</small>
                                    <strong class="text-dark">{{ $feedback->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Form Kirim Feedback -->
    <div class="col-lg-4 mb-4">
        <div class="card form-card-enhanced border-0 h-100">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold">
                    <i class="bi bi-send text-primary"></i> Kirim Feedback Baru
                </h5>
                
                <form action="{{ route('orangtua.feedback.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-circle text-primary"></i> Pilih Anak
                            <span class="text-danger">*</span>
                        </label>
                        <select name="siswa_id" class="form-select form-select-enhanced" required>
                            <option value="">-- Pilih Anak --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->nama_lengkap }} - {{ $s->jenjang }} Kelas {{ $s->kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-chat-text text-primary"></i> Isi Feedback
                            <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            name="isi_feedback" 
                            class="form-control form-control-enhanced textarea-enhanced" 
                            placeholder="Contoh: Saya ingin berkonsultasi mengenai perkembangan nilai matematika anak saya yang menurun..." 
                            required></textarea>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Sampaikan feedback, pertanyaan, atau kendala yang Anda alami
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary submit-button w-100">
                        <i class="bi bi-send-fill"></i> Kirim Feedback
                    </button>
                </form>
                
                <div class="mt-4 p-3 rounded" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    <small class="text-dark">
                        <i class="bi bi-lightbulb-fill text-warning"></i>
                        <strong>Tips:</strong> Feedback Anda akan dijawab oleh admin dalam 1x24 jam
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Feedback -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0" style="border-radius: 20px;">
            <div class="card-body p-4">
                <!-- Header with Filters -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history text-primary"></i> Riwayat Feedback
                    </h5>
                    <span class="badge bg-primary">{{ $feedback->count() }} Feedback</span>
                </div>

                <!-- Search & Filter -->
                <div class="search-wrapper mb-3">
                    <i class="bi bi-search search-icon"></i>
                    <input 
                        type="text" 
                        id="searchFeedback" 
                        class="form-control feedback-search" 
                        placeholder="Cari feedback...">
                </div>

                <div class="filter-tabs">
                    <div class="filter-tab active" data-filter="all">
                        <i class="bi bi-grid-fill"></i> Semua
                    </div>
                    <div class="filter-tab" data-filter="baru">
                        <i class="bi bi-exclamation-circle"></i> Belum Dibaca
                    </div>
                    <div class="filter-tab" data-filter="dibaca">
                        <i class="bi bi-check-circle"></i> Sudah Dibaca
                    </div>
                    <div class="filter-tab" data-filter="replied">
                        <i class="bi bi-reply-fill"></i> Sudah Dibalas
                    </div>
                </div>

                <!-- Feedback List -->
                <div id="feedbackContainer">
                    @forelse($feedback as $f)
                    <div class="feedback-card status-{{ $f->status }} animate-fade-in" 
                         data-status="{{ $f->status }}"
                         data-replied="{{ $f->isSudahDibalas() ? 'true' : 'false' }}"
                         data-content="{{ strtolower($f->isi_feedback . ' ' . $f->siswa->nama_lengkap) }}">
                        <div class="card-body p-4">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="student-badge">
                                        <img src="{{ $f->siswa->user->foto_profil_url }}" 
                                             alt="{{ $f->siswa->nama_lengkap }}" 
                                             class="student-avatar">
                                        <span>{{ $f->siswa->nama_lengkap }}</span>
                                    </span>
                                    <span class="badge bg-{{ $f->status_badge_color }}">
                                        <i class="bi bi-{{ $f->isBaru() ? 'exclamation-circle' : 'check-circle' }}"></i>
                                        {{ $f->status_label }}
                                    </span>
                                </div>
                                <span class="timestamp-badge">
                                    <i class="bi bi-clock"></i>
                                    {{ $f->tanggal_feedback->locale('id')->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Feedback Message -->
                            <div class="feedback-message-box mb-3">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <i class="bi bi-chat-left-quote-fill text-primary"></i>
                                    <strong class="text-dark">Feedback Anda:</strong>
                                </div>
                                <p class="mb-0 text-dark" style="line-height: 1.6;">
                                    {{ $f->isi_feedback }}
                                </p>
                            </div>

                            <!-- Reply or Waiting -->
                            @if($f->isSudahDibalas())
                                <div class="reply-box">
                                    <div class="d-flex align-items-start gap-2 mb-2">
                                        <i class="bi bi-reply-fill text-success"></i>
                                        <strong class="text-success">Balasan Admin:</strong>
                                    </div>
                                    <p class="mb-0 text-dark" style="line-height: 1.6;">
                                        {{ $f->balasan_admin }}
                                    </p>
                                </div>
                            @else
                                <div class="text-center py-2">
                                    <span class="waiting-reply-badge">
                                        <i class="bi bi-hourglass-split"></i>
                                        <span>Menunggu balasan admin...</span>
                                    </span>
                                </div>
                            @endif

                            <!-- Footer Info -->
                            <div class="mt-3 pt-3" style="border-top: 1px solid #e2e8f0;">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    Dikirim pada {{ $f->tanggal_feedback_formatted }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="bi bi-chat-left-dots"></i>
                        <h5 class="mt-3 text-muted">Belum Ada Feedback</h5>
                        <p class="text-muted mb-4">
                            Anda belum mengirimkan feedback apapun.<br>
                            Gunakan form di samping untuk mengirim feedback pertama Anda.
                        </p>
                    </div>
                    @endforelse
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="empty-state d-none">
                    <i class="bi bi-search"></i>
                    <h5 class="mt-3 text-muted">Tidak Ada Hasil</h5>
                    <p class="text-muted mb-0">Tidak ditemukan feedback yang sesuai</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $feedbackItems = $('.feedback-card');
    const $noResults = $('#noResults');
    const $searchInput = $('#searchFeedback');
    const $filterTabs = $('.filter-tab');
    
    let currentFilter = 'all';
    
    // Animate cards on load
    $('.feedback-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Filter Tabs
    $filterTabs.on('click', function() {
        $filterTabs.removeClass('active');
        $(this).addClass('active');
        currentFilter = $(this).data('filter');
        applyFilters();
    });
    
    // Search
    $searchInput.on('keyup', debounce(function() {
        applyFilters();
    }, 300));
    
    function applyFilters() {
        const searchTerm = $searchInput.val().toLowerCase();
        let visibleCount = 0;
        
        $feedbackItems.each(function() {
            const $item = $(this);
            const status = $item.data('status');
            const replied = $item.data('replied');
            const content = $item.data('content');
            
            let show = true;
            
            // Search filter
            if (searchTerm && !content.includes(searchTerm)) {
                show = false;
            }
            
            // Status filter
            if (currentFilter === 'baru' && status !== 'baru') {
                show = false;
            } else if (currentFilter === 'dibaca' && status !== 'dibaca') {
                show = false;
            } else if (currentFilter === 'replied' && replied !== 'true') {
                show = false;
            }
            
            if (show) {
                $item.removeClass('d-none').addClass('animate-fade-in');
                visibleCount++;
            } else {
                $item.addClass('d-none');
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0 && $feedbackItems.length > 0) {
            $('#feedbackContainer').addClass('d-none');
            $noResults.removeClass('d-none');
        } else {
            $('#feedbackContainer').removeClass('d-none');
            $noResults.addClass('d-none');
        }
    }
    
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Form validation enhancement
    $('form').on('submit', function(e) {
        const siswaId = $('select[name="siswa_id"]').val();
        const feedback = $('textarea[name="isi_feedback"]').val().trim();
        
        if (!siswaId) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Anak',
                text: 'Silakan pilih anak terlebih dahulu',
                confirmButtonColor: '#667eea'
            });
            return false;
        }
        
        if (!feedback || feedback.length < 10) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Feedback Terlalu Pendek',
                text: 'Mohon tulis feedback minimal 10 karakter',
                confirmButtonColor: '#667eea'
            });
            return false;
        }
    });
    
    // Character counter for textarea
    const $textarea = $('textarea[name="isi_feedback"]');
    const maxLength = 1000;
    
    $textarea.after(`<small class="text-muted d-block mt-1"><span id="charCount">0</span>/${maxLength} karakter</small>`);
    
    $textarea.on('input', function() {
        const length = $(this).val().length;
        $('#charCount').text(length);
        
        if (length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
            $('#charCount').text(maxLength);
        }
    });
});
</script>
@endpush