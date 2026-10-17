@extends('layouts.app')

@section('title', 'Page Not Found | QuickTech Cambodia')

@section('content')
<section class="container py-5">
    <div class="qt-card qt-empty mx-auto" style="max-width: 640px;">
        <div class="qt-empty__icon"><i class="fa-solid fa-compass"></i></div>
        <span class="qt-eyebrow">Error 404</span>
        <h1 class="h3 mt-2">We couldn't find that page</h1>
        <p>The link may be outdated or the page may have moved. Try searching the catalog instead.</p>
        <form action="{{ route('shop.index') }}" method="GET" class="qt-search mx-auto mb-4" role="search">
            <i class="fa-solid fa-magnifying-glass qt-search__icon"></i>
            <input type="search" name="search" placeholder="Search laptops, PCs, parts..." aria-label="Search products">
            <button type="submit" class="qt-search__btn" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
        </form>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-primary">Back to home</a>
            <a href="{{ route('shop.index') }}" class="btn btn-light">Browse products</a>
        </div>
    </div>
</section>
@endsection
