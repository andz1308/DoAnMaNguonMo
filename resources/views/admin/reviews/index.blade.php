@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')
@section('page-title', 'Quản lý đánh giá')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-star me-2"></i>Danh sách đánh giá sản phẩm</h4>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchReview" placeholder="Tìm kiếm theo sản phẩm, người dùng..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRating">
                    <option value="">Tất cả đánh giá</option>
                    <option value="5" @selected(request('rating') == '5')>5 sao</option>
                    <option value="4" @selected(request('rating') == '4')>4 sao</option>
                    <option value="3" @selected(request('rating') == '3')>3 sao</option>
                    <option value="2" @selected(request('rating') == '2')>2 sao</option>
                    <option value="1" @selected(request('rating') == '1')>1 sao</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterProduct">
                    <option value="">Tất cả sản phẩm</option>
                    @foreach($products ?? [] as $product)
                        <option value="{{ $product->id }}" @selected(request('product') == $product->id)>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchReviews()">
                    <i class="fas fa-search me-2"></i>Tìm kiếm
                </button>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card primary">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $totalReviews ?? 0 }}</h3>
                        <small class="text-muted">Tổng đánh giá</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card success">
                    <div class="text-center">
                        <h3 class="mb-0">{{ number_format($averageRating ?? 0, 1) }}</h3>
                        <small class="text-muted">Đánh giá trung bình</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card warning">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $fiveStarReviews ?? 0 }}</h3>
                        <small class="text-muted">5 sao</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card danger">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $lowRatingReviews ?? 0 }}</h3>
                        <small class="text-muted">1-2 sao</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Người đánh giá</th>
                        <th>Đánh giá</th>
                        <th>Nội dung</th>
                        <th width="120" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews ?? [] as $review)
                    <tr>
                        <td>
                            <input type="checkbox" class="review-checkbox" value="{{ $review->id }}">
                        </td>
                        <td>{{ $review->id }}</td>
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
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;" class="me-2">
                                    @endif
                                    <div>
                                        <strong>{{ Str::limit($review->sanPham->name ?? 'N/A', 30) }}</strong>
                                    </div>
                                </div>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $review->user->name ?? 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">{{ $review->user->email ?? '' }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($review->vote ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </span>
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
                            <div style="max-width: 300px;">
                                {{ Str::limit($review->noi_dung ?? 'Không có nội dung', 60) }}
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" onclick="viewReview({{ $review->id }})" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteReview({{ $review->id }})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Chưa có đánh giá nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($reviews) && $reviews->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Hiển thị {{ $reviews->firstItem() }} - {{ $reviews->lastItem() }} / {{ $reviews->total() }} đánh giá
            </div>
            <div>
                {{ $reviews->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- View Review Modal -->
<div class="modal fade" id="viewReviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đánh giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reviewDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
        $.ajax({
            url: `/admin/reviews/${id}`,
            method: 'GET',
            success: function(response) {
                $('#reviewDetailContent').html(response);
                $('#viewReviewModal').modal('show');
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
                }
            });
        }
    }

    // Select all checkboxes
    $('#selectAll').change(function() {
        $('.review-checkbox').prop('checked', $(this).prop('checked'));
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
                }
            });
        }
    }
</script>
@endpush
@endsection
