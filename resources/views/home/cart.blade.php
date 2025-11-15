@extends('layouts.app')

@section('content')
<style>
    .cart-breadcrumb {
        background: #f5f5f5;
        padding: 8px 12px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .cart-breadcrumb a {
        color: #0088cc;
    }
    .cart-header-box {
        background: #fff;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .cart-header-box h3 {
        margin: 0;
        font-size: 20px;
        color: #333;
        display: inline-block;
    }
    .cart-header-box small {
        color: #999;
        font-size: 14px;
    }
    .cart-table-wrap {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .cart-table-wrap table {
        margin: 0;
    }
    .cart-table-wrap thead {
        background: #f9f9f9;
        border-bottom: 2px solid #ddd;
    }
    .cart-table-wrap thead th {
        padding: 10px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        color: #555;
    }
    .cart-table-wrap tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        font-size: 13px;
    }
    .product-img-cart {
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 2px;
    }
    .product-name-cart {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        font-size: 14px;
    }
    .product-meta {
        color: #999;
        font-size: 12px;
    }
    .stock-warning {
        background: #fcf8e3;
        border: 1px solid #fbeed5;
        padding: 6px 10px;
        border-radius: 3px;
        margin-top: 6px;
        color: #c09853;
        font-size: 12px;
    }
    .stock-warning strong {
        color: #c09853;
    }
    .row-stock-error {
        background-color: #f2dede;
    }
    .quantity-form {
        margin: 0;
        display: inline-block;
    }
    .quantity-input {
        width: 50px;
        text-align: center;
        margin-right: 3px;
        padding: 4px;
        font-size: 13px;
    }
    .btn-update-cart {
        padding: 4px 8px;
        font-size: 13px;
        margin-right: 3px;
    }
    .btn-remove-cart {
        padding: 4px 8px;
        font-size: 13px;
    }
    .price-cell {
        font-weight: 600;
        color: #c00;
        font-size: 14px;
    }
    .total-row-cart {
        background: #f9f9f9;
        font-weight: bold;
    }
    .total-row-cart td {
        padding: 12px 10px;
        font-size: 14px;
    }
    .total-amount-cart {
        color: #c00;
        font-size: 18px;
        font-weight: bold;
    }
    .checkout-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
    }
    .checkout-box h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 18px;
        color: #333;
        border-bottom: 2px solid #0088cc;
        padding-bottom: 8px;
    }
    .form-group-cart {
        margin-bottom: 12px;
    }
    .form-group-cart label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
        font-size: 13px;
    }
    .form-group-cart textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 13px;
        resize: vertical;
    }
    .user-info-display {
        background: #f5f5f5;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-weight: 600;
        font-size: 13px;
    }
    .btn-checkout-proceed {
        padding: 10px 30px;
        font-size: 15px;
        font-weight: 600;
    }
    .alert-checkout-error {
        text-align: center;
        margin: 0;
    }
    .alert-checkout-error h4 {
        margin-top: 0;
        font-size: 16px;
    }
    .empty-cart-box {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-cart-box h4 {
        font-size: 22px;
        margin-bottom: 10px;
    }
</style>

<div class="cart-breadcrumb">
    <a href="{{ route('home') }}">Trang chủ</a> 
    <span style="color: #999;">/</span>
    <span style="color: #333; font-weight: 600;">Giỏ hàng</span>
</div>

<div class="cart-header-box">
    <h3>
        <i class="icon-shopping-cart"></i> GIỎ HÀNG 
        <small>({{ $cart ? $cart->chiTietDonHang->count() : 0 }} sản phẩm)</small>
    </h3>
    <a href="{{ route('home') }}" class="btn btn-small pull-right">
        <i class="icon-arrow-left"></i> Tiếp tục mua sắm
    </a>
    <div class="clearfix"></div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Thành công!</strong> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Lỗi!</strong> {{ session('error') }}
    </div>
@endif

@if($cart && $cart->chiTietDonHang->count() > 0)
    
    @php $allowCheckout = true; @endphp

    <div class="cart-table-wrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 80px;">Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th style="width: 180px;">Số lượng</th>
                    <th style="width: 120px;">Đơn giá</th>
                    <th style="width: 130px;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php $totalMoney = 0; @endphp
                @foreach($cart->chiTietDonHang as $item)
                    @php
                        $sanPham = $item->sanPham;
                        $thanhTien = $sanPham->gia * $item->so_luong;
                        
                        $isOutOfStock = $sanPham->so_luong_con < $item->so_luong;
                        
                        if ($isOutOfStock) {
                            $allowCheckout = false; 
                        } else {
                            $totalMoney += $thanhTien;
                        }

                        $img = $sanPham->images->first(); 
                        $imgSrc = $img ? asset('uploads/images/san_pham/' . $img->name) : 'https://via.placeholder.com/70';
                    @endphp

                    <tr class="{{ $isOutOfStock ? 'row-stock-error' : '' }}">
                        <td style="text-align: center;">
                            <img width="70" class="product-img-cart" src="{{ $imgSrc }}" alt="{{ $sanPham->name }}"/>
                        </td>
                        <td>
                            <div class="product-name-cart">{{ $sanPham->name }}</div>
                            
                            @if($isOutOfStock)
                                <div class="stock-warning">
                                    <i class="icon-warning-sign"></i> 
                                    <strong>Kho chỉ còn: {{ $sanPham->so_luong_con }}</strong>
                                    <br>
                                    <small>Vui lòng cập nhật hoặc xóa</small>
                                </div>
                            @else
                                <div class="product-meta">
                                    <i class="icon-tag"></i> Màu sắc: Đen
                                </div>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="quantity-form">
                                @csrf
                                <input name="so_luong" type="number" min="1" value="{{ $item->so_luong }}" class="quantity-input">
                                
                                <button class="btn btn-success btn-small btn-update-cart" type="submit" title="Cập nhật">
                                    <i class="icon-refresh icon-white"></i>
                                </button>
                                
                                <a href="{{ route('cart.remove', $item->id) }}" 
                                   class="btn btn-danger btn-small btn-remove-cart" 
                                   title="Xóa" 
                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                    <i class="icon-trash icon-white"></i>
                                </a>
                            </form>
                        </td>
                        <td class="price-cell">{{ number_format($sanPham->gia, 0, ',', '.') }}₫</td>
                        <td class="price-cell">{{ number_format($thanhTien, 0, ',', '.') }}₫</td>
                    </tr>
                @endforeach
                
                <tr class="total-row-cart">
                    <td colspan="4" style="text-align:right">
                        TỔNG CỘNG:
                    </td>
                    <td class="total-amount-cart">
                        {{ number_format($totalMoney, 0, ',', '.') }}₫
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="checkout-box">
        @if($allowCheckout)
            <form action="{{ route('checkout.proceed') }}" method="POST">
                @csrf
                <h3>Thông tin thanh toán</h3>
                
                <div class="form-group-cart">
                    <label>Ghi chú đơn hàng:</label>
                    <textarea name="ghi_chu" rows="3" placeholder="Nhập ghi chú giao hàng (nếu có)..."></textarea>
                </div>
                
                <div class="form-group-cart">
                    <label>Người nhận:</label>
                    <div class="user-info-display">
                        <i class="icon-user"></i> {{ Auth::user()->name }}
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 15px;">
                    <button type="submit" class="btn btn-large btn-success btn-checkout-proceed">
                        Tiến hành thanh toán <i class="icon-arrow-right icon-white"></i>
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-error alert-checkout-error">
                <h4><i class="icon-exclamation-sign"></i> Không thể thanh toán!</h4>
                <p>Có sản phẩm trong giỏ hàng vượt quá số lượng tồn kho hoặc đã hết hàng.</p>
                <p><strong>Vui lòng xóa sản phẩm báo đỏ hoặc cập nhật lại số lượng để tiếp tục.</strong></p>
            </div>
        @endif
    </div>

@else
    <div class="alert alert-info empty-cart-box">
        <h4><i class="icon-shopping-cart"></i> Giỏ hàng trống!</h4>
        <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
        <p><a class="btn btn-primary btn-large" href="{{ route('home') }}">Mua sắm ngay</a></p>
    </div>
@endif

@endsection