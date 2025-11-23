@extends('layouts.app')

@section('content')
    <div class="span9">
        <h4>Tất cả sản phẩm {{ $brand }} - {{ $categoryName }}</h4>
        <ul class="thumbnails">
            @foreach($products as $product)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset('uploads/images/san_pham/' . $product->image) }}" alt=""
                                style="width: 200px; height: 200px; object-fit: cover;" />
                        </a>
                        <div class="caption">
                            <h5>{{ $product->name }}</h5>
                            <p>
                                Số lượng còn: {{ $product->quantity }}
                            </p>
                            <h4 style="text-align:center">
                                <a class="btn" href="{{ route('cart.add', $product->id) }}">
                                    <i class="icon-shopping-cart"></i>
                                </a>
                                @if($product->gia > $product->gia_ban)
                                    {{-- Có giảm giá --}}
                                    <a class="btn btn-primary">
                                        <span style="text-decoration: line-through; font-size: 0.8em; color: #ffcccc;">
                                            {{ number_format($product->gia, 0, ',', '.') }}
                                        </span>
                                        {{ number_format($product->gia_ban, 0, ',', '.') }}₫
                                    </a>
                                @else
                                    {{-- Không giảm giá --}}
                                    <a class="btn btn-primary">
                                        {{ number_format($product->gia, 0, ',', '.') }}₫
                                    </a>
                                @endif
                            </h4>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection