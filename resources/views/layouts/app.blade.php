<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bootshop online Shopping cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="{{ asset('css/bootshop/bootstrap.min.css') }}" media="screen" />
    <link href="{{ asset('css/base.css') }}" rel="stylesheet" media="screen" />
    <!-- Bootstrap style responsive -->
    <link href="{{ asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="{{ asset('js/google-code-prettify/prettify.css') }}" rel="stylesheet" />
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="{{ asset('images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/ico/apple-touch-icon-57-precomposed.png') }}">
    <style type="text/css" id="enject"></style>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Fix for missing glyphicons -->
    <style>
        @font-face {
            font-family: 'Glyphicons Halflings';
            src: url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.eot") }}');
            src: url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.eot?#iefix") }}') format('embedded-opentype'),
                url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.woff2") }}') format('woff2'),
                url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.woff") }}') format('woff'),
                url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.ttf") }}') format('truetype'),
                url('{{ asset("css/bootshop/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular") }}') format('svg');
        }
    </style>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            z-index: 1;
        }

        /* CSS cho dropdown menu trong header */
        .nav .nav-list {
            position: absolute;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 10px;
            margin: 0;
            min-width: 200px;
            z-index: 1000;
            display: none;
        }

        .nav .nav-list li {
            margin: 0;
            padding: 8px 12px;
        }

        .nav .nav-list li a {
            text-decoration: none;
            color: #333;
            display: block;
        }

        .nav .nav-list li a:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .nav:hover .nav-list {
            display: block;
        }

        .nav a {
            display: block;
        }

        /* CSS cho sidebar - luôn hiển thị */
        #sidebar .nav-list {
            position: static;
            display: block;
            background-color: transparent;
            box-shadow: none;
            padding: 0;
            margin: 0;
            min-width: auto;
            z-index: auto;
        }

        #sidebar .nav-list li {
            margin: 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        #sidebar .nav-list li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 5px 10px;
        }

        #sidebar .nav-list li a:hover {
            background-color: #f5f5f5;
            color: #007bff;
        }

        .navbar-search input {
            width: 300px;
            height: 50px;
        }

        .carousel img {
            width: 1170px;
            height: 480px;
        }

        .thumbnail img {
            width: 50%;
            height: 50%;
        }

        #successMessage {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            width: 250px;
        }

        #successMessage button {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 3;
        }

        #successMessage p {
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="header">
        <div class="container">
            <div id="welcomeLine" class="row">
                <div class="span6">Welcome!<strong> User</strong></div>
                <div class="span6">
                    <div class="pull-right">
                        <a href="#"><span class="">Fr</span></a>
                        <a href="#"><span class="">Es</span></a>
                        <span class="btn btn-mini">En</span>
                        <a href="#"><span>&pound;</span></a>
                        <span class="btn btn-mini">$</span>
                        <a href="#"><span class="">$</span></a>
                        <a href="#"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i>
                                0 Giỏ hàng </span> </a>
                    </div>
                </div>
            </div>

            <!-- Navbar ================================================== -->
            <div id="logoArea" class="navbar">
                <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-inner">
                    <a class="brand" href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="KookaburraShop" width="250px" height="200px" />
                    </a>
                    <form class="form-inline navbar-search" method="GET" action="{{ route('search') }}">
                        <input placeholder="Bạn muốn tìm gì..." type="text" name="query"
                            style="width:300px; height:50px;" />
                    </form>
                    <ul id="topMenu" class="nav">
                        <li class=""><a href="#">Báo cáo & phản hồi</a></li>
                        <li class=""><a href="#">Đơn hàng</a></li>

                        @auth
                            <li class="nav">
                                <a href="#" style="display:flex; justify-content:center;align-items:center">
                                    <i class='bx bxs-user-circle' style="font-size:35px "></i>
                                    <p style="font-size:15px; margin: 0;">Hi!, {{ auth()->user()->name }}</p>
                                </a>
                                <ul class="nav-list">
                                    <li><a href="">Thông tin tài khoản</a></li>

                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            style="background-color:bisque">
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="">
                                <a href="{{ route('login') }}" style="padding-right:0;font-size:60px">
                                    <i class='bx bxs-user-circle'></i>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header End====================================================================== -->

    <!-- Carousel -->
    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <a href="#"><img src="{{ asset('images/carousel/22mb-ip14.jpg') }}" alt="special offers" /></a>
                        <div class="carousel-caption">
                            <h4>iPhone 14</h4>
                            <p>Khuyến mãi đặc biệt iPhone 14.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <a href="#"><img src="{{ asset('images/carousel/25mb-sale-samsung.jpg') }}"
                                alt="special offers" /></a>
                        <div class="carousel-caption">
                            <h4>Samsung Galaxy</h4>
                            <p>Sale lớn Samsung Galaxy.</p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
    </div>

    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div id="sidebar" class="span3">
                    @php
                        $sidebarCategories = $categories ?? \App\Models\LoaiSanPham::with('sanPhams')->get();
                    @endphp
                    @include('layouts.sidebar', ['categories' => $sidebarCategories])
                </div>

                <!-- Main content -->
                <div class="span9">
                    @if(session('message'))
                        <div class="alert alert-success" id="successMessage">
                            <button onclick="closeMessage()" class="btn btn-small btn-warning"><i
                                    class='bx bx-x'></i></button>
                            <p style="margin: 0;">{{ session('message') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Footer ================================================================== -->
    <div id="footerSection">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <h5>TÀI KHOẢN </h5>
                    <a href="#">TÀI KHOẢN CỦA BẠN</a>
                    <a href="#">THÔNG TIN CÁ NHÂN</a>
                    <a href="#">ĐỊA CHỈ</a>
                    <a href="#"> GIẢM GIÁ</a>
                    <a href="#">LỊCH SỬ ĐƠN HÀNG</a>
                </div>
                <div class="span3">
                    <h5>THÔNG TIN </h5>
                    <a href="#">LIÊN HỆ</a>
                    <a href="#">ĐĂNG KÝ</a>
                    <a href="#">THÔNG BÁO PHÁP LÝ</a>
                    <a href="#">ĐIỀU KHOẢN VÀ ĐIỀU KIỆN</a>
                    <a href="#">CÂU HỎI THƯỜNG GẶP</a>
                </div>
                <div class="span3">
                    <h5>ƯU ĐÃI CỦA CHÚNG TÔI </h5>
                    <a href="#">SẢN PHẨM MỚI</a>
                    <a href="#">NGƯỜI BÁN HÀNG HÀNG ĐẦU</a>
                    <a href="#">ƯU ĐÃI ĐẶC BIỆT</a>
                    <a href="#">NHÀ SẢN XUẤT</a>
                    <a href="#">NHÀ CUNG CẤP</a>
                </div>
                <div id="socialMedia" class="span3 pull-right">
                    <h5>TRUYỀN THÔNG MẠNG XÃ HỘI</h5>
                    <a href="#"><img width="60" height="60" src="{{ asset('images/facebook.png') }}" title="facebook"
                            alt="facebook" /></a>
                    <a href="#"><img width="60" height="60" src="{{ asset('images/twitter.png') }}" title="twitter"
                            alt="twitter" /></a>
                    <a href="#"><img width="60" height="60" src="{{ asset('images/youtube.png') }}" title="youtube"
                            alt="youtube" /></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/google-code-prettify/prettify.js') }}"></script>
    <script src="{{ asset('js/bootshop.js') }}"></script>
    <script src="{{ asset('js/jquery.lightbox-0.5.js') }}"></script>

    <script type="text/javascript">
        function closeMessage() {
            var message = document.getElementById("successMessage");
            message.style.display = "none";
        }
    </script>
</body>

</html>