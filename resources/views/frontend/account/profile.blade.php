@extends('layouts.app')

@section('title', 'Profile & Security | QuickTech Cambodia')

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account.index') }}">My account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <h1>Profile &amp; security</h1>
        <p>Your details are used to pre-fill checkout.</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3 order-2 order-lg-1">@include('frontend.account._nav')</div>

        <div class="col-lg-9 order-1 order-lg-2 d-flex flex-column gap-3">
            <section class="qt-card">
                <div class="qt-card__head">
                    <h2 class="qt-card__title">Personal information</h2>
                </div>
                <form action="{{ route('account.profile.update') }}" method="POST" class="qt-card__body">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Full name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="012 345 678" autocomplete="tel">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </section>

            <section class="qt-card">
                <div class="qt-card__head">
                    <h2 class="qt-card__title">Change password</h2>
                </div>
                <form action="{{ route('account.password.update') }}" method="POST" class="qt-card__body">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="current_password">Current password</label>
                            <div class="qt-pw">
                                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                                <button type="button" class="qt-pw__toggle" data-toggle-password="current_password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
                            </div>
                            @error('current_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password">New password</label>
                            <div class="qt-pw">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="At least 8 characters" required minlength="8" autocomplete="new-password">
                                <button type="button" class="qt-pw__toggle" data-toggle-password="password" aria-label="Show password"><i class="fa-regular fa-eye"></i></button>
                            </div>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password_confirmation">Confirm new password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary">Update password</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('frontend.account._password-toggle')
@endsection
