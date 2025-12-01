@extends('layouts.app')

@section('content')
    <div class="span9">
        <div class="well well-small">
            <h4>Sản Phẩm Nổi Bật</h4>
            <div class="row-fluid">
                <div id="featured" class="carousel slide">
                    <div class="carousel-inner">
                        @for ($i = 0; $i < $products->count(); $i += 4)
                            <div class="item {{ $i == 0 ? 'active' : '' }}">
                                <ul class="thumbnails">
                                    @foreach($products->skip($i)->take(4) as $product)
                                        <li class="span3">
                                            <div class="thumbnail">
                                                <i class="tag"></i>
                                                <a href="{{ route('products.show', $product->id) }}">
                                                    <img src="{{ asset('uploads/images/san_pham/' . $product->image) }}" alt=""
                                                        style="width: 100px; height:100px;">
                                                </a>
                                                <div class="caption">
                                                    <h5>{{ $product->name }}</h5>
                                                    <h4>
                                                        <a class="btn" href="{{ route('products.show', $product->id) }}">VIEW</a>
                                                        <span class="pull-right">{{ number_format($product->price) }}đ</span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endfor
                    </div>
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <div class="span9">
            <h4>Tất cả sản phẩm</h4>
            <ul class="thumbnails">
                @foreach($products as $product)
                    <li class="span3">
                        <div class="thumbnail">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset('uploads/images/san_pham/' . $product->image) }}" alt="" width="50%"
                                    height="50%" />
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
    </table>
@endsection