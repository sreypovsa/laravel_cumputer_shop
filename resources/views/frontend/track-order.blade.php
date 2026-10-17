@extends('layouts.app')

@section('title', 'Track Your Order | QuickTech Cambodia')

@section('content')
<div class="qt-page-head text-center">
    <div class="container">
        <span class="qt-eyebrow">Order tracking</span>
        <h1>Where's my order?</h1>
        <p>Enter your order number, tracking code or phone number to see live delivery progress.</p>
    </div>
</div>

<div class="container py-4">
    <div class="qt-card qt-card__body mx-auto mb-4" style="max-width: 680px;">
        <form action="{{ route('track.order') }}" method="GET">
            <label class="form-label" for="trackCode">Order number, tracking code or phone</label>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <div class="position-relative flex-grow-1">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y text-muted" style="left: 14px; font-size: 13px;"></i>
                    <input type="text" id="trackCode" name="code" class="form-control" style="padding-left: 38px; min-height: 46px;" placeholder="e.g. TRK-982145 or 098 765 432" value="{{ $code }}">
                </div>
                <button class="btn btn-primary" type="submit" style="min-height: 46px;">Track order</button>
            </div>
        </form>

        @if(!empty($sampleTrackingCodes) && count($sampleTrackingCodes))
            <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3" style="border-top: 1px solid var(--qt-border);">
                <span class="small text-muted">Try a sample:</span>
                @foreach($sampleTrackingCodes as $ordNum => $trkCode)
                    <a href="{{ route('track.order', ['code' => $trkCode]) }}" class="qt-chip" style="height: 28px; font-size: 12px;">{{ $trkCode }}</a>
                @endforeach
            </div>
        @endif
    </div>

    @if($order)

        <div class="qt-card mb-4">
            <div class="qt-card__head flex-wrap">
                <div>
                    <h2 class="qt-card__title">Order #{{ $order->order_number }}</h2>
                    <span class="small text-muted">Tracking code <strong style="color: var(--qt-gold-600)">{{ $order->tracking_code }}</strong></span>
                </div>
                @include('frontend.partials.status-badge', ['status' => $order->order_status])
            </div>

            <div class="qt-card__body">
                @include('frontend.partials.order-timeline', ['order' => $order])
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <section class="qt-card qt-card__body h-100">
                    <h3 class="qt-card__title mb-3"><i class="fa-solid fa-location-dot" style="color: var(--qt-gold-600)"></i> Delivery</h3>
                    <dl class="qt-kv mb-0">
                        <dt>Recipient</dt><dd>{{ $order->customer_name }}</dd>
                        <dt>Phone</dt><dd>{{ $order->customer_phone }}</dd>
                        <dt>Province</dt><dd>{{ $order->delivery_province }}</dd>
                        <dt>Address</dt><dd>{{ $order->delivery_address }}</dd>
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
                    <div class="qt-summary__total">
                        <span>Total</span>
                        <strong>${{ number_format($order->total, 2) }}</strong>
                    </div>
                </section>
            </div>

            <div class="col-12">
                <section class="qt-card">
                    <div class="qt-card__head">
                        <h3 class="qt-card__title"><i class="fa-solid fa-boxes-stacked" style="color: var(--qt-gold-600)"></i> Items in this order</h3>
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
                                    <div class="small text-muted">${{ number_format($item->price, 2) }} × {{ $item->quantity }} @if($item->product_code) · {{ $item->product_code }} @endif</div>
                                </div>
                                <strong class="text-dark text-nowrap">${{ number_format($item->total, 2) }}</strong>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    @elseif(!empty($code))
        <div class="qt-card qt-empty mx-auto" style="max-width: 680px;">
            <div class="qt-empty__icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <h3>No order found for "{{ $code }}"</h3>
            <p>Double-check your order number, tracking code or phone number — or contact us on Telegram for help.</p>
            <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" class="btn btn-telegram"><i class="fa-brands fa-telegram"></i> Contact support</a>
        </div>
    @endif
</div>
@endsection
