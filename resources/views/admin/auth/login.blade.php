<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin Login | QuickTech Cambodia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/quicktech-icon.png') }}">

    <!-- Vendor css -->
    <link href="{{ asset('admin_assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('admin_assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('admin_assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/border-radius.css') }}" rel="stylesheet">
</head>

<body class="authentication-bg bg-primary-subtle d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="bg-primary p-4 text-center text-white">
                        <img src="{{ asset('images/quicktech-logo-light.png') }}" alt="QuickTech Cambodia" style="height: 44px; max-width: 220px; object-fit: contain; background: transparent;" class="mb-3">
                        <h4 class="fw-bold mb-1">QUICKTECH ADMIN</h4>
                        <p class="mb-0 text-white-50 fs-13">Computer Store Management Portal</p>
                    </div>

                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger py-2 fs-13 mb-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success py-2 fs-13 mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fs-13 fw-semibold">Email Address</label>
                                <input type="email" name="email" id="loginEmail" class="form-control @error('email') is-invalid @enderror" placeholder="admin@gmail.com" value="{{ old('email', 'admin@gmail.com') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fs-13 fw-semibold">Password</label>
                                <input type="password" name="password" id="loginPassword" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" value="admin123" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
                                <label class="form-check-label fs-13 text-muted" for="remember">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-3">
                                <i class="ti ti-login me-1"></i> Sign In to Dashboard
                            </button>
                        </form>

                        <!-- Demo credentials helper -->
                        <div class="mt-4 p-3 bg-light rounded-3 border text-center fs-12 text-muted">
                            <strong>Demo Admin Credentials:</strong><br>
                            Email: <code>admin@gmail.com</code> | Pass: <code>admin123</code>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="fs-13 text-muted text-decoration-none">
                                &larr; Return to Customer Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
