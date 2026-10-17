@extends('layouts.app')

@section('title', 'Shopping Cart | QuickTech Cambodia')

@section('content')
<div class="qt-page-head">
    <div class="container">
        @if(!empty($cart))
            <div class="mb-3">@include('frontend.partials.checkout-steps', ['current' => 1])</div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
        <h1>Shopping cart</h1>
    </div>
</div>

<div class="container py-4">
    @if(empty($cart))
        <div class="qt-card qt-empty">
            <div class="qt-empty__icon"><i class="fa-solid fa-bag-shopping"></i></div>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any laptops or components yet. Explore our latest products.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left fa-xs"></i> Start shopping</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="qt-card">
                    <div class="qt-card__head">
                        <h2 class="qt-card__title">{{ count($cart) }} {{ \Illuminate\Support\Str::plural('item', count($cart)) }}</h2>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Remove all items from your cart?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-light"><i class="fa-regular fa-trash-can"></i> Clear cart</button>
                        </form>
                    </div>

                    @foreach($cart as $id => $item)
                        <div class="qt-cart-item" id="cartRow-{{ $id }}">
                            <a href="{{ route('shop.show', $item['slug'] ?? '#') }}" class="qt-cart-item__img">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('shop.show', $item['slug'] ?? '#') }}" class="qt-cart-item__name">{{ $item['name'] }}</a>
                                <div class="qt-cart-item__meta">
                                    ${{ number_format($item['price'], 2) }} each
                                    @if(!empty($item['code'])) · SKU {{ $item['code'] }} @endif
                                </div>
                                <div class="qt-cart-item__controls">
                                    <div class="qt-qty qt-qty--sm">
                                        <button type="button" onclick="updateQty({{ $id }}, {{ $item['quantity'] - 1 }})" aria-label="Decrease quantity">−</button>
                                        <input type="text" value="{{ $item['quantity'] }}" readonly aria-label="Quantity">
                                        <button type="button" onclick="updateQty({{ $id }}, {{ $item['quantity'] + 1 }})" aria-label="Increase quantity">+</button>
                                    </div>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" class="qt-icon-btn" title="Remove" aria-label="Remove {{ $item['name'] }}"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="qt-cart-item__total" id="itemTotal-{{ $id }}">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('shop.index') }}" class="btn btn-light mt-3"><i class="fa-solid fa-arrow-left fa-xs"></i> Continue shopping</a>
            </div>

            <div class="col-lg-4">
                <aside class="qt-card qt-card__body qt-summary">
                    <h2 class="qt-card__title mb-3">Order summary</h2>

                    <div class="qt-summary__row"><span>Subtotal</span><strong id="cartSubtotalText">${{ number_format($subtotal, 2) }}</strong></div>
                    <div class="qt-summary__row"><span>Delivery</span><strong class="text-muted fw-normal">Calculated at checkout</strong></div>

                    <div class="qt-summary__total">
                        <span>Total</span>
                        <strong id="cartGrandTotalText">${{ number_format($subtotal, 2) }}</strong>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 mt-4">
                        Proceed to checkout <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>

                    <div class="d-flex gap-2 align-items-start mt-3 p-3 rounded-3" style="background: var(--qt-bg); font-size: 12.5px;">
                        <i class="fa-solid fa-truck-fast mt-1" style="color: var(--qt-gold-600)"></i>
                        <span class="text-muted">Delivery across Phnom Penh &amp; 24 provinces via Virak Buntham &amp; J&amp;T.</span>
                    </div>

                    <div class="text-center mt-3">
                        <div class="small text-muted mb-2">We accept</div>
                        <div class="qt-pay-icons">
                            <span>KHQR</span><span>ABA</span><span>ACLEDA</span><span>WING</span><span>COD</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function updateQty(productId, qty) {
        if (qty < 1 && !confirm('Remove this item from your cart?')) return;
        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", product_id: productId, quantity: qty },
            success: function () { location.reload(); }
        });
    }
</script>
@endsection
