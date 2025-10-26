@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="thumbnail">
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; max-width: 500px; height: auto;">
            </div>
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <h3 class="text-danger">{{ number_format($product->price) }} VND</h3>
            
            <div class="product-details">
                <h4>Thông tin sản phẩm</h4>
                <table class="table table-striped">
                    <tr>
                        <td><strong>Thương hiệu:</strong></td>
                        <td>{{ $product->brand }}</td>
                    </tr>
                    <tr>
                        <td><strong>Màn hình:</strong></td>
                        <td>{{ $product->man_hinh }}</td>
                    </tr>
                    <tr>
                        <td><strong>Độ phân giải:</strong></td>
                        <td>{{ $product->do_phan_giai }}</td>
                    </tr>
                    <tr>
                        <td><strong>Camera:</strong></td>
                        <td>{{ $product->camera }}</td>
                    </tr>
                    <tr>
                        <td><strong>CPU:</strong></td>
                        <td>{{ $product->cpu }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pin:</strong></td>
                        <td>{{ $product->pin }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dung lượng:</strong></td>
                        <td>{{ $product->dung_luong }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kích thước:</strong></td>
                        <td>{{ $product->kich_thuoc }}</td>
                    </tr>
                    <tr>
                        <td><strong>Trọng lượng:</strong></td>
                        <td>{{ $product->trong_luong }}</td>
                    </tr>
                    <tr>
                        <td><strong>Số lượng còn:</strong></td>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="product-description">
                <h4>Mô tả sản phẩm</h4>
                <div class="well">
                    {!! $product->description !!}
                </div>
            </div>
            
            <div class="product-introduction">
                <h4>Giới thiệu</h4>
                <div class="well">
                    {!! $product->introduction !!}
                </div>
            </div>
            
            <div class="product-actions">
                <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
                <a href="#" class="btn btn-success">Thêm vào giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
@endsection
