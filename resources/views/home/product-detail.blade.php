@extends('layouts.app')

@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ route('home') }}">Trang chủ</a> <span class="divider">/</span></li>
        <li><a href="#">Sản phẩm</a> <span class="divider">/</span></li>
        <li class="active">Chi tiết sản phẩm</li>
    </ul>

    <div class="row">
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
                    <label class="control-label"><span>Màu sắc</span></label>
                    <div class="controls">
                        <select class="span2">
                            <option>Đen</option>
                            <option>Đỏ</option>
                            <option>Xanh</option>
                            <option>Nâu</option>
                        </select>
                    </div>
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
                <li><a href="#profile" data-toggle="tab">Đánh giá</a></li>
            </ul>

            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Thông tin sản phẩm</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow">
                                <th colspan="2">Chi tiết sản phẩm</th>
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
                    <p>{!! $product->mo_ta !!}</p>
                </div>

                <div class="tab-pane fade" id="profile">
                    <div id="myTab" class="pull-right">
                        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i
                                    class="icon-list"></i></span></a>
                    </div>
                    <br class="clr" />
                    <hr class="soft" />

                    <div class="tab-content">
                        <div class="tab-pane active" id="listView">
                            @if($product->danhGias && $product->danhGias->count() > 0)
                                @foreach($product->danhGias as $danhGia)
                                    <div class="row">
                                        <div class="span2">
                                            <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y"
                                                alt="" />
                                        </div>
                                        <div class="span6">
                                            <h3>{{ $danhGia->user->name ?? 'Khách hàng' }}</h3>
                                            <hr class="soft" />

                                            <div style="color: #f89406; font-size: 16px;">
                                                @for($i = 0; $i < $danhGia->vote; $i++)
                                                    <i class="icon-star"></i>
                                                @endfor
                                                @for($i = $danhGia->vote; $i < 5; $i++)
                                                    <i class="icon-star-empty"></i>
                                                @endfor
                                            </div>

                                            <p>
                                                {{ $danhGia->noi_dung }}
                                            </p>
                                            <br class="clr" />
                                        </div>
                                    </div>
                                    <hr class="soft" />
                                @endforeach
                            @else
                                <div class="alert alert-info">Chưa có đánh giá nào cho sản phẩm này.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Khung ảnh lớn */
        .main-image-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            height: 300px;
            /* Chiều cao cố định để ảnh không bị giật */
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .main-image-box img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            /* Giữ tỉ lệ ảnh đẹp */
        }

        /* Container bao quanh thanh trượt */
        .thumbnail-slider-container {
            position: relative;
            padding: 0 30px;
            /* Chừa chỗ cho 2 nút mũi tên */
        }

        /* Thanh chứa các ảnh (Track) */
        .thumbnail-track {
            display: flex;
            gap: 10px;
            /* Khoảng cách giữa các ảnh */
            overflow-x: auto;
            /* Cho phép cuộn ngang */
            scroll-behavior: smooth;
            /* Cuộn mượt */
            scrollbar-width: none;
            /* Ẩn thanh cuộn trên Firefox */
            padding-bottom: 5px;
        }

        .thumbnail-track::-webkit-scrollbar {
            display: none;
            /* Ẩn thanh cuộn trên Chrome/Safari */
        }

        /* Từng ảnh nhỏ */
        .thumb-item {
            flex: 0 0 60px;
            /* Kích thước cố định mỗi ảnh nhỏ (60px) */
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

        /* Hiệu ứng khi đang chọn */
        .thumb-item.active {
            border: 2px solid #007bff;
            /* Viền xanh */
        }

        .thumb-item:hover {
            opacity: 0.8;
        }

        /* Nút điều hướng mũi tên */
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

        .thumb-nav:hover {
            background: #eee;
        }

        .thumb-nav.prev {
            left: 0;
        }

        .thumb-nav.next {
            right: 0;
        }
    </style>
    <script>
        // Script đơn giản để đổi ảnh khi click thumbnail (nếu cần)
        // Với cấu trúc Bootshop hiện tại, nó thường dùng fancybox hoặc lightbox
        // Đoạn này để đảm bảo nếu click vào link ảnh nhỏ thì không chuyển trang mà đổi ảnh
        document.querySelectorAll('#differentview a').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                // Logic đổi ảnh lớn ở đây nếu bạn muốn xử lý bằng JS
                // Hiện tại thẻ a đang bọc img, click vào sẽ mở ảnh gốc
            })
        });
    </script>
    <script type="text/javascript">
        // 1. Hàm đổi ảnh lớn khi click ảnh nhỏ
        function changeImage(imgElement) {
            // Đổi ảnh lớn
            var mainImg = document.getElementById('mainProductImage');
            mainImg.src = imgElement.src;

            // Xử lý viền active (xanh)
            // Xóa class active cũ
            var allThumbs = document.querySelectorAll('.thumb-item');
            allThumbs.forEach(function (el) {
                el.classList.remove('active');
            });

            // Thêm class active cho ảnh vừa bấm (cha của thẻ img)
            imgElement.parentElement.classList.add('active');
        }

        // 2. Hàm cuộn thanh trượt khi bấm mũi tên
        function scrollThumbnails(direction) {
            var container = document.getElementById('thumbTrack');
            var scrollAmount = 100; // Khoảng cách mỗi lần trượt (px)

            if (direction === 1) {
                container.scrollLeft += scrollAmount;
            } else {
                container.scrollLeft -= scrollAmount;
            }
        }
    </script>
@endsection