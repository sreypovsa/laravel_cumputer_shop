@extends('layouts.app')

@section('title', 'Order Confirmed | Order #' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="qt-card qt-card__body mx-auto text-center" style="max-width: 640px; padding: 40px 28px;">
        <div class="qt-success-icon"><i class="fa-solid fa-check"></i></div>
        <h1 class="h3 mb-2">Thank you for your order!</h1>
        <p class="text-muted mb-4">We've received your order and are preparing it for delivery. Save your tracking code to follow its progress.</p>

        <div class="qt-ref mb-4">
            <div><small>Order number</small><strong>{{ $order->order_number }}</strong></div>
            <div><small>Tracking code</small><strong style="color: var(--qt-gold-600)">{{ $order->tracking_code }}</strong></div>
            <div><small>Customer</small><strong>{{ $order->customer_name }}</strong> <span class="text-muted small">· {{ $order->customer_phone }}</span></div>
            <div><small>Total</small><strong style="color: var(--qt-navy)">${{ number_format($order->total, 2) }}</strong></div>
            <div>
                <small>Payment</small>
                <strong>{{ $order->payment_method_name }}</strong>
                @if($order->payment_status === 'paid')
                    <span class="qt-tag qt-tag--success ms-1">Paid</span>
                @else
                    <span class="qt-tag qt-tag--gold ms-1">Pending</span>
                @endif
            </div>
            <div><small>Delivery</small><strong>{{ $order->delivery_carrier }}</strong></div>
            <div class="is-wide"><small>Delivery address</small><strong class="fw-semibold">{{ $order->delivery_address }}, {{ $order->delivery_province }}</strong></div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
            <a href="{{ route('track.order.code', $order->tracking_code) }}" class="btn btn-primary btn-lg"><i class="fa-solid fa-location-crosshairs"></i> Track my order</a>
            <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg">Continue shopping</a>
        </div>

        <p class="text-muted small mt-4 mb-0">
            Need help? Message us on <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" class="fw-semibold text-primary">Telegram</a> or call <strong class="text-dark">015 646 581</strong>.
        </p>
    </div>
</div>
@endsection
