<!DOCTYPE html>
<html lang="en" data-layout-mode="detached" data-topbar-color="dark" data-sidenav-user="true">

<head>
    <meta charset="utf-8" />
    <title>Log In | BujangElit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/head.js') }}"></script>

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body class="auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="p-3">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <div class="auth-brand">
                            <a href="index.html" class="logo logo-dark text-center">
                                <span class="">
                                    <img src="{{ asset('img/logo/lumajang-logo.png') }}" alt="dark logo" height="77px"
                                        width="58px">
                                    <img src="{{ asset('img/logo/lumajangKab.png') }}" alt="dark logo" height="46px"
                                        width="174px">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="22">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Log In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                    <!-- form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" id="email" name="email"
                                value="{{ old('email') }}" required="" placeholder="Enter your email">
                            {{--   @error('email')
                                <small style="color: red;">Email Tidak Boleh Kosong</small>
                            @enderror --}}
                        </div>
                        <div class="mb-3">
                            {{--  <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Forgot your
                                    password?</small></a> --}}
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" value="{{ old('password') }}"
                                    class="form-control" placeholder="Enter your password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            {{--    @error('password')
                                <small style="color: red;">Password Tidak Boleh Kosong</small>
                            @enderror --}}
                        </div>

                        {{--  <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Remember me</label>
                            </div>
                        </div> --}}

                        @if ($errors->any())
                            {{-- @dd($errors) --}}
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-center d-grid">
                            <button class="btn btn-primary" type="submit">Log In </button>
                        </div>
                        <!-- social-->

                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Don't have an account? <a href="{{ route('register') }}"
                                class="text-muted ms-1"><b>Sign Up</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                {{--  <h2 class="mb-3 text-white">I love the color!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> I've been using your theme from the
                    previous developer for our web app, once I knew new version is out, I immediately bought with no
                    hesitation. Great themes, good documentation with lots of customization available and sample app
                    that really fit our need. <i class="mdi mdi-format-quote-close"></i>
                </p> --}}
                {{--   <h5 class="text-white">
                    - Fadlisaad (Ubold Admin User)
                </h5> --}}
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- Authentication js -->
    <script src="{{ asset('assets/js/pages/authentication.init.js') }}"></script>

</body>

</html>
