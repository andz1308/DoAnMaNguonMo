@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')
@section('page-title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fas fa-receipt me-2"></i>Đơn hàng #{{ $order->id }}</h4>
        <a href="{{ route('admin.don_hang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Danh sách sản phẩm</strong>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($order->chiTietDonHang as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $imageName = $item->sanPham->images->first()->name
                                                        ?? $item->sanPham->image
                                                        ?? null;
                                                    $imageUrl = $imageName
                                                        ? asset('uploads/images/san_pham/' . $imageName)
                                                        : null;
                                                @endphp
                                                @if($imageUrl)
                                                    <img src="{{ $imageUrl }}" alt="{{ $item->sanPham->name ?? '' }}"
                                                        class="me-2" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                                @endif
                                                <div>
                                                    <strong>{{ $item->sanPham->name ?? 'Sản phẩm đã xoá' }}</strong>
                                                    <div class="text-muted small">
                                                        Mã: {{ $item->sanPham->id ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->so_luong }}</td>
                                        <td class="text-end">{{ number_format($item->sanPham->gia ?? 0, 0, ',', '.') }} VND</td>
                                        <td class="text-end">{{ number_format(($item->sanPham->gia ?? 0) * $item->so_luong, 0, ',', '.') }} VND</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Không có sản phẩm trong đơn hàng này.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <div class="fw-semibold">Tổng thanh toán:</div>
                    <div class="fs-4 text-primary">{{ number_format($order->tong_tien, 0, ',', '.') }} VND</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Thông tin khách hàng</strong>
                </div>
                <div class="card-body">
                    <p class="mb-1 text-muted">Khách hàng</p>
                    <h5>{{ $order->user->name ?? 'Khách vãng lai' }}</h5>
                    <p class="mb-1 text-muted">Email</p>
                    <div>{{ $order->user->email ?? 'Không có' }}</div>
                    <p class="mb-1 text-muted mt-3">Số điện thoại</p>
                    <div>{{ $order->user->dien_thoai ?? 'Không có' }}</div>
                    <p class="mb-1 text-muted mt-3">Địa chỉ</p>
                    <div>{{ $order->user->dia_chi ?? 'Không có' }}</div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <strong>Trạng thái đơn hàng</strong>
                    <span class="badge 
                        @switch($order->trang_thai)
                            @case(\App\Models\DonHang::STATUS_COMPLETED) bg-success @break
                            @case(\App\Models\DonHang::STATUS_PROCESSING) bg-primary @break
                            @case(\App\Models\DonHang::STATUS_CANCELLED) bg-danger @break
                            @default bg-warning text-dark
                        @endswitch">
                        {{ $order->trang_thai_label }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.don_hang.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Cập nhật trạng thái</label>
                            <select name="trang_thai" class="form-select">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($order->trang_thai === (int)$value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <textarea name="ghi_chu" class="form-control" rows="3"
                                placeholder="Ghi chú cho đơn hàng">{{ old('ghi_chu', $order->ghi_chu) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <strong>Thanh toán</strong>
                </div>
                <div class="card-body">
                    <p class="mb-1 text-muted">Tổng tiền</p>
                    <div class="fw-semibold">{{ number_format($order->tong_tien, 0, ',', '.') }} VND</div>
                    <p class="mb-1 text-muted mt-3">Ngày thanh toán</p>
                    <div>{{ optional($order->thanhToan)->ngay_thanh_toan ? \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('d/m/Y H:i') : 'Chưa thanh toán' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

