@extends('layouts.app')

@section('title', 'Sign In | QuickTech Cambodia')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="qt-card qt-auth">
        @include('frontend.account._auth-aside', ['headline' => 'Welcome back'])

        <div class="qt-auth__form">
            <h1>Sign in</h1>
            <p class="text-muted mb-4">Enter your email and password to access your account.</p>

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="qt-pw">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your password" required autocomplete="current-password">
                        <button type="button" class="qt-pw__toggle" data-toggle-password="password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Sign in</button>
            </form>

            <div class="qt-divider">or</div>
            <a href="{{ route('track.order') }}" class="btn btn-light w-100"><i class="fa-solid fa-location-crosshairs"></i> Track an order without signing in</a>

            <p class="qt-auth__switch">New to QuickTech? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('frontend.account._password-toggle')
@endsection
