<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>Bujang Elit</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('landinglandingAssets/images/favicon.ico') }}" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/bootstrap.min.css') }}">

    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/font-awesome.min.css') }}">

    <!--====== nice select css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/nice-select.css') }}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/magnific-popup.css') }}">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/slick.css') }}">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/default.css') }}">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('landingAssets/css/style.css') }}">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">


    <!--====== jquery js ======-->
    <script src="{{ asset('landingAssets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('landingAssets/js/vendor/jquery-1.12.4.min.js') }}"></script>



</head>

<body>

    <!--====== OFFCANVAS MENU PART START ======-->

    <div class="binduz-er-news-off_canvars_overlay"></div>
    <div class="binduz-er-news-offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="binduz-er-news-offcanvas_menu_wrapper">
                        <div class="binduz-er-news-canvas_close">
                            <a href="javascript:void(0)"><i class="fal fa-times"></i></a>
                        </div>
                        <div class="binduz-er-news-header-social">
                            <ul class="text-center">
                                <li><a href="#">facebook</a></li>
                                <li><a href="#">Twitter</a></li>
                                <li><a href="#">Skype</a></li>
                            </ul>
                        </div>
                        <div id="menu" class="text-left ">
                            <ul class="binduz-er-news-offcanvas_main_menu">
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#">Home</a>
                                </li>
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#">Berita </a>
                                </li>
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#">Jurnal</a>
                                </li>
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#"> Buku</a>
                                    <ul class="binduz-er-news-sub-menu">
                                </li>
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#"> About</a>
                                </li>
                                <li class="binduz-er-news-menu-item-has-children">
                                    <a href="#"> Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="binduz-er-news-offcanvas_footer">
                            <div class="binduz-er-news-logo text-center mb-30 mt-30">
                                <a href="index.html">
                                    <img src="https://fakeimg.pl/148x62/cccccc/0f0e0e?text=BujangElit&font=robot"
                                        alt="">
                                </a>
                            </div>
                            <p>I’m Michal Škvarenina, a multi-disciplinary designer currently working at Wild and as a
                                freelance designer.</p>
                            <ul>
                                <li><i class="fas fa-phone"></i> +212 34 45 45 98</li>
                                <li><i class="fas fa-home"></i> Angle Bd Abdelmoumen & rue soumaya, Résidence</li>
                                <li><i class="fas fa-envelope"></i> hello@example.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== OFFCANVAS MENU PART ENDS ======-->

    <!--====== SEARCH PART START ======-->

    <div class="binduz-er-news-search-box">
        <div class="binduz-er-news-search-header">
            <div class="container mt-60">
                <div class="row">
                    <div class="col-6">
                        <img src="landingAssets/images/logo-4.png" alt=""> <!-- search title -->
                    </div>
                    <div class="col-6">
                        <div class="binduz-er-news-search-close float-end">
                            <button class="binduz-er-news-search-close-btn">Close <span></span><span></span></button>
                        </div> <!-- search close -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- search header -->
        <div class="binduz-er-news-search-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="binduz-er-news-search-form">
                            <form action="#">
                                <input type="text" placeholder="Search for Products">
                                <button><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- search body -->
    </div>

    <!--====== SEARCH PART ENDS ======-->

    <!--====== BINDUZ HEADER PART START ======-->

    <style>
        .navbar .navbar-nav .nav-item a {
            margin: 0 15px;
        }

        .navbar .navbar-nav .nav-item a:hover {
            color: blue;
        }
    </style>
    <header class="binduz-er-header-area">
        <div class="binduz-er-header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navigation">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-brand logo">
                                    <a href="index.html">
                                        <img src="{{ asset('img/logo/lumajang-logo.png') }}" alt="dark logo"
                                            height="62px" width="47px">
                                        <img src="{{ asset('img/logo/lumajangKab.png') }}" alt="dark logo"
                                            height="37px" width="139px">
                                    </a>
                                </div> <!-- logo -->
                                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                    <ul class="navbar-nav m-auto">
                                        @forelse($data['getMenu'] as $getMenu)
                                            @if ($getMenu->url == '#')
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">{{ $getMenu->title }}<i
                                                            class="fa fa-angle-down"></i></a>
                                                    <ul class="sub-menu" style="max-width:600px;">
                                                        @forelse($getMenu->subMenu as $subMenu)
                                                            <li><a class="nav-link"
                                                                    href="{{ url('subMenu/' . $subMenu->url) }}">
                                                                    {{ $subMenu->title }}
                                                                </a>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="nav-item {{ $data['menu'] == 'l1' ? 'active' : '' }}">
                                                    <a class="nav-link"
                                                        href="{{ url($getMenu->url) }}">{{ $getMenu->title }}</a>
                                                </li>
                                            @endif
                                        @empty
                                        @endforelse
                                    </ul>
                                    {{--  <ul class="navbar-nav m-auto">
                                        <li class="nav-item {{ $data['menu'] == 'l1' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                                        </li>
                                        <li class="nav-item {{ $data['menu'] == 'l0' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }}">Tentang Kami</a>
                                        </li>
                                        <li class="nav-item {{ $data['menu'] == 'l2' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('news-all') }}">Berita</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Penelitian<i
                                                    class="fa fa-angle-down"></i></a>
                                            <ul class="sub-menu" style="max-width:600px;">
                                                <li><a class="nav-link" href="{{ url('/') }}">Bidang
                                                        Penyelenggaraan Pemerintahan dan Pengkajian Peraturan</a></li>
                                                <li><a class="nav-link" href="{{ url('/') }}">Bidang Sosial dan
                                                        Kependudukan</a></li>
                                                <li><a class="nav-link" href="{{ url('/') }}">Bidang Ekonomi dan
                                                        Pembangunan</a></li>
                                                <li><a class="nav-link" href="{{ url('/') }}">Bidang Inovasi dan
                                                        Teknologi</a></li>
                                            </ul>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Inovasi Daerah<i
                                                    class="fa fa-angle-down"></i></a>
                                            <ul class="sub-menu" style=" max-width: 310px;">
                                                <li><a class="nav-link" href="{{ url('/') }}">Inovasi
                                                        Pemerintahan Daerah</a></li>
                                                <li><a href="blog-details-2.html">Inovasi Masyarakat</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item {{ $data['menu'] == 'l3' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }}">Elektronik Jurnal</a>
                                        </li>
                                        <li class="nav-item {{ $data['menu'] == 'l0' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }}">Agenda Kegiatan</a>
                                        </li>
                                        <li class="nav-item {{ $data['menu'] == 'l0' ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ url('/') }}">Download</a>
                                        </li>
                                    </ul> --}}
                                </div> <!-- navbar collapse -->
                                <div class="binduz-er-navbar-btn d-flex">
                                    <div class="binduz-er-widget d-flex">
                                        <a
                                            @if (auth()->check()) href="{{ url('dashboard') }} " @else href="{{ url('login') }}" @endif>
                                            <i class="far fa-user"></i>
                                        </a>

                                        <a href="#">&nbsp; </a>
                                    </div>

                                </div>
                            </nav>
                        </div> <!-- navigation -->
                    </div>
                </div> <!-- row -->
            </div>
        </div>
    </header>

    <!--====== BINDUZ HEADER PART ENDS ======-->

    @yield('content')

    <!--====== BINDUZ FOOTER PART START ======-->

    <footer class="binduz-er-footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="binduz-er-footer-widget-style-1">
                                <div class="binduz-er-footer-title">
                                    <h3 class="binduz-er-title">Categories</h3>
                                </div>
                                <div class="binduz-er-footer-menu-list">
                                    <ul>
                                        <li><a href="#">Architecture</a></li>
                                        <li><a href="#">New look 2015</a></li>
                                        <li><a href="#">Gadgets</a></li>
                                        <li><a href="#">Mobile and Phones</a></li>
                                        <li><a href="#">Recipes</a></li>
                                        <li><a href="#">Decorating</a></li>
                                    </ul>
                                    <ul>
                                        <li><a href="#">Interiors</a></li>
                                        <li><a href="#">Street fashion</a></li>
                                        <li><a href="#">Street fashion</a></li>
                                        <li><a href="#">Lifestyle</a></li>
                                        <li><a href="#">Lookback</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="binduz-er-footer-widget-style-1">
                                <div class="binduz-er-footer-title">
                                    <h3 class="binduz-er-title">Newsletter</h3>
                                </div>
                                <div class="binduz-er-footer-widget-form">
                                    <form action="#">
                                        <div class="binduz-er-input-box">
                                            <i class="fal fa-user"></i>
                                            <input type="text" placeholder="Enter your name">
                                        </div>
                                        <div class="binduz-er-input-box">
                                            <i class="fal fa-envelope"></i>
                                            <input type="email" placeholder="Enter email address">
                                        </div>
                                        <div class="binduz-er-input-box">
                                            <button type="button"><i class="fal fa-paper-plane"></i> Subscribe
                                                Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="binduz-er-footer-widget-style-3">
                                <div class="binduz-er-footer-title">
                                    <h3 class="binduz-er-title">Recent Feeds</h3>
                                </div>
                                <div class="binduz-er-footer-widget-feeds">
                                    <div class="binduz-er-sidebar-latest-post-box">
                                        @forelse($data['rc'] as $rc)
                                            <div class="binduz-er-sidebar-latest-post-item">
                                                <div class="binduz-er-thumb">
                                                    <img src="{{ asset('assets/data/cover/' . $rc->cover) }}"
                                                        alt="latest">
                                                </div>
                                                <div class="binduz-er-content">
                                                    <span><i class="fal fa-calendar-alt"></i>
                                                        {{ $rc->createdDate }}</span>
                                                    <h4 class="binduz-er-title"><a
                                                            href="{{ url('news/' . $rc->url) }}">{{ $rc->judul }}</a>
                                                    </h4>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="binduz-er-footer-widget-info">
                        <div class="binduz-er-logo">
                            <img src="{{ asset('img/logo/lumajang-logo.png') }}" height="62px" width="47px">
                            <img src="{{ asset('img/logo/lumajangKab.png') }}" height="37px" width="139px">
                        </div>
                        <div class="binduz-er-text">
                            <p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Quis ipsum suspend isse ultrices gravida.
                            </p>
                        </div>
                        <div class="binduz-er-social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="binduz-er-back-to-top">
            <p>BACK TO TOP <i class="fal fa-long-arrow-right"></i></p>
        </div>
    </footer>
    <div class="binduz-er-footer-copyright-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="binduz-er-copyright-text">
                        <p<span>BujangElit</span> - 2023</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="binduz-er-copyright-menu float-lg-end float-none">
                        <ul>
                            <li><a href="#">&nbsp;</a></li>
                            <li><a href="#">&nbsp;</a></li>
                            <li><a href="#">
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== BINDUZ FOOTER PART ENDS ======-->

    <!--====== BINDUZ BACK TO TOP PART START ======-->

    <div class="binduz-er-back-to-top">
        <p>BACK TO TOP <i class="fal fa-long-arrow-right"></i></p>
    </div>

    <!--====== BINDUZ BACK TO TOP PART ENDS ======-->













    <!--====== Bootstrap js ======-->
    <script src="{{ asset('landingAssets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landingAssets/js/popper.min.js') }}"></script>

    <!--====== Slick js ======-->
    <script src="{{ asset('landingAssets/js/slick.min.js') }}"></script>

    <!--====== nice select js ======-->
    <script src="{{ asset('landingAssets/js/jquery.nice-select.min.js') }}"></script>

    <!--====== Isotope js ======-->
    <script src="{{ asset('landingAssets/js/isotope.pkgd.min.js') }}"></script>

    <!--====== Images Loaded js ======-->
    <script src="{{ asset('landingAssets/js/imagesloaded.pkgd.min.js') }}"></script>

    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('landingAssets/js/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!--====== Main js ======-->
    <script src="{{ asset('landingAssets/js/main.js') }}"></script>


</body>

</html>
