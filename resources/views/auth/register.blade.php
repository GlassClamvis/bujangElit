<!DOCTYPE html>
<html lang="en" data-layout-mode="detached" data-topbar-color="dark" data-sidenav-user="true">

<head>
    <meta charset="utf-8" />
    <title>Register & Signup | Bujang Elit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/head.js') }}"></script>

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
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
                    <h4 class="mt-0">Sign Up</h4>
                    <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute
                    </p>

                    <!-- form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input class="form-control" type="email" id="email" name="email" required
                                placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter your password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Ulangi Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" placeholder="Enter your password" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            <p style="display: none; color: red;" id="warn_pass">Password Tidak Cocok.</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="text-center d-grid">
                            <button class="btn btn-primary waves-effect waves-light" id="btnSubmit" type="submit"> Sign
                                Up </button>
                        </div>
                        <!-- social-->

                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Already have account? <a href="{{ url('login') }}"
                                class="text-muted ms-1"><b>Log In</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <!-- Authentication js -->
    <script src="assets/js/pages/authentication.init.js"></script>

    <script>
        $('#password_confirmation').bind('keyup', cekPassword);

        function cekPassword() {
            if ($('#password').val() == $('#password_confirmation').val()) {
                $('#warn_pass').css("display", "none");
                document.getElementById("btnSubmit").disabled = false;
                $("#password_confirmation").focus();
            } else {
                $('#warn_pass').css("display", "block");
                document.getElementById("btnSubmit").disabled = true;
            }
        }
    </script>
</body>

</html>
