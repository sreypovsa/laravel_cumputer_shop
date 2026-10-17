@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' | QuickTech Cambodia')

@php
    $awaitingQr = $order->payment_status === 'pending' && in_array($order->payment_method, ['aba_khqr', 'acleda_khqr', 'wing_khqr']) && !$order->payment_slip;
@endphp

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('account.index') }}">My account</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_number }}</li>
            </ol>
        </nav>
        <div class="d-flex flex-wrap align-items-center gap-3 mt-1">
            <h1 class="m-0">Order #{{ $order->order_number }}</h1>
            @include('frontend.partials.status-badge', ['status' => $order->order_status])
        </div>
        <p>Placed {{ $order->created_at->format('d M Y, h:i A') }} · Tracking code <strong style="color: var(--qt-gold-600)">{{ $order->tracking_code }}</strong></p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3 order-2 order-lg-1">@include('frontend.account._nav')</div>

        <div class="col-lg-9 order-1 order-lg-2 d-flex flex-column gap-3">
            @if($awaitingQr)
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 rounded-3" style="background: var(--qt-gold-100); border: 1px solid #ecdcb5;">
                    <div class="d-flex align-items-center gap-2 small" style="color: #7a5d1f;">
                        <i class="fa-solid fa-qrcode"></i> This order is waiting for your KHQR payment.
                    </div>
                    <a href="{{ route('payment.show', $order->order_number) }}" class="btn btn-gold btn-sm">Pay now</a>
                </div>
            @endif

            <section class="qt-card qt-card__body">
                @include('frontend.partials.order-timeline', ['order' => $order])
            </section>

            <section class="qt-card">
                <div class="qt-card__head">
                    <h2 class="qt-card__title"><i class="fa-solid fa-boxes-stacked" style="color: var(--qt-gold-600)"></i> Items</h2>
                </div>
                <div class="px-4">
                    @foreach($order->items as $item)
                        <div class="qt-mini-item">
                            <div class="qt-mini-item__img">
                                @if($item->product_image)<img src="{{ $item->product_image }}" alt="{{ $item->product_name }}">@endif
                                <span class="qt-mini-item__qty">{{ $item->quantity }}</span>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="qt-mini-item__name">{{ $item->product_name }}</div>
                                <div class="small text-muted">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                            </div>
                            <strong class="text-dark text-nowrap">${{ number_format($item->total, 2) }}</strong>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="row g-3">
                <div class="col-md-6">
                    <section class="qt-card qt-card__body h-100">
                        <h3 class="qt-card__title mb-3"><i class="fa-solid fa-location-dot" style="color: var(--qt-gold-600)"></i> Delivery</h3>
                        <dl class="qt-kv mb-0">
                            <dt>Recipient</dt><dd>{{ $order->customer_name }}</dd>
                            <dt>Phone</dt><dd>{{ $order->customer_phone }}</dd>
                            <dt>Address</dt><dd>{{ $order->delivery_address }}, {{ $order->delivery_province }}</dd>
                            <dt>Courier</dt><dd>{{ $order->delivery_carrier }}</dd>
                            @if($order->courier_tracking_number)
                                <dt>Courier tracking</dt><dd><span class="qt-tag qt-tag--success">{{ $order->courier_tracking_number }}</span></dd>
                            @endif
                        </dl>
                    </section>
                </div>
                <div class="col-md-6">
                    <section class="qt-card qt-card__body h-100">
                        <h3 class="qt-card__title mb-3"><i class="fa-solid fa-credit-card" style="color: var(--qt-gold-600)"></i> Payment</h3>
                        <dl class="qt-kv mb-0">
                            <dt>Method</dt><dd>{{ $order->payment_method_name }}</dd>
                            <dt>Status</dt><dd>@include('frontend.partials.status-badge', ['status' => $order->payment_status, 'label' => $order->payment_status === 'pending' ? 'Awaiting payment' : null])</dd>
                            <dt>Subtotal</dt><dd>${{ number_format($order->subtotal, 2) }}</dd>
                            <dt>Delivery fee</dt><dd>${{ number_format($order->shipping_fee, 2) }}</dd>
                        </dl>
                        <div class="qt-summary__total"><span>Total</span><strong>${{ number_format($order->total, 2) }}</strong></div>
                    </section>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('account.index') }}" class="btn btn-light"><i class="fa-solid fa-arrow-left fa-xs"></i> All orders</a>
                <a href="https://t.me/QUICKTECHCAM?text={{ urlencode('Hello QuickTech, I have a question about order #' . $order->order_number) }}" target="_blank" rel="noopener" class="btn btn-telegram"><i class="fa-brands fa-telegram"></i> Ask about this order</a>
            </div>
        </div>
    </div>
</div>
@endsection
