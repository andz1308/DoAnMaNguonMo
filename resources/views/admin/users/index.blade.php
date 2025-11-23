@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')

@section('content')
@push('styles')
<style>
    /* Custom CSS cho giao diện đẹp hơn */
    .card-box {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        border: none;
        padding: 20px;
    }
    .table thead th {
        border-top: none;
        border-bottom: 1px solid #f1f5f7;
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 12px 15px;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 12px 15px;
        border-bottom: 1px solid #f1f5f7;
        color: #333;
    }
    /* Avatar tròn có màu */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
        font-size: 16px;
        margin-right: 10px;
    }
    /* Badge trạng thái dạng Soft (Nền nhạt chữ đậm) */
    .badge-soft-success { background-color: rgba(25, 135, 84, 0.1); color: #198754; padding: 6px 12px; border-radius: 50px; font-weight: 500;}
    .badge-soft-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 6px 12px; border-radius: 50px; font-weight: 500;}
    .badge-soft-info { background-color: rgba(13, 202, 240, 0.1); color: #0dcaf0; padding: 6px 12px; border-radius: 50px; font-weight: 500;}
    
    /* Nút thao tác */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: none;
        transition: all 0.2s;
        margin: 0 2px;
    }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 3px 5px rgba(0,0,0,0.1); }
    .btn-light-primary { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
    .btn-light-warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .btn-light-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .btn-light-success { background: rgba(25, 135, 84, 0.1); color: #198754; }

    /* Thanh tìm kiếm */
    .search-box .form-control, .search-box .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
    }
    .search-box .form-control:focus { box-shadow: none; border-color: #0d6efd; }
</style>
@endpush

<div class="container-fluid">
    <div class="card-box">
        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                    <div>
                        <strong>Đã xảy ra lỗi:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-bold text-dark">Danh sách người dùng</h4>
                <p class="text-muted mb-0 font-13">Quản lý thông tin và quyền truy cập hệ thống</p>
            </div>
            <button class="btn btn-primary px-4 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Thêm mới
            </button>
        </div>

        <div class="row g-3 mb-4 search-box">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 rounded-start-3 ps-3 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 rounded-end-3" id="searchUser" 
                        placeholder="Tìm tên, email, sđt..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select rounded-3" id="filterRole">
                    <option value="">-- Chọn vai trò --</option>
                    @foreach($roles ?? [] as $role)
                        <option value="{{ $role->id }}" @selected(request('role') == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select rounded-3" id="filterStatus">
                    <option value="">-- Trạng thái --</option>
                    <option value="1" @selected(request('status') === '1')>Hoạt động</option>
                    <option value="0" @selected(request('status') === '0')>Bị khóa</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark w-100 rounded-3 py-2" onclick="searchUsers()">
                    Lọc dữ liệu
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="40" class="text-center">
                            <div class="form-check d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Thành viên</th>
                        <th>Liên hệ</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                    @php
                        // Tạo màu ngẫu nhiên cho avatar dựa trên ID
                        $colors = ['#6f42c1', '#fd7e14', '#20c997', '#0d6efd', '#e83e8c'];
                        $color = $colors[$user->id % count($colors)];
                    @endphp
                    <tr>
                        <td class="text-center">
                            <div class="form-check d-flex justify-content-center">
                                <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}">
                            </div>
                        </td>
                        <td class="text-muted fw-bold">#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle shadow-sm" style="background-color: {{ $color }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $user->name }}</h6>
                                    <small class="text-muted">Created: {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-dark mb-1"><i class="far fa-envelope me-2 text-muted"></i>{{ $user->email }}</span>
                                <span class="text-muted font-13"><i class="fas fa-phone me-2 text-muted"></i>{{ $user->dien_thoai ?? '---' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-soft-info">{{ $user->role->name ?? 'Thành viên' }}</span>
                        </td>
                        <td>
                            @if(($user->trang_thai ?? 1) == 1)
                                <span class="badge badge-soft-success"><i class="fas fa-check-circle me-1"></i>Hoạt động</span>
                            @else
                                <span class="badge badge-soft-danger"><i class="fas fa-ban me-1"></i>Bị khóa</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn-action btn-light-primary" onclick="viewUser({{ $user->id }})" data-bs-toggle="tooltip" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-action btn-light-warning" onclick="editUser({{ $user->id }})" data-bs-toggle="tooltip" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </button>
                            @if(($user->trang_thai ?? 1) == 1)
                                <button class="btn-action btn-light-danger" onclick="toggleUserStatus({{ $user->id }}, 0)" data-bs-toggle="tooltip" title="Khóa tài khoản">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @else
                                <button class="btn-action btn-light-success" onclick="toggleUserStatus({{ $user->id }}, 1)" data-bs-toggle="tooltip" title="Mở khóa">
                                    <i class="fas fa-unlock"></i>
                                </button>
                            @endif
                            <button class="btn-action btn-light-danger" onclick="deleteUser({{ $user->id }})" data-bs-toggle="tooltip" title="Xóa vĩnh viễn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="bg-light rounded-circle p-4 mb-3">
                                    <i class="fas fa-user-slash fa-3x text-muted"></i>
                                </div>
                                <h5 class="text-muted">Không tìm thấy dữ liệu</h5>
                                <p class="text-muted mb-0">Vui lòng thử lại với từ khóa khác</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($users) && $users->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="text-muted font-13">
                Hiển thị <strong>{{ $users->firstItem() }} - {{ $users->lastItem() }}</strong> trong tổng số <strong>{{ $users->total() }}</strong> bản ghi
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i>Thêm người dùng mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Nhập họ tên đầy đủ">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="example@email.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Số điện thoại</label>
                            <input type="text" class="form-control" name="dien_thoai" value="{{ old('dien_thoai') }}" placeholder="09xxxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Giới tính</label>
                            <select class="form-select" name="gioi_tinh">
                                <option value="">-- Chọn giới tính --</option>
                                <option value="Nam" @selected(old('gioi_tinh') === 'Nam')>Nam</option>
                                <option value="Nu" @selected(old('gioi_tinh') === 'Nu')>Nữ</option>
                                <option value="Khac" @selected(old('gioi_tinh') === 'Khac')>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required placeholder="Nhập mật khẩu">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Vai trò <span class="text-danger">*</span></label>
                            <select class="form-select" name="role_id" required>
                                <option value="">-- Chọn vai trò --</option>
                                @foreach($roles ?? [] as $role)
                                    <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">Địa chỉ</label>
                            <textarea class="form-control" name="dia_chi" rows="2" placeholder="Nhập địa chỉ liên hệ">{{ old('dia_chi') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary px-4">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Khởi tạo tooltip của Bootstrap 5
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function searchUsers() {
        const search = $('#searchUser').val();
        const role = $('#filterRole').val();
        const status = $('#filterStatus').val();
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (role) params.append('role', role);
        if (status !== '') params.append('status', status);
        
        window.location.href = '{{ route("admin.users.index") }}' + (params.toString() ? '?' + params.toString() : '');
    }

    function viewUser(id) {
        window.location.href = `/admin/users/${id}`;
    }

    function editUser(id) {
        window.location.href = `/admin/users/${id}/edit`;
    }

    function toggleUserStatus(id, status) {
        // Sử dụng SweetAlert nếu có, hoặc confirm mặc định nhưng đổi text cho thân thiện hơn
        if (confirm(status === 0 ? 'Xác nhận khóa tài khoản người dùng này?' : 'Xác nhận mở khóa tài khoản người dùng này?')) {
            $.ajax({
                url: `/admin/users/${id}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message ?? 'Không thể cập nhật trạng thái người dùng');
                }
            });
        }
    }

    function deleteUser(id) {
        if (!confirm('Hành động này không thể hoàn tác. Bạn có chắc chắn muốn xóa?')) {
            return;
        }

        const token = '{{ csrf_token() }}';
        const form = $(`
            <form method="POST" action="/admin/users/${id}" style="display:none">
                <input type="hidden" name="_token" value="${token}">
                <input type="hidden" name="_method" value="DELETE">
            </form>
        `);

        $('body').append(form);
        form[0].submit();
    }

    // Select all checkboxes
    $('#selectAll').change(function() {
        $('.user-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Search on Enter key
    $('#searchUser').keypress(function(e) {
        if (e.which === 13) {
            searchUsers();
        }
    });
</script>
@endpush
@endsection