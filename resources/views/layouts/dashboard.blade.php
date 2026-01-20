<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->

    <head>
        <title>@yield('title')</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description"
            content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
        <meta name="keywords"
            content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
        <meta name="author" content="CodedThemes">

        <!-- [Favicon] icon -->

        <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
        <!-- [Google Font] Family -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
            id="main-font-link">
        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
        <!-- [Mobile Responsive CSS] -->
        <link rel="stylesheet" href="{{ asset('assets/css/mobile-responsive.css') }}">
        
        <!-- Custom Notification Styles -->
        <style>
            /* Sidebar General Styles */
            .pc-sidebar {
                transition: all 0.3s ease;
                border-right: 2px solid rgba(0, 0, 0, 0.05);
            }

            .pc-sidebar .navbar-wrapper {
                padding-top: 0;
            }

            .pc-sidebar .pc-navbar {
                padding: 1rem 0;
            }

            .list-group-item-action {
                transition: background-color 0.2s ease;
            }
            
            .list-group-item-action:hover {
                background-color: #f8f9fa;
            }
            
            .avatar-icon {
                cursor: default;
            }
            
            .avatar-icon:hover {
                transform: scale(1.05) !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
            }

            /* Smooth scrolling untuk sidebar */
            .pc-sidebar .navbar-content {
                scroll-behavior: smooth;
            }

            /* Hover effect untuk sidebar items */
            .pc-navbar .pc-item {
                position: relative;
                overflow: hidden;
            }

            .pc-navbar .pc-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.1);
                transition: left 0.3s ease;
                z-index: 0;
            }

            .pc-navbar .pc-item:hover::before {
                left: 0;
            }

            .pc-navbar .pc-item .pc-link {
                position: relative;
                z-index: 1;
            }

            /* Active indicator line */
            .pc-navbar .pc-item.active::after {
                content: '';
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 60%;
                background: currentColor;
                border-radius: 2px 0 0 2px;
                opacity: 0.8;
            }

            /* Mobile-specific improvements */
            @media (max-width: 768px) {
                .pc-header {
                    padding: 10px 15px !important;
                }
                
                .pc-head-link {
                    padding: 8px 10px !important;
                }
                
                .header-search {
                    display: none !important;
                }
                
                .pc-h-item {
                    margin: 0 6px !important;
                }

                .pc-sidebar .m-header {
                    padding: 1rem 0.75rem !important;
                }

                .pc-sidebar .b-brand {
                    font-size: 1.1rem !important;
                }

                .pc-navbar .pc-item .pc-mtext {
                    font-size: 0.85rem !important;
                }
            }
            
            @media (max-width: 576px) {
                body {
                    font-size: 13px;
                }
                
                .pc-header {
                    padding: 8px 12px !important;
                }
                
                .pc-head-link {
                    padding: 6px 8px !important;
                    font-size: 1.1rem;
                }
                
                .user-avtar {
                    width: 32px !important;
                    height: 32px !important;
                }
                
                .navbar-wrapper {
                    gap: 8px !important;
                }

                .pc-sidebar .m-header {
                    padding: 0.75rem !important;
                }

                .pc-navbar .pc-item {
                    margin: 0.35rem 0.5rem !important;
                }
            }

            /* Scrollbar styling */
            .pc-sidebar .navbar-content::-webkit-scrollbar {
                width: 6px;
            }

            .pc-sidebar .navbar-content::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.05);
                border-radius: 10px;
            }

            .pc-sidebar .navbar-content::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.2);
                border-radius: 10px;
            }

            .pc-sidebar .navbar-content::-webkit-scrollbar-thumb:hover {
                background: rgba(0, 0, 0, 0.3);
            }
        </style>

    </head>
    <!-- [Head] end -->
    <!-- [Body] Start -->

    <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->
        <!-- [ Sidebar Menu ] start -->
        <nav class="pc-sidebar">
            <div class="navbar-wrapper">
                <div class="m-header justify-content-center">
                    <a href="/" class="b-brand text-dark text-capitalize fw-bold">
                        <!-- ========   Change your logo from here   ============ -->
                        <span class="fs-4">{{ auth()->user()->role }} Dashboard</span>
                    </a>
                </div>
                <div class="navbar-content">
                    <ul class="pc-navbar">
                        <li class="pc-item {{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                                <span class="pc-mtext">Dashboard</span>
                            </a>
                        </li>
                        @if (auth()->user()->role === 'admin')
                            @include('admin.sidebar')
                        @else
                            @include('user.sidebar')
                        @endif




                </div>
            </div>
        </nav>
        <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
        <header class="pc-header">
            <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled">
                        <!-- ======= Menu collapse Icon ===== -->
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="dropdown pc-h-item d-inline-flex d-md-none">
                            <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ti ti-search"></i>
                            </a>
                            <div class="dropdown-menu pc-h-dropdown drp-search">
                                <form class="px-3">
                                    <div class="form-group mb-0 d-flex align-items-center">
                                        <i data-feather="search"></i>
                                        <input type="search" class="form-control border-0 shadow-none"
                                            placeholder="Search here. . .">
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="pc-h-item d-none d-md-inline-flex">
                            <form class="header-search">
                                <i data-feather="search" class="icon-search"></i>
                                <input type="search" class="form-control" placeholder="Search here. . .">
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- [Mobile Media Block end] -->
                <div class="ms-auto">
                    <ul class="list-unstyled">
                        <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ti ti-bell" style="font-size: 1.3rem; color: #1ba34a;"></i>
                                @if(isset($unreadNotifications) && $unreadNotifications && count($unreadNotifications) > 0)
                                    <span class="badge bg-danger rounded-circle position-absolute" style="top: 2px; right: 2px; font-size: 0.65rem; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">{{ count($unreadNotifications) }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0"><i class="ti ti-bell me-2" style="color: #1ba34a;"></i>Notifikasi</h5>
                                    <a href="#!" class="pc-head-link bg-transparent"><i
                                            class="ti ti-x text-danger"></i></a>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 215px)">
                                    <div class="list-group list-group-flush w-100">
                                        @if(isset($unreadNotifications) && $unreadNotifications && count($unreadNotifications) > 0)
                                            @foreach($unreadNotifications as $notification)
                                                <a href="{{ route('notifications.show', $notification->id) }}" class="list-group-item list-group-item-action" style="text-decoration: none; color: inherit;">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            @php
                                                                // Show user avatar for surat/pengaduan, admin avatar for biodata
                                                                if ($notification->related_type === 'biodata' && $notification->admin()) {
                                                                    $admin = $notification->admin();
                                                                    if ($admin->provider) {
                                                                        // SSO provider - use URL directly
                                                                        $avatarUrl = $admin->avatar;
                                                                    } else {
                                                                        // Local user - construct asset path
                                                                        $avatarUrl = asset('assets/images/user/' . ($admin->avatar ?? 'avatar-5.jpg'));
                                                                    }
                                                                    $showProfileImg = true;
                                                                } elseif (in_array($notification->related_type, ['surat', 'pengaduan']) && $notification->actor) {
                                                                    $actor = $notification->actor;
                                                                    if ($actor->provider) {
                                                                        // SSO provider - use URL directly
                                                                        $avatarUrl = $actor->avatar;
                                                                    } else {
                                                                        // Local user - construct asset path
                                                                        $avatarUrl = asset('assets/images/user/' . ($actor->avatar ?? 'avatar-5.jpg'));
                                                                    }
                                                                    $showProfileImg = true;
                                                                } else {
                                                                    $showProfileImg = false;
                                                                }
                                                            @endphp
                                                            @if($showProfileImg)
                                                                <img src="{{ $avatarUrl }}" alt="user-avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #1ba34a;">
                                                            @else
                                                                <div class="avatar-icon rounded-circle" style="
                                                                    width: 50px; 
                                                                    height: 50px; 
                                                                    display: flex; 
                                                                    align-items: center; 
                                                                    justify-content: center;
                                                                    background: {{ $notification->icon_bg_color }};
                                                                    color: {{ $notification->icon_text_color }};
                                                                    font-size: 1.6rem;
                                                                    font-weight: 600;
                                                                    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                                                                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                                                                ">
                                                                    {{ $notification->icon_emoji }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 ms-2">
                                                            <span class="float-end text-muted" style="font-size: 0.8rem;">{{ $notification->created_at->diffForHumans() }}</span>
                                                            <p class="text-body mb-1" style="font-weight: 600;">{{ $notification->title }}</p>
                                                            <span class="text-muted" style="font-size: 0.85rem;">{{ \Illuminate\Support\Str::limit($notification->message, 80) }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else
                                            <div class="px-3 py-4 text-center text-muted">
                                                <i class="ti ti-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                                <p class="mt-2 mb-0">Tidak ada notifikasi</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(isset($unreadNotifications) && $unreadNotifications && count($unreadNotifications) > 0)
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center py-2">
                                        <a href="#!" class="link-primary" style="font-size: 0.9rem;">Lihat semua notifikasi</a>
                                    </div>
                                @endif
                            </div>
                        </li>
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <img src="{{ $avatar }}" alt="user-image" class="user-avtar">
                                <span>{{ $name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header">
                                    <div class="d-flex mb-1 align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $avatar }}" alt="user-image"
                                                class="user-avtar wid-35">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $name }}</h6>
                                            <span>{{ $role }}</span>
                                        </div>

                                    </div>
                                </div>
                                <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                            data-bs-target="#drp-tab-1" type="button" role="tab"
                                            aria-controls="drp-tab-1" aria-selected="true"><i class="ti ti-user"></i>
                                            Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="drp-t2" data-bs-toggle="tab"
                                            data-bs-target="#drp-tab-2" type="button" role="tab"
                                            aria-controls="drp-tab-2" aria-selected="false"><i
                                                class="ti ti-settings"></i> Setting</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="mysrpTabContent">
                                    <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                        aria-labelledby="drp-t1" tabindex="0">

                                        <a href="/myprofile" class="dropdown-item">
                                            <i class="ti ti-user"></i>
                                            <span>My Profile</span>
                                        </a>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="ti ti-power"></i>
                                                <span>Logout</span>
                                            </button>
                                        </form>


                                    </div>
                                    <div class="tab-pane fade" id="drp-tab-2" role="tabpanel"
                                        aria-labelledby="drp-t2" tabindex="0">
                                        <a href="/contact-us" class="dropdown-item">
                                            <i class="ti ti-help"></i>
                                            <span>Support</span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- [ Header ] end -->



        <!-- [ Main Content ] start -->
        <div class="pc-container">
            @yield('content')
        </div>
        <!-- [ Main Content ] end -->
        <footer class="pc-footer">
            <!-- <div class="footer-wrapper container-fluid">
                <div class="row">
                    <div class="col-sm my-1">
                        <p class="m-0">Mantis &#9829; crafted by Team <a
                                href="https://themeforest.net/user/codedthemes" target="_blank">Codedthemes</a>
                            Distributed by <a href="https://themewagon.com/">ThemeWagon</a>.</p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-link mb-0">
                            <li class="list-inline-item"><a href="../index.html">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </footer>

        <!-- [Page Specific JS] start -->
        <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
        <!-- [Page Specific JS] end -->
        <!-- Required Js -->
        <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>





        <script>
            layout_change('light');
        </script>




        <script>
            change_box_container('false');
        </script>



        <script>
            layout_rtl_change('false');
        </script>


        <script>
            preset_change("preset-1");
        </script>


        <script>
            font_change("Public-Sans");
        </script>


        <script>
            if (window.location.hash === '#_=_') {
                history.replaceState(null, null, window.location.pathname);
            }
        </script>

        <!-- Notification Script -->
        <script>
            function markNotificationAsRead(notificationId) {
                fetch(`/api/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        </script>

        <!-- Mobile Responsive JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile menu toggle
                const menuToggle = document.querySelector('.navbar-toggler');
                const sidebar = document.querySelector('.pc-sidebar');
                
                if (menuToggle) {
                    menuToggle.addEventListener('click', function() {
                        sidebar.classList.toggle('show');
                        
                        // Create overlay if not exists
                        let overlay = document.querySelector('.sidebar-overlay');
                        if (!overlay) {
                            overlay = document.createElement('div');
                            overlay.className = 'sidebar-overlay';
                            document.body.appendChild(overlay);
                        }
                        overlay.classList.toggle('show');
                    });
                }
                
                // Close sidebar on overlay click
                const overlay = document.querySelector('.sidebar-overlay');
                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                    });
                }
                
                // Close sidebar when clicking on nav links
                const navLinks = document.querySelectorAll('.pc-sidebar .nav-link, .pc-sidebar a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('show');
                            if (overlay) overlay.classList.remove('show');
                        }
                    });
                });
                
                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('show');
                        if (overlay) overlay.classList.remove('show');
                    }
                });
            });
        </script>
    </body>
    <!-- [Body] end -->

</html>
