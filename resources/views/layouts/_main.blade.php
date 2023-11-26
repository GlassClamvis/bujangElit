<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-sidenav-user="true">
@include('layouts._head')

<body>

    <!-- Begin page -->
    <div id="wrapper">


        <!-- ========== Menu ========== -->
        <div class="app-menu">

            <!-- Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="{{ url('/') }}" class="logo-light">
                    <img src="https://fakeimg.pl/97x20/cccccc/0f0e0e?text=BujangElit&font=robot" alt=""
                        height="20px" width="97px" class="logo-lg">
                    <img src="https://fakeimg.pl/77x76/cccccc/0f0e0e?text=BJ&font=robot" alt="small logo"
                        class="logo-sm">
                </a>

                <!-- Brand Logo Dark -->
                <a href="{{ url('/') }}" class="logo-dark" style="margin-top: 20px;">
                    <img src="{{ asset('img/logo/lumajang-logo.png') }}" alt="dark logo" height="77px" width="58px">
                    <img src="{{ asset('img/logo/lumajangKab.png') }}" alt="dark logo" height="46px" width="174px">
                    <img src="https://fakeimg.pl/77x76/cccccc/0f0e0e?text=BJ&font=robot" alt="small logo"
                        class="logo-sm">
                </a>
            </div>

            <?php
            $imgPath = Auth::user()->pengguna_id ? Auth::user()->penggunaData->foto : '';
            if (!file_exists('img/users/' . $imgPath) || $imgPath == '') {
                $imgPath = 'img/users/avatar-men.png';
                //dd($imgPath);
            } else {
                $imgPath = 'img/users/' . $imgPath;
                //dd($imgPath);
            }
            ?>
            <!-- menu-left -->
            <div class="scrollbar">

                <!-- User box -->
                <div class="user-box text-center">
                    <img src="{{ asset($imgPath) }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block"
                            data-bs-toggle="dropdown">{{ Auth::User()->name }}</a>
                        <div class="dropdown-menu user-pro-dropdown">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();  document.getElementById('logout-form').submit();"
                                class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </div>
                    <p class="text-muted mb-0">{{ Auth::user()->roles->pluck('name')->first() }}</p>
                </div>

                @include('layouts._menu')

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left menu End ========== -->





        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">

            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar">
                    <div class="topbar-menu d-flex align-items-center gap-1">

                        <!-- Topbar Brand Logo -->
                        <div class="logo-box">
                            <!-- Brand Logo Light -->
                            <a href="index.html" class="logo-light">
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo" class="logo-lg">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" class="logo-sm">
                            </a>

                            <!-- Brand Logo Dark -->
                            <a href="index.html" class="logo-dark">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo" class="logo-lg">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" class="logo-sm">
                            </a>
                        </div>

                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu">
                            <i class="mdi mdi-menu"></i>
                        </button>

                    </div>

                    <ul class="topbar-menu d-flex align-items-center">

                        <!-- Search Dropdown (for Mobile/Tablet) -->
                        <li class="dropdown d-lg-none">
                            <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <i class="ri-search-line font-22"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="search" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>

                        <!-- User Dropdown -->
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false">
                                <img src="{{ asset($imgPath) }}" alt="user-image" class="rounded-circle">
                                <span class="ms-1 d-none d-md-inline-block">
                                    <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();  document.getElementById('logout-form').submit();"
                                    class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== Topbar End ========== -->

            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        @foreach ($Breadcrumb as $br)
                                            <li class="breadcrumb-item {{ @$br['is-active'] }}"><a
                                                    href="{{ $br['link'] }}">{{ $br['label'] }}</a></li>
                                        @endforeach
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    {{ @$data['main-title'] ? @$data['main-title'] : 'BujangElit' }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    @yield('content')

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © BujangElit
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-none d-md-flex gap-4 align-item-center justify-content-md-end footer-links">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    @include('layouts._jsfooter')

    <script></script>

</body>

</html>
