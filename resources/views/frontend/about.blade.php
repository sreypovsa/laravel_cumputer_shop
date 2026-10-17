@extends('layouts.app')

@section('title', 'About Us | QuickTech Cambodia')

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </nav>
        <h1>About QuickTech Cambodia</h1>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <span class="qt-eyebrow">Who we are</span>
            <h2 class="mt-2 mb-3">Genuine technology for gamers, creators &amp; professionals</h2>
            <p class="text-muted">
                QuickTech Cambodia is a computer store in Phnom Penh offering laptops, desktop PCs, custom gaming rigs, components and accessories.
            </p>
            <p class="text-muted">
                We work with leading brands including ASUS, ROG, MSI, Acer, Apple, Dell, Lenovo, HP, AMD and Intel. Every product comes with official warranty, friendly support and dedicated after-sales service.
            </p>
            <div class="row g-3 mt-2">
                <div class="col-6"><div class="qt-stat"><strong>1,200+</strong><span>Products in stock</span></div></div>
                <div class="col-6"><div class="qt-stat"><strong>25</strong><span>Provinces delivered</span></div></div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse products</a>
                <a href="{{ route('contact') }}" class="btn btn-light">Contact us</a>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="{{ asset('nevixra_assets/images/about-us-image.jpg') }}" alt="QuickTech Cambodia store" class="img-fluid w-100" style="border-radius: var(--qt-r-xl); box-shadow: var(--qt-shadow-lg);" onerror="this.src='{{ asset('nevixra_assets/images/hero-image.png') }}'">
        </div>
    </div>

    <div class="qt-trust mt-5">
        <div class="qt-trust__item"><span class="qt-trust__icon"><i class="fa-solid fa-shield-halved"></i></span><div><strong>Authorized products</strong><span>Official warranty</span></div></div>
        <div class="qt-trust__item"><span class="qt-trust__icon"><i class="fa-solid fa-screwdriver-wrench"></i></span><div><strong>After-sales service</strong><span>Setup &amp; maintenance</span></div></div>
        <div class="qt-trust__item"><span class="qt-trust__icon"><i class="fa-solid fa-truck-fast"></i></span><div><strong>Nationwide delivery</strong><span>All 25 provinces</span></div></div>
        <div class="qt-trust__item"><span class="qt-trust__icon"><i class="fa-solid fa-qrcode"></i></span><div><strong>Easy payment</strong><span>KHQR &amp; cash on delivery</span></div></div>
    </div>
</div>
@endsection
