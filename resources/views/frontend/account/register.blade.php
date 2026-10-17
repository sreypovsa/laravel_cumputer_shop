@extends('layouts.app')

@section('title', 'Create Account | QuickTech Cambodia')

@section('content')
<div class="container py-4 py-lg-5">
    <div class="qt-card qt-auth">
        @include('frontend.account._auth-aside', ['headline' => 'Join QuickTech'])

        <div class="qt-auth__form">
            <h1>Create your account</h1>
            <p class="text-muted mb-4">It only takes a minute.</p>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Sokha Mean" required autofocus autocomplete="name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="email">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="phone">Phone <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="012 345 678" autocomplete="tel">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="password">Password</label>
                        <div class="qt-pw">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="At least 8 characters" required minlength="8" autocomplete="new-password">
                            <button type="button" class="qt-pw__toggle" data-toggle-password="password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
                        </div>
                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repeat password" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                    <label class="form-check-label small" for="terms">I agree to the terms of sale and privacy policy</label>
                    @error('terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Create account</button>
            </form>

            <p class="qt-auth__switch">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('frontend.account._password-toggle')
@endsection
