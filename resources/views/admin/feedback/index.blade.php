@extends('admin.layouts.app')

@section('title', 'Quản lý phản hồi')
@section('page-title', 'Quản lý phản hồi')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-comments me-2"></i>Danh sách phản hồi khách hàng</h4>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-5">
                <input type="text" class="form-control" id="searchFeedback" placeholder="Tìm kiếm theo chủ đề, người gửi...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Tất cả trạng thái</option>
                    <option value="0">Chờ xử lý</option>
                    <option value="1">Đã xử lý</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterType">
                    <option value="">Tất cả loại</option>
                    <option value="complain">Khiếu nại</option>
                    <option value="suggestion">Đề xuất</option>
                    <option value="question">Câu hỏi</option>
                    <option value="other">Khác</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchFeedback()">
                    <i class="fas fa-search me-2"></i>Tìm kiếm
                </button>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card primary">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $totalFeedback ?? 0 }}</h3>
                        <small class="text-muted">Tổng phản hồi</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card warning">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $pendingFeedback ?? 0 }}</h3>
                        <small class="text-muted">Chờ xử lý</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card success">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $processedFeedback ?? 0 }}</h3>
                        <small class="text-muted">Đã xử lý</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card danger">
                    <div class="text-center">
                        <h3 class="mb-0">{{ $todayFeedback ?? 0 }}</h3>
                        <small class="text-muted">Hôm nay</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>ID</th>
                        <th>Người gửi</th>
                        <th>Chủ đề</th>
                        <th>Loại</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th width="150" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks ?? [] as $feedback)
                    <tr class="{{ ($feedback->trang_thai ?? 0) == 0 ? 'table-warning' : '' }}">
                        <td>
                            <input type="checkbox" class="feedback-checkbox" value="{{ $feedback->id }}">
                        </td>
                        <td>{{ $feedback->id }}</td>
                        <td>
                            <div>
                                <strong>{{ $feedback->user->name ?? 'Khách' }}</strong>
                                <br>
                                <small class="text-muted">{{ $feedback->user->email ?? $feedback->email ?? '' }}</small>
                            </div>
                        </td>
                        <td>
                            <strong>{{ Str::limit($feedback->chu_de ?? 'N/A', 40) }}</strong>
                        </td>
                        <td>
                            @php
                                $typeClass = 'secondary';
                                $typeText = 'Khác';
                                switch($feedback->loai ?? 'other') {
                                    case 'complain':
                                        $typeClass = 'danger';
                                        $typeText = 'Khiếu nại';
                                        break;
                                    case 'suggestion':
                                        $typeClass = 'info';
                                        $typeText = 'Đề xuất';
                                        break;
                                    case 'question':
                                        $typeClass = 'primary';
                                        $typeText = 'Câu hỏi';
                                        break;
                                }
                            @endphp
                            <span class="badge bg-{{ $typeClass }}">{{ $typeText }}</span>
                        </td>
                        <td>
                            <div style="max-width: 300px;">
                                {{ Str::limit($feedback->noi_dung ?? 'Không có nội dung', 60) }}
                            </div>
                        </td>
                        <td>
                            @if(($feedback->trang_thai ?? 0) == 0)
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Chờ xử lý
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>Đã xử lý
                                </span>
                            @endif
                        </td>
                        <td>{{ $feedback->created_at ? $feedback->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" onclick="viewFeedback({{ $feedback->id }})" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if(($feedback->trang_thai ?? 0) == 0)
                                <button class="btn btn-sm btn-success" onclick="markAsProcessed({{ $feedback->id }})" title="Đánh dấu đã xử lý">
                                    <i class="fas fa-check"></i>
                                </button>
                            @else
                                <button class="btn btn-sm btn-warning" onclick="markAsPending({{ $feedback->id }})" title="Đánh dấu chờ xử lý">
                                    <i class="fas fa-undo"></i>
                                </button>
                            @endif
                            <button class="btn btn-sm btn-danger" onclick="deleteFeedback({{ $feedback->id }})" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Chưa có phản hồi nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($feedbacks) && $feedbacks->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Hiển thị {{ $feedbacks->firstItem() }} - {{ $feedbacks->lastItem() }} / {{ $feedbacks->total() }} phản hồi
            </div>
            <div>
                {{ $feedbacks->links() }}
            </div>
        </div>
        @endif

        <!-- Bulk Actions -->
        <div class="mt-3">
            <button class="btn btn-success me-2" onclick="markSelectedAsProcessed()">
                <i class="fas fa-check me-2"></i>Đánh dấu đã xử lý
            </button>
            <button class="btn btn-danger" onclick="deleteSelected()">
                <i class="fas fa-trash me-2"></i>Xóa đã chọn
            </button>
        </div>
    </div>
</div>

<!-- View Feedback Modal -->
<div class="modal fade" id="viewFeedbackModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết phản hồi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="feedbackDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success" onclick="replyFeedback()">
                    <i class="fas fa-reply me-2"></i>Trả lời
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function searchFeedback() {
        const search = $('#searchFeedback').val();
        const status = $('#filterStatus').val();
        const type = $('#filterType').val();
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (status !== '') params.append('status', status);
        if (type) params.append('type', type);
        
        window.location.href = '{{ route("admin.feedback.index") }}' + (params.toString() ? '?' + params.toString() : '');
    }

    function viewFeedback(id) {
        $.ajax({
            url: `/admin/feedback/${id}`,
            method: 'GET',
            success: function(response) {
                $('#feedbackDetailContent').html(response);
                $('#viewFeedbackModal').modal('show');
            }
        });
    }

    function markAsProcessed(id) {
        $.ajax({
            url: `/admin/feedback/${id}/mark-processed`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function markAsPending(id) {
        $.ajax({
            url: `/admin/feedback/${id}/mark-pending`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    function deleteFeedback(id) {
        if (confirm('Bạn có chắc muốn xóa phản hồi này?')) {
            $.ajax({
                url: `/admin/feedback/${id}`,
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

    function replyFeedback() {
        // Implement reply functionality
        alert('Chức năng trả lời phản hồi sẽ được triển khai trong phiên bản tiếp theo');
    }

    // Select all checkboxes
    $('#selectAll').change(function() {
        $('.feedback-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Search on Enter key
    $('#searchFeedback').keypress(function(e) {
        if (e.which === 13) {
            searchFeedback();
        }
    });

    // Bulk actions
    function markSelectedAsProcessed() {
        const selected = $('.feedback-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('Vui lòng chọn ít nhất một phản hồi');
            return;
        }

        $.ajax({
            url: '/admin/feedback/bulk-mark-processed',
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

    function deleteSelected() {
        const selected = $('.feedback-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('Vui lòng chọn ít nhất một phản hồi');
            return;
        }

        if (confirm(`Bạn có chắc muốn xóa ${selected.length} phản hồi đã chọn?`)) {
            $.ajax({
                url: '/admin/feedback/bulk-delete',
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
