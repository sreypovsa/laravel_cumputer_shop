@extends('layouts.app')

@section('title', 'My Orders | QuickTech Cambodia')

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My account</li>
            </ol>
        </nav>
        <h1>Hello, {{ \Illuminate\Support\Str::before($user->name, ' ') ?: $user->name }}</h1>
        <p>Manage your orders and account details.</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3 order-2 order-lg-1">@include('frontend.account._nav')</div>

        <div class="col-lg-9 order-1 order-lg-2">
            <div class="row g-3 mb-4">
                <div class="col-4"><div class="qt-stat"><strong>{{ $stats['total'] }}</strong><span>Total orders</span></div></div>
                <div class="col-4"><div class="qt-stat"><strong>{{ $stats['active'] }}</strong><span>In progress</span></div></div>
                <div class="col-4"><div class="qt-stat"><strong>${{ number_format($stats['spent'], 0) }}</strong><span>Total paid</span></div></div>
            </div>

            <section class="qt-card">
                <div class="qt-card__head">
                    <h2 class="qt-card__title">Order history</h2>
                    <a href="{{ route('shop.index') }}" class="qt-link-more">Shop more <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                @forelse($orders as $order)
                    <a href="{{ route('account.order', $order->order_number) }}" class="qt-order-row">
                        <div class="min-w-0">
                            <strong>#{{ $order->order_number }}</strong>
                            <small>{{ $order->created_at->format('d M Y') }} · {{ $order->items_count }} {{ \Illuminate\Support\Str::plural('item', $order->items_count) }}</small>
                        </div>
                        <div class="min-w-0">
                            <small class="d-block text-truncate">{{ $order->payment_method_name }}</small>
                            <small class="d-block text-truncate">{{ $order->delivery_province }}</small>
                        </div>
                        @include('frontend.partials.status-badge', ['status' => $order->order_status])
                        <span class="qt-order-row__total">${{ number_format($order->total, 2) }}</span>
                    </a>
                @empty
                    <div class="qt-empty">
                        <div class="qt-empty__icon"><i class="fa-solid fa-box-open"></i></div>
                        <h3>No orders yet</h3>
                        <p>When you place an order while signed in, it will show up here.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Start shopping</a>
                    </div>
                @endforelse
            </section>

            @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
