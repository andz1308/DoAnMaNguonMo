<style>
    #sideManu .subMenu:hover ul {
        display: block;
    }

    #sideManu ul {
        display: none;
    }
</style>

@php
    $cartCount = 0;
    if(Auth::check()) {
        $currentCart = \App\Models\DonHang::where('user_id', Auth::id())
                        ->where('trang_thai', 0)
                        ->first();
        
        if($currentCart) {
            $cartCount = $currentCart->chiTietDonHang()->count();
        }
    }
@endphp
<div class="well well-small">
    <a id="myCart" href="{{ route('cart.index') }}">
        <img src="{{ asset('images/ico-cart.png') }}" alt="cart">
        [ {{ $cartCount }} ] Giỏ hàng 
        <span class="badge badge-warning pull-right"></span>
    </a>
</div>

<ul id="sideManu" class="nav nav-tabs nav-stacked">
    @if($categories && $categories->count() > 0)
        @foreach($categories as $category)
            <li class="subMenu">
                <a href="#">{{ $category->name }}</a>
                <ul>
                    <li>
                        <a href="{{ route('products.by-category', $category->id) }}">
                            <i class="icon-chevron-right"></i>All
                        </a>
                    </li>
                    @php
                        $brands = $category->sanPhams->pluck('thuong_hieu')->unique()->filter();
                    @endphp
                    @foreach($brands as $brand)
                        <li>
                            <a href="{{ route('products.by-brand', ['brand' => $brand, 'category' => $category->id]) }}">
                                <i class="icon-chevron-right"></i>{{ $brand }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    @else
        <li>Không có danh mục nào</li>
    @endif
</ul>

<br />
<div class="thumbnail">
    <img src="{{ asset('uploads/images/san_pham/i1_1.png') }}" alt="Iphone Images" style="width:150px;height:150px;"/>
    <div class="caption">
        <h5>iPhone 16 Pro Max 256GB Chính Hãng (VN/A)</h5>
        <h4 style="text-align:center">
            <a class="btn" href="{{ route('products.show', 1) }}"> 
                <i class="icon-zoom-in"></i>
            </a> 
            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> 
            <a class="btn btn-primary" href="#">34000000đ</a>
        </h4>
    </div>
</div>
<br />
<div class="thumbnail">
    <img src="{{ asset('uploads/images/san_pham/s2_1.png') }}" alt="SamSung Images" style="width:150px;height:150px;"/>
    <div class="caption">
        <h5>Samsung Galaxy Z Flip5 5G 256GB Chính Hãng</h5>
        <h4 style="text-align:center">
            <a class="btn" href="{{ route('products.show', 9) }}"> 
                <i class="icon-zoom-in"></i>
            </a> 
            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> 
            <a class="btn btn-primary" href="#">14990000đ</a>
        </h4>
    </div>
</div>
<br />
<div class="thumbnail">
    <img src="{{ asset('images/payment_methods.png') }}" title="Bootshop Payment Methods" alt="Payments Methods">
    <div class="caption">
        <h5>Payment Methods</h5>
    </div>
</div>
