@extends('layouts.app')

@section('title', $product->name . ' | QuickTech Cambodia')

@php
    $isSale = $product->original_price && $product->original_price > $product->price;
    $tgText = urlencode('Hello QuickTech, I want to order: ' . $product->name . ' ($' . number_format($product->price, 0) . ') - Code: ' . ($product->code ?? $product->slug));
@endphp

@section('content')
<div class="qt-page-head py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-truncate" style="max-width: 320px;" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container qt-pd">
    <div class="row g-4 align-items-start">
        <!-- GALLERY -->
        <div class="col-lg-6">
            <section class="qt-card qt-pd__gallery" aria-label="Product image">
                <div class="qt-pd__stage">
                    @if($product->discount_percent)
                        <span class="qt-tag qt-tag--sale">Save {{ $product->discount_percent }}%</span>
                    @endif
                    <img id="mainProductImage" src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('images/mock-laptop-1.png') }}';">
                </div>
                <div class="qt-pd__perks">
                    <div class="qt-pd__perk"><i class="fa-solid fa-shield-halved"></i> Genuine, official warranty</div>
                    <div class="qt-pd__perk"><i class="fa-solid fa-truck-fast"></i> Fast nationwide delivery</div>
                    <div class="qt-pd__perk"><i class="fa-solid fa-qrcode"></i> ABA, ACLEDA &amp; Wing KHQR</div>
                    <div class="qt-pd__perk"><i class="fa-solid fa-gift"></i> Complimentary gift pack</div>
                </div>
            </section>
        </div>

        <!-- INFO -->
        <div class="col-lg-6">
            <section class="qt-card qt-card__body" aria-labelledby="productTitle">
                <div class="qt-pd__tags">
                    @if($product->brand)
                        <a href="{{ route('shop.index', ['brand' => $product->brand->slug]) }}" class="qt-tag qt-tag--hot">{{ $product->brand->name }}</a>
                    @endif
                    @if($product->category)
                        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="qt-tag qt-tag--soft">{{ $product->category->name }}</a>
                    @endif
                    @if($product->price >= 800 || !empty($product->is_featured))
                        <span class="qt-tag qt-tag--gold"><i class="fa-solid fa-crown"></i> Premium</span>
                    @endif
                </div>

                <h1 id="productTitle" class="qt-pd__title">{{ $product->name }}</h1>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    @if($product->code)
                        <span class="qt-pd__code">SKU: <strong>{{ $product->code }}</strong></span>
                    @endif
                    <span class="qt-stock">In stock</span>
                </div>

                <div class="qt-pd__price" aria-label="Price">
                    <span class="qt-pd__price-now {{ $isSale ? 'is-sale' : '' }}">${{ number_format($product->price, 0) }}</span>
                    @if($isSale)
                        <span class="qt-pd__price-old">${{ number_format($product->original_price, 0) }}</span>
                        <span class="qt-tag qt-tag--sale">You save ${{ number_format($product->original_price - $product->price, 0) }}</span>
                    @endif
                </div>

                <div class="qt-pd__gift">
                    <span class="qt-pd__gift-icon"><i class="fa-solid fa-gift"></i></span>
                    <div>
                        <strong>Free gifts included</strong>
                        <span>{{ $product->free_gifts ?: 'Backpack, wireless mouse, mousepad & cleaning kit' }}</span>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="form-label mb-0" for="qtyInput">Quantity</label>
                        <div class="qt-qty">
                            <button type="button" aria-label="Decrease quantity" onclick="stepQty(-1)">−</button>
                            <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="50">
                            <button type="button" aria-label="Increase quantity" onclick="stepQty(1)">+</button>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fa-solid fa-cart-plus"></i> Add to cart
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" name="buy_now" value="1" class="btn btn-primary btn-lg w-100">
                                <i class="fa-solid fa-bolt"></i> Buy now
                            </button>
                        </div>
                    </div>
                    <a href="https://t.me/QUICKTECHCAM?text={{ $tgText }}" target="_blank" rel="noopener" class="btn btn-telegram w-100">
                        <i class="fa-brands fa-telegram"></i> Order via Telegram
                    </a>
                </form>

                <hr class="my-4" style="border-color: var(--qt-border); opacity: 1;">

                <h2 class="h6 mb-3"><i class="fa-solid fa-truck-fast me-2" style="color: var(--qt-gold-600)"></i>Delivery &amp; support</h2>
                <ul class="qt-list-check">
                    <li><i class="fa-solid fa-check"></i><span><strong class="text-dark">Phnom Penh:</strong> express delivery within 2–4 hours</span></li>
                    <li><i class="fa-solid fa-check"></i><span><strong class="text-dark">Provinces:</strong> via Virak Buntham (VET) &amp; J&amp;T Express</span></li>
                    <li><i class="fa-solid fa-check"></i><span><strong class="text-dark">Payment:</strong> ABA KHQR, ACLEDA, Wing or cash on delivery</span></li>
                </ul>
            </section>

            <section class="qt-card mt-3" aria-labelledby="productSpecsTitle">
                <div class="qt-card__head">
                    <h2 id="productSpecsTitle" class="qt-card__title"><i class="fa-solid fa-list-check" style="color: var(--qt-gold-600)"></i> Specifications</h2>
                </div>
                @if(!empty($product->specs))
                    <table class="qt-spec-table">
                        <tbody>
                            @foreach($product->specs_list as $line)
                                @if(str_contains($line, ':'))
                                    @php [$key, $val] = explode(':', $line, 2); @endphp
                                    <tr>
                                        <th scope="row">{{ trim(ltrim($key, "- \t")) }}</th>
                                        <td>{{ trim($val) }}</td>
                                    </tr>
                                @else
                                    <tr><td colspan="2">{{ trim(ltrim($line, "- \t")) }}</td></tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted small mb-0 p-4">Official specifications from the authorized distributor. Contact us on Telegram for full details.</p>
                @endif
            </section>
        </div>
    </div>

    @if($relatedProducts->isNotEmpty())
        <section class="qt-section" aria-labelledby="relatedProductsTitle">
            <div class="qt-sec-head">
                <div>
                    <span class="qt-eyebrow">More to explore</span>
                    <h2 id="relatedProductsTitle">You may also like</h2>
                </div>
                @if($product->category)
                    <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="qt-link-more">View all <i class="fa-solid fa-arrow-right"></i></a>
                @endif
            </div>
            <div class="qt-grid">
                @foreach($relatedProducts as $rel)
                    @include('frontend.partials.product-card', ['product' => $rel])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function stepQty(delta) {
        const q = document.getElementById('qtyInput');
        q.value = Math.min(50, Math.max(1, (parseInt(q.value, 10) || 1) + delta));
    }
</script>
@endsection
