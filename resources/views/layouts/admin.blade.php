<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin Dashboard') | QuickTech Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/quicktech-icon.png') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('admin_assets/js/config.js') }}"></script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vendor css -->
    <link href="{{ asset('admin_assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('admin_assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('admin_assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            background-color: #f8fafc !important;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .page-title-box {
            margin-bottom: 24px;
        }
        .card {
            border: 1px solid #eef2f6 !important;
            border-radius: 16px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03), 0 6px 16px -2px rgba(15, 23, 42, 0.04) !important;
            transition: all 0.25s ease;
        }
        .table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #64748b;
            background-color: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }
        .table td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
        }
        .side-nav .side-nav-link.active {
            background: rgba(37, 99, 235, 0.08) !important;
            color: #2563eb !important;
            font-weight: 600;
            border-radius: 10px;
        }
        .side-nav .side-nav-link.active .menu-icon i {
            color: #2563eb !important;
        }
        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13.5px;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
        }
        .btn-icon.btn-sm {
            width: 32px;
            height: 32px;
            font-size: 15px;
        }
        .order-badge-pill {
            font-size: 11.5px;
            padding: 5px 12px;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
    </style>
    @yield('styles')
    <link href="{{ asset('css/border-radius.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- Sidenav Menu Start -->
        <div class="sidenav-menu">
    <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="logo py-2">
                <span class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('images/quicktech-logo-light.png') }}" alt="QuickTech Cambodia" class="mt-2" style="height: 42px; max-width: 190px; object-fit: contain;">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('images/quicktech-icon-gold.png') }}" alt="QuickTech" class="mt-2" style="height: 34px; width: 34px; object-fit: contain;">
                    </span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('images/quicktech-logo-light.png') }}" alt="QuickTech Cambodia" class="mt-2" style="height: 42px; max-width: 190px; object-fit: contain;">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('images/quicktech-icon-gold.png') }}" alt="QuickTech" class="mt-2" style="height: 34px; width: 34px; object-fit: contain;">
                    </span>
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <button class="button-sm-hover">
                <i class="ti ti-circle align-middle"></i>
            </button>

            <!-- Full Sidebar Menu Close Button -->
            <button class="button-close-fullsidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            <div data-simplebar>
                <!--- Sidenav Menu -->
                <ul class="side-nav">
                    <li class="side-nav-title">Management</li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="side-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="side-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-shopping-cart"></i></span>
                            <span class="menu-text"> Orders & Confirm </span>
                            @php
                                $pendingOrderCount = \App\Models\Order::where('order_status', 'pending')->count();
                            @endphp
                            @if($pendingOrderCount > 0)
                                <span class="badge bg-warning rounded-pill">{{ $pendingOrderCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.products.index') }}" class="side-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-package"></i></span>
                            <span class="menu-text"> Products </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.products.create') }}" class="side-nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-plus"></i></span>
                            <span class="menu-text"> Add Product </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="side-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-category"></i></span>
                            <span class="menu-text"> Categories </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.brands.index') }}" class="side-nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-tags"></i></span>
                            <span class="menu-text"> Brands </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="side-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-users"></i></span>
                            <span class="menu-text"> Customers </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.invoices.index') }}" class="side-nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-receipt"></i></span>
                            <span class="menu-text"> Invoices </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="side-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <span class="menu-icon"><i class="ti ti-settings"></i></span>
                            <span class="menu-text"> Store Settings </span>
                        </a>
                    </li>

                    <li class="side-nav-title mt-2">Frontend & Store</li>

                    <li class="side-nav-item">
                        <a href="{{ route('home') }}" target="_blank" class="side-nav-link text-info">
                            <span class="menu-icon"><i class="ti ti-external-link"></i></span>
                            <span class="menu-text"> View Store </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('track.order') }}" target="_blank" class="side-nav-link text-success">
                            <span class="menu-icon"><i class="ti ti-truck-delivery"></i></span>
                            <span class="menu-text"> Customer Tracker </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Sidenav Menu End -->

        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">
                    <!-- Sidenav Toggle Button -->
                    <button class="sidenav-toggle-button px-2">
                        <i class="ti ti-menu-2 fs-24"></i>
                    </button>
                    <span class="fw-bold d-none d-md-inline-block text-muted">QuickTech Management System</span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- Store Link Button -->
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="ti ti-world"></i> Open Website
                    </a>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-pill" type="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('admin_assets/images/users/avatar-1.jpg') }}" alt="user-image" class="rounded-circle" width="32">
                            <span class="d-none d-md-inline fw-semibold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><h6 class="dropdown-header">Admin Account</h6></li>
                            <li><span class="dropdown-item-text text-muted">{{ Auth::user()->email ?? 'admin@gmail.com' }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="ti ti-logout"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="page-content">
            <div class="page-container">

                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3 d-flex align-items-center gap-2" role="alert">
                        <i class="ti ti-circle-check fs-20"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3 d-flex align-items-center gap-2" role="alert">
                        <i class="ti ti-alert-triangle fs-20"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')

            </div>

            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            &copy; {{ date('Y') }} QuickTech Admin Panel.
                        </div>
                        <div class="col-md-6 text-center text-md-end text-muted">
                            QuickTech (Cambodia)
                        </div>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="{{ asset('admin_assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
