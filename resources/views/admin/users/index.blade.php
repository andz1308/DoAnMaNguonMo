@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i>Danh sách người dùng</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Thêm người dùng
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchUser" placeholder="Tìm kiếm theo tên, email...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRole">
                    <option value="">Tất cả vai trò</option>
                    @foreach($roles ?? [] as $role)
                        <option value="{{ $role->id }}">{{ $role->ten_role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1">Hoạt động</option>
                    <option value="0">Bị khóa</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchUsers()">
                    <i class="fas fa-search me-2"></i>Tìm kiếm
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>ID</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Ngày đăng ký</th>
                        <th width="150" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                    <tr>
                        <td>
                            <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'Chưa có' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $user->role->ten_role ?? 'N/A' }}</span>
                        </td>
                        <td>
                            @if($user->trang_thai ?? 1)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Bị khóa</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" onclick="viewUser({{ $user->id }})" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if($user->trang_thai ?? 1)
                                <button class="btn btn-sm btn-danger" onclick="toggleUserStatus({{ $user->id }}, 0)" title="Khóa tài khoản">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @else
                                <button class="btn btn-sm btn-success" onclick="toggleUserStatus({{ $user->id }}, 1)" title="Mở khóa">
                                    <i class="fas fa-unlock"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Chưa có người dùng nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($users) && $users->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} / {{ $users->total() }} người dùng
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_id" required>
                            @foreach($roles ?? [] as $role)
                                <option value="{{ $role->id }}">{{ $role->ten_role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <textarea class="form-control" name="dia_chi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
        if (confirm(status === 0 ? 'Bạn có chắc muốn khóa tài khoản này?' : 'Bạn có chắc muốn mở khóa tài khoản này?')) {
            $.ajax({
                url: `/admin/users/${id}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
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
