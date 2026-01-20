<!DOCTYPE html>
<html lang="id">

<head>
    <title>@yield('title') - Sistem Informasi Desa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Sistem Informasi Desa Digital — layanan dan transparansi desa berbasis web.">
    <meta name="keywords" content="Sistem Informasi Desa, SID, Desa Digital, Pemerintahan, Layanan Masyarakat">
    <meta name="author" content="Desa Digital">

   <link rel="icon" type="image/png" href="{{ asset('assets/images/my/logo-tp.png') }}">
<link rel="shortcut icon" href="{{ asset('assets/images/my/logo-tp.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/images/my/logo-tp.png') }}">


    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <!-- [Mobile Responsive CSS] -->
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-responsive.css') }}">

    <style>
        body {
            font-family: "Public Sans", sans-serif;
            background-color: #f4f9f6;
        }

        .navbar {
            transition: background 0.3s ease-in-out;
            background-color: #2e7d32 !important;
        }

        .navbar-brand img {
            filter: none;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .nav-link.active {
            border-bottom: 2px solid #fff;
        }

        .btn-primary {
            background-color: #43a047 !important;
            border-color: #43a047 !important;
        }

        footer {
            background: #1b5e20;
            color: #fff;
        }

        footer a {
            color: #c8e6c9;
        }

        footer a:hover {
            color: #ffffff;
        }

        .footer-logo {
            filter: none;
        }
    </style>
</head>

<body class="landing-page">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md navbar-dark py-2 shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img width="40" src="{{ asset('assets/images/my/sidoarjo.png') }}" alt="logo desa">
                <span class="ms-2 fw-bold text-white">Sistem Informasi Desa</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item pe-2"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                            href="/">Beranda</a></li>
                    <li class="nav-item pe-2"><a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="/dashboard">Dashboard</a></li>
                    <li class="nav-item pe-2"><a class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}"
                            href="/contact-us">Kontak</a></li>
                    @if (auth()->check())
                        <li class="nav-item">
                            <a class="btn btn-light text-success fw-bold" href="/myprofile">
                                <i class="ti ti-user"></i> {{ auth()->user()->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-light text-success fw-bold" href="/login">
                                <i class="ti ti-login"></i> Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🌾 CONTENT -->
    <main class="mt-5 pt-4">
        @yield('content')
    </main>

    <!-- 🌻 FOOTER -->
    <footer class="footer text-white pt-5">
        <div class="container pb-4 border-bottom border-light">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/my/sidoarjo.png') }}" alt="logo desa"
                        class="img-fluid mb-3 footer-logo" style="max-width: 150px;">
                    <p class="opacity-75">
                        Sistem Informasi Desa membantu pemerintah desa dalam pelayanan masyarakat,
                        pengelolaan data, dan transparansi pembangunan.
                    </p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Navigasi</h5>
                    <ul class="list-unstyled">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/contact-us">Kontak</a></li>
                        <li><a href="#">Data Desa</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3">Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li><i class="ti ti-map-pin me-2"></i> Balai Desa Waru</li>
                        <li><i class="ti ti-mail me-2"></i>kelmedaeng@gmail.com</li>
                        <li><i class="ti ti-phone me-2"></i> 08999050200</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center py-3">
            <small>© {{ date('Y') }} Sistem Informasi Desa. Seluruh hak cipta dilindungi.</small>
        </div>
    </footer>

    <!-- JS -->
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
</body>

</html>
