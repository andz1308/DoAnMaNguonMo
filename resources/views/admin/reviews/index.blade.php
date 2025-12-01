@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')
@section('page-title', 'Quản lý đánh giá')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <!-- Header -->
        <div class="card-header bg-gradient text-white py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-star me-2"></i>Quản lý đánh giá sản phẩm
            </h5>
        </div>

        <div class="card-body p-4">
            <!-- Search and Filter -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchReview" 
                            placeholder="Tìm theo sản phẩm, người dùng..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterRating">
                        <option value="">Tất cả đánh giá</option>
                        <option value="5" @selected(request('rating') == '5')>⭐ 5 sao</option>
                        <option value="4" @selected(request('rating') == '4')>⭐ 4 sao</option>
                        <option value="3" @selected(request('rating') == '3')>⭐ 3 sao</option>
                        <option value="2" @selected(request('rating') == '2')>⭐ 2 sao</option>
                        <option value="1" @selected(request('rating') == '1')>⭐ 1 sao</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterProduct">
                        <option value="">Tất cả sản phẩm</option>
                        @foreach($products ?? [] as $product)
                            <option value="{{ $product->id }}" @selected(request('product') == $product->id)>
                                {{ Str::limit($product->name, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" onclick="searchReviews()">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-3">
                            <div class="mb-2">
                                <i class="fas fa-comments fa-2x text-primary opacity-75"></i>
                            </div>
                            <h3 class="mb-1 fw-bold text-primary">{{ $totalReviews ?? 0 }}</h3>
                            <small class="text-muted">Tổng đánh giá</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-3">
                            <div class="mb-2">
                                <i class="fas fa-star fa-2x text-warning opacity-75"></i>
                            </div>
                            <h3 class="mb-1 fw-bold text-warning">{{ number_format($averageRating ?? 0, 1) }}</h3>
                            <small class="text-muted">Đánh giá TB</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-3">
                            <div class="mb-2">
                                <i class="fas fa-trophy fa-2x text-success opacity-75"></i>
                            </div>
                            <h3 class="mb-1 fw-bold text-success">{{ $fiveStarReviews ?? 0 }}</h3>
                            <small class="text-muted">5 sao</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-3">
                            <div class="mb-2">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger opacity-75"></i>
                            </div>
                            <h3 class="mb-1 fw-bold text-danger">{{ $lowRatingReviews ?? 0 }}</h3>
                            <small class="text-muted">1-2 sao</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label text-muted" for="selectAll">
                        Chọn tất cả
                    </label>
                </div>
                <button class="btn btn-outline-danger btn-sm" onclick="deleteSelected()">
                    <i class="fas fa-trash me-1"></i>Xóa đã chọn
                </button>
            </div>

            <!-- Reviews Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">
                                <input type="checkbox" id="selectAllTable">
                            </th>
                            <th width="60" class="text-center">ID</th>
                            <th>Sản phẩm</th>
                            <th>Người đánh giá</th>
                            <th width="150">Đánh giá</th>
                            <th>Nội dung</th>
                            <th width="100" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews ?? [] as $review)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="review-checkbox" value="{{ $review->id }}">
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">#{{ $review->id }}</span>
                            </td>
                            <td>
                                @php
                                    $imageName = $review->sanPham->images->first()->name
                                        ?? $review->sanPham->image
                                        ?? null;
                                    $imageUrl = $imageName ? asset('uploads/images/san_pham/' . $imageName) : null;
                                @endphp
                                <div class="d-flex align-items-center">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $review->sanPham->name ?? '' }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" 
                                             class="me-3 shadow-sm">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center me-3"
                                             style="width: 50px; height: 50px; border-radius: 8px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ Str::limit($review->sanPham->name ?? 'N/A', 30) }}</div>
                                        <small class="text-muted">ID: {{ $review->san_pham_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $review->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">
                                        <i class="far fa-envelope me-1"></i>{{ $review->user->email ?? 'N/A' }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= ($review->vote ?? 0) ? 'text-warning' : 'text-muted' }}" 
                                               style="font-size: 0.9rem;"></i>
                                        @endfor
                                    </div>
                                    <span class="badge 
                                        @if(($review->vote ?? 0) >= 4) bg-success
                                        @elseif(($review->vote ?? 0) >= 3) bg-warning
                                        @else bg-danger
                                        @endif">
                                        {{ $review->vote ?? 0 }}/5
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="max-width: 300px;" class="text-muted">
                                    {{ Str::limit($review->noi_dung ?? 'Không có nội dung', 60) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info me-1" onclick="viewReview({{ $review->id }})" 
                                        data-bs-toggle="tooltip" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteReview({{ $review->id }})" 
                                        data-bs-toggle="tooltip" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25 d-block"></i>
                                <h6 class="text-muted">Chưa có đánh giá nào</h6>
                                <p class="text-muted mb-0 small">Đánh giá từ khách hàng sẽ hiển thị ở đây</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(isset($reviews) && $reviews->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} trong tổng số {{ $reviews->total() }} đánh giá
                </div>
                <div class="pagination-wrapper">
                    {{ $reviews->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- View Review Modal -->
<div class="modal fade" id="viewReviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-info-circle me-2"></i>Chi tiết đánh giá
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="reviewDetailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Fix pagination size */
    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }
    
    .pagination-wrapper .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination-wrapper .page-item:first-child .page-link,
    .pagination-wrapper .page-item:last-child .page-link {
        border-radius: 0.25rem;
    }

    /* Input group styling */
    .input-group-text.border-end-0 {
        background-color: #f8f9fa;
    }
    
    .form-control.border-start-0:focus {
        border-left: 1px solid #86b7fe;
    }

    /* Table hover effect */
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
</style>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function searchReviews() {
        const search = $('#searchReview').val();
        const rating = $('#filterRating').val();
        const product = $('#filterProduct').val();
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (rating) params.append('rating', rating);
        if (product) params.append('product', product);
        
        window.location.href = '{{ route("admin.reviews.index") }}' + (params.toString() ? '?' + params.toString() : '');
    }

    function viewReview(id) {
        $('#viewReviewModal').modal('show');
        $.ajax({
            url: `/admin/reviews/${id}`,
            method: 'GET',
            success: function(response) {
                $('#reviewDetailContent').html(response);
            },
            error: function() {
                $('#reviewDetailContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Không thể tải thông tin đánh giá. Vui lòng thử lại.
                    </div>
                `);
            }
        });
    }

    function deleteReview(id) {
        if (confirm('Bạn có chắc muốn xóa đánh giá này?')) {
            $.ajax({
                url: `/admin/reviews/${id}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Không thể xóa đánh giá. Vui lòng thử lại.');
                }
            });
        }
    }

    // Select all checkboxes
    $('#selectAll, #selectAllTable').change(function() {
        const checked = $(this).prop('checked');
        $('.review-checkbox').prop('checked', checked);
        $('#selectAll, #selectAllTable').prop('checked', checked);
    });

    // Search on Enter key
    $('#searchReview').keypress(function(e) {
        if (e.which === 13) {
            searchReviews();
        }
    });

    // Bulk actions
    function deleteSelected() {
        const selected = $('.review-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('Vui lòng chọn ít nhất một đánh giá');
            return;
        }

        if (confirm(`Bạn có chắc muốn xóa ${selected.length} đánh giá đã chọn?`)) {
            $.ajax({
                url: '/admin/reviews/bulk-delete',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selected
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Không thể xóa các đánh giá đã chọn. Vui lòng thử lại.');
                }
            });
        }
    }
</script>
@endpush
@endsection