@extends('layouts.app')

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Trang chủ</a> <span class="divider">/</span></li>
        <li><a href="#">Sản phẩm</a> <span class="divider">/</span></li>
        <li class="active">Chi tiết sản phẩm</li>
    </ul>

    <div class="row">
        <!-- BÊN TRÁI: ẢNH SẢN PHẨM -->
        <div id="gallery" class="span3">
            <div class="main-image-box">
                <img src="{{ asset('uploads/images/san_pham/' . $product->image) }}" alt="{{ $product->name }}"
                    id="mainProductImage" />
            </div>

            <div class="thumbnail-slider-container">
                <button class="thumb-nav prev" onclick="scrollThumbnails(-1)">
                    <i class="icon-chevron-left"></i>
                </button>

                <div class="thumbnail-track" id="thumbTrack">
                    <div class="thumb-item active">
                        <img src="{{ asset('uploads/images/san_pham/' . $product->image) }}" onclick="changeImage(this)"
                            alt="Main" />
                    </div>

                    @if($product->images)
                        @foreach($product->images as $img)
                            <div class="thumb-item">
                                <img src="{{ asset('uploads/images/san_pham/' . $img->name) }}" onclick="changeImage(this)"
                                    alt="Sub" />
                            </div>
                        @endforeach
                    @endif
                </div>

                <button class="thumb-nav next" onclick="scrollThumbnails(1)">
                    <i class="icon-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- BÊN PHẢI: THÔNG TIN MUA HÀNG -->
        <div class="span6">
            <h3>{{ $product->name }}</h3>
            <small>- {{ $product->camera ?? 'Camera chất lượng cao' }}</small>
            <hr class="soft" />

            <form class="form-horizontal qtyFrm" action="{{ route('cart.add', ['id' => $product->id]) }}" method="GET">
                <div class="control-group">
                    <label class="control-label">
                        <span
                            style="color:red; font-size:18px; font-weight:bold;">{{ number_format($product->gia, 0, ',', '.') }}
                            ₫</span>
                    </label>
                    <div class="controls">
                        <input type="number" name="so_luong" class="span1" placeholder="Qty." value="1" min="1"
                            max="{{ $product->so_luong_con }}" />
                        <button type="submit" class="btn btn-large btn-primary pull-right">
                            Thêm vào giỏ <i class=" icon-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </form>

            <hr class="soft" />
            <h4>Số lượng còn: {{ $product->so_luong_con }}</h4>

            <form class="form-horizontal qtyFrm pull-right">
                <div class="control-group">
                 
                </div>
            </form>
            <hr class="soft clr" />
            <p>
                {{ $product->gioi_thieu }}
            </p>
            <br class="clr" />
            <a name="detail"></a>
        </div>
    </div>

    <div class="row">
        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Thông số kỹ thuật</a></li>
                <li><a href="#profile" data-toggle="tab">Đánh giá ({{ $product->danhGias->count() }})</a></li>
            </ul>

            <div id="myTabContent" class="tab-content">
                
                <!-- TAB 1: THÔNG SỐ KỸ THUẬT -->
                <div class="tab-pane fade active in" id="home">
                    <h4>Thông tin sản phẩm</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow">
                                <th colspan="2">Chi tiết cấu hình</th>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Thương hiệu:</td>
                                <td class="techSpecTD2">{{ $product->thuong_hieu }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Màn hình:</td>
                                <td class="techSpecTD2">{{ $product->man_hinh }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Độ phân giải:</td>
                                <td class="techSpecTD2">{{ $product->do_phan_giai }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Camera:</td>
                                <td class="techSpecTD2">{{ $product->camera }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">CPU:</td>
                                <td class="techSpecTD2">{{ $product->cpu }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Pin:</td>
                                <td class="techSpecTD2">{{ $product->pin }}</td>
                            </tr>
                            <tr class="techSpecRow">
                                <td class="techSpecTD1">Dung lượng:</td>
                                <td class="techSpecTD2">{{ $product->dung_luong }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <h5>Mô tả chi tiết:</h5>
                        <p>{!! $product->mo_ta !!}</p>
                    </div>
                </div>

                <!-- TAB 2: ĐÁNH GIÁ VÀ BÌNH LUẬN -->
                <div class="tab-pane fade" id="profile">
                    
                    <!-- A. FORM VIẾT ĐÁNH GIÁ -->
                    <div class="row">
                        <div class="span9">
                            <div class="well">
                                <h4>Viết đánh giá của bạn</h4>
                                
                                {{-- Thông báo thành công --}}
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- Thông báo lỗi --}}
                                @if($errors->any())
                                    <div class="alert alert-error">
                                        @foreach ($errors->all() as $error)
                                            <div>- {{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <form action="{{ route('products.review', ['id' => $product->id]) }}" method="POST" class="form-horizontal">
                                    @csrf
                                    
                                    <!-- Chọn sao -->
                                    <div class="control-group">
                                        <label class="control-label" style="padding-top: 15px;"><b>Đánh giá:</b></label>
                                        <div class="controls">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="vote" value="5" checked />
                                                <label for="star5" title="Tuyệt vời">5 stars</label>
                                                <input type="radio" id="star4" name="vote" value="4" />
                                                <label for="star4" title="Tốt">4 stars</label>
                                                <input type="radio" id="star3" name="vote" value="3" />
                                                <label for="star3" title="Bình thường">3 stars</label>
                                                <input type="radio" id="star2" name="vote" value="2" />
                                                <label for="star2" title="Kém">2 stars</label>
                                                <input type="radio" id="star1" name="vote" value="1" />
                                                <label for="star1" title="Tệ">1 star</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tên người gửi -->
                                    <div class="control-group">
                                        <label class="control-label"><b>Tên hiển thị:</b></label>
                                        <div class="controls">
                                            <input type="text" class="span6" disabled 
                                                value="{{ Auth::check() ? Auth::user()->name : 'Người ẩn danh (Chưa đăng nhập)' }}" 
                                                style="background-color: #eee; cursor: not-allowed;">
                                        </div>
                                    </div>

                                    <!-- Nội dung -->
                                    <div class="control-group">
                                        <label class="control-label"><b>Nội dung:</b></label>
                                        <div class="controls">
                                            <textarea name="noi_dung" rows="3" class="span6" placeholder="Mời bạn chia sẻ cảm nhận về sản phẩm..."></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <hr class="soft" />
                    
                    <!-- B. DANH SÁCH ĐÁNH GIÁ -->
                    <h4>Các đánh giá từ khách hàng</h4>
                    
                    @if($product->danhGias && $product->danhGias->count() > 0)
                        @foreach($product->danhGias->sortByDesc('created_at') as $danhGia)
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="span1" style="text-align: center;">
                                    {{-- Avatar: Dùng Gravatar nếu có email, không thì random --}}
                                    @php
                                        $email = $danhGia->user ? $danhGia->user->email : 'guest';
                                        $hash = md5(strtolower(trim($email)));
                                    @endphp
                                    <img src="https://www.gravatar.com/avatar/{{ $hash }}?d=mp&s=64" 
                                         class="img-polaroid" style="width: 64px; height: 64px; border-radius: 50%;" />
                                </div>
                                <div class="span8">
                                    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                                        <strong>{{ $danhGia->user ? $danhGia->user->name : 'Người ẩn danh' }}</strong>
                                        <span class="pull-right" style="color: #999; font-size: 12px;">
                                            {{ $danhGia->created_at ? $danhGia->created_at->format('d/m/Y H:i') : '' }}
                                        </span>
                                        
                                        <div style="color: #f89406; font-size: 14px; margin: 5px 0;">
                                            @for($i = 0; $i < $danhGia->vote; $i++)
                                                <i class="icon-star"></i>
                                            @endfor
                                            @for($i = $danhGia->vote; $i < 5; $i++)
                                                <i class="icon-star-empty"></i>
                                            @endfor
                                        </div>

                                        <p>{{ $danhGia->noi_dung }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">
                            Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên để lại nhận xét!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- STYLE CSS --}}
    <style>
        /* CSS cho phần Star Rating Input */
        .rate {
            float: left;
            height: 30px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:24px;
            color:#ccc;
            margin-right: 5px;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

        /* CSS Ảnh sản phẩm */
        .main-image-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }
        .main-image-box img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        .thumbnail-slider-container {
            position: relative;
            padding: 0 30px;
        }
        .thumbnail-track {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            padding-bottom: 5px;
        }
        .thumbnail-track::-webkit-scrollbar { display: none; }
        .thumb-item {
            flex: 0 0 60px;
            height: 60px;
            border: 1px solid #eee;
            cursor: pointer;
            transition: all 0.2s;
        }
        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .thumb-item.active { border: 2px solid #007bff; }
        .thumb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            padding: 0;
        }
        .thumb-nav.prev { left: 0; }
        .thumb-nav.next { right: 0; }
    </style>

    {{-- SCRIPT JS --}}
    <script type="text/javascript">
        // Đổi ảnh lớn khi click ảnh nhỏ
        function changeImage(imgElement) {
            var mainImg = document.getElementById('mainProductImage');
            mainImg.src = imgElement.src;
            var allThumbs = document.querySelectorAll('.thumb-item');
            allThumbs.forEach(function (el) {
                el.classList.remove('active');
            });
            imgElement.parentElement.classList.add('active');
        }

        // Cuộn thumbnail
        function scrollThumbnails(direction) {
            var container = document.getElementById('thumbTrack');
            var scrollAmount = 100;
            if (direction === 1) {
                container.scrollLeft += scrollAmount;
            } else {
                container.scrollLeft -= scrollAmount;
            }
        }
    </script>
@endsection