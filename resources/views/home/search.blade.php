@extends('layouts.app')

@section('content')
<div class="span9">
    <h4>Tất cả sản phẩm: {{ $query }}</h4>
    <ul class="thumbnails">
        @foreach($products as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="" style="width: 200px; height: 200px; object-fit: cover;" />
                    </a>
                    <div class="caption">
                        <h5>{{ $product->name }}</h5>
                        <p>
                            Số lượng còn: {{ $product->quantity }}
                        </p>
                        <h4 style="text-align:center">
                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                            <a class="btn btn-primary" href="#">{{ number_format($product->price) }} VND</a>
                        </h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
