@extends('layouts.app')

@section('title', 'Shop Laptops, PCs & Parts | QuickTech Cambodia')

@php
    $activeCategory = $categories->firstWhere('slug', request('category'));
    $activeBrand = $brands->firstWhere('slug', request('brand'));
    $pageTitle = $activeCategory->name ?? ($activeBrand->name ?? (request('search') ? 'Results for "' . request('search') . '"' : 'All products'));
    $hasFilters = request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']);
@endphp

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item {{ $hasFilters ? '' : 'active' }}">
                    @if($hasFilters)<a href="{{ route('shop.index') }}">Shop</a>@else Shop @endif
                </li>
                @if($hasFilters)
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                @endif
            </ol>
        </nav>
        <h1>{{ $pageTitle }}</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <!-- FILTERS -->
        <div class="col-lg-3">
            <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="shopFilters" aria-labelledby="shopFiltersLabel">
                <div class="offcanvas-header border-bottom">
                    <h2 class="h5 mb-0" id="shopFiltersLabel">Filters</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#shopFilters" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0 d-block">
                    <aside class="qt-card qt-filter w-100">
                        <div class="qt-filter__group d-flex align-items-center justify-content-between">
                            <span class="fw-bold text-dark"><i class="fa-solid fa-sliders me-2" style="color: var(--qt-gold-600)"></i>Filters</span>
                            @if($hasFilters)
                                <a href="{{ route('shop.index') }}" class="small fw-semibold" style="color: var(--qt-sale)">Clear all</a>
                            @endif
                        </div>

                        <div class="qt-filter__group">
                            <form action="{{ route('shop.index') }}" method="GET">
                                @foreach(['category', 'brand', 'sort'] as $keep)
                                    @if(request($keep)) <input type="hidden" name="{{ $keep }}" value="{{ request($keep) }}"> @endif
                                @endforeach
                                <div class="position-relative">
                                    <input type="text" name="search" class="form-control form-control-sm pe-5" placeholder="Search in results..." value="{{ request('search') }}" aria-label="Search">
                                    <button class="btn btn-sm position-absolute top-50 end-0 translate-middle-y text-muted" type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="qt-filter__group">
                            <div class="qt-filter__title">Category</div>
                            <div class="qt-filter__list">
                                <a href="{{ route('shop.index', request()->except(['category', 'page'])) }}" class="qt-filter__item {{ !request('category') ? 'is-active' : '' }}">All categories</a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('shop.index', array_merge(request()->except(['page']), ['category' => $cat->slug])) }}" class="qt-filter__item {{ request('category') == $cat->slug ? 'is-active' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="qt-filter__count">{{ $cat->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="qt-filter__group">
                            <div class="qt-filter__title">Brand</div>
                            <div class="qt-filter__list">
                                <a href="{{ route('shop.index', request()->except(['brand', 'page'])) }}" class="qt-filter__item {{ !request('brand') ? 'is-active' : '' }}">All brands</a>
                                @foreach($brands as $brand)
                                    <a href="{{ route('shop.index', array_merge(request()->except(['page']), ['brand' => $brand->slug])) }}" class="qt-filter__item {{ request('brand') == $brand->slug ? 'is-active' : '' }}">
                                        <span>{{ $brand->name }}</span>
                                        <span class="qt-filter__count">{{ $brand->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="qt-filter__group">
                            <div class="qt-filter__title">Price (USD)</div>
                            <form action="{{ route('shop.index') }}" method="GET">
                                @foreach(['search', 'category', 'brand', 'sort'] as $keep)
                                    @if(request($keep)) <input type="hidden" name="{{ $keep }}" value="{{ request($keep) }}"> @endif
                                @endforeach
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}" min="0" aria-label="Minimum price">
                                    <span class="text-muted">–</span>
                                    <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}" min="0" aria-label="Maximum price">
                                </div>
                                <div class="qt-chips mb-3">
                                    @foreach([[0, 500], [500, 1000], [1000, 2000]] as [$min, $max])
                                        <a href="{{ route('shop.index', array_merge(request()->except(['page', 'min_price', 'max_price']), ['min_price' => $min, 'max_price' => $max])) }}" class="qt-chip {{ request('min_price') == $min && request('max_price') == $max ? 'is-active' : '' }}" style="height: 28px; font-size: 12px;">${{ $min }}–{{ $max }}</a>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Apply</button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <!-- RESULTS -->
        <div class="col-lg-9">
            <div class="qt-toolbar">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <button class="btn btn-light btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopFilters" aria-controls="shopFilters">
                        <i class="fa-solid fa-sliders"></i> Filters
                    </button>
                    <span class="qt-toolbar__count">
                        Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong>
                    </span>
                    @if($activeCategory)
                        <span class="qt-active-filter">{{ $activeCategory->name }} <a href="{{ route('shop.index', request()->except(['category', 'page'])) }}" aria-label="Remove category filter"><i class="fa-solid fa-xmark"></i></a></span>
                    @endif
                    @if($activeBrand)
                        <span class="qt-active-filter">{{ $activeBrand->name }} <a href="{{ route('shop.index', request()->except(['brand', 'page'])) }}" aria-label="Remove brand filter"><i class="fa-solid fa-xmark"></i></a></span>
                    @endif
                    @if(request('search'))
                        <span class="qt-active-filter">"{{ request('search') }}" <a href="{{ route('shop.index', request()->except(['search', 'page'])) }}" aria-label="Remove search"><i class="fa-solid fa-xmark"></i></a></span>
                    @endif
                    @if(request('min_price') || request('max_price'))
                        <span class="qt-active-filter">${{ request('min_price', 0) }}–{{ request('max_price', '∞') }} <a href="{{ route('shop.index', request()->except(['min_price', 'max_price', 'page'])) }}" aria-label="Remove price filter"><i class="fa-solid fa-xmark"></i></a></span>
                    @endif
                </div>

                <form action="{{ route('shop.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    @foreach(['search', 'category', 'brand', 'min_price', 'max_price'] as $keep)
                        @if(request($keep)) <input type="hidden" name="{{ $keep }}" value="{{ request($keep) }}"> @endif
                    @endforeach
                    <label for="sortSelect" class="small text-muted text-nowrap mb-0">Sort by</label>
                    <select id="sortSelect" name="sort" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A–Z)</option>
                    </select>
                </form>
            </div>

            @if($products->isEmpty())
                <div class="qt-card qt-empty">
                    <div class="qt-empty__icon"><i class="fa-solid fa-box-open"></i></div>
                    <h3>No products match your filters</h3>
                    <p>Try removing a filter or searching with a different keyword.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse all products</a>
                </div>
            @else
                <div class="qt-grid qt-grid--3">
                    @foreach($products as $product)
                        @include('frontend.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
