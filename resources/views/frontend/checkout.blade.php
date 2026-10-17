@extends('layouts.app')

@section('title', 'Checkout | QuickTech Cambodia')

@php
    $firstCarrier = array_key_first($carriers);
    $selectedCarrier = old('delivery_carrier', $firstCarrier);
    $initialFee = $carriers[$selectedCarrier]['fee'] ?? ($carriers[$firstCarrier]['fee'] ?? 0);
    $selectedPayment = old('payment_method', 'aba_khqr');
    $payments = [
        'aba_khqr'    => ['title' => 'ABA KHQR', 'desc' => 'Scan with ABA Mobile', 'logo' => 'ABA', 'color' => '#005f73'],
        'acleda_khqr' => ['title' => 'ACLEDA KHQR', 'desc' => 'Scan with ACLEDA Mobile', 'logo' => 'AC', 'color' => '#002855'],
        'wing_khqr'   => ['title' => 'Wing Bank QR', 'desc' => 'Scan with Wing Bank app', 'logo' => 'WING', 'color' => '#6aa81e'],
        'cod'         => ['title' => 'Cash on delivery', 'desc' => 'Pay when your order arrives', 'logo' => '<i class="fa-solid fa-money-bill-wave"></i>', 'color' => '#475569'],
    ];
@endphp

@section('content')
<div class="qt-page-head">
    <div class="container">
        <div class="mb-3">@include('frontend.partials.checkout-steps', ['current' => 2])</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <h1>Delivery &amp; payment</h1>
    </div>
</div>

<div class="container py-4">
    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" novalidate>
        @csrf
        <div class="row g-4">
            <div class="col-lg-8 d-flex flex-column gap-3">
                @guest
                    <div class="qt-card d-flex flex-wrap align-items-center justify-content-between gap-3" style="padding: 14px 20px;">
                        <div class="d-flex align-items-center gap-3">
                            <span class="qt-info-item__icon"><i class="fa-regular fa-user"></i></span>
                            <div class="small">
                                <strong class="d-block text-dark">Have an account?</strong>
                                <span class="text-muted">Sign in to fill in your details and keep this order in your history.</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('login', ['redirect' => '/checkout']) }}" class="btn btn-primary btn-sm">Sign in</a>
                            <a href="{{ route('register', ['redirect' => '/checkout']) }}" class="btn btn-light btn-sm">Register</a>
                        </div>
                    </div>
                @endguest

                <!-- 1. CONTACT -->
                <section class="qt-card">
                    <div class="qt-card__head">
                        <h2 class="qt-card__title"><span class="qt-step-dot">1</span> Contact information</h2>
                    </div>
                    <div class="qt-card__body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="customerName">Full name <span class="text-danger">*</span></label>
                                <input type="text" id="customerName" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" placeholder="e.g. Sokha Mean" value="{{ old('customer_name', Auth::user()->name ?? '') }}" required autocomplete="name">
                                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="customerPhone">Phone number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+855</span>
                                    <input type="tel" id="customerPhone" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" placeholder="012 345 678" value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" required autocomplete="tel">
                                </div>
                                @error('customer_phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="customerEmail">Email <span class="text-muted fw-normal">(optional, for receipt)</span></label>
                                <input type="email" id="customerEmail" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" placeholder="you@example.com" value="{{ old('customer_email', Auth::user()->email ?? '') }}" autocomplete="email">
                                @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. DELIVERY -->
                <section class="qt-card">
                    <div class="qt-card__head">
                        <h2 class="qt-card__title"><span class="qt-step-dot">2</span> Delivery address</h2>
                    </div>
                    <div class="qt-card__body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="provinceSelect">Province / city <span class="text-danger">*</span></label>
                                <select name="delivery_province" id="provinceSelect" class="form-select @error('delivery_province') is-invalid @enderror" required>
                                    <option value="">Select province</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov }}" {{ old('delivery_province', 'Phnom Penh') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                    @endforeach
                                </select>
                                @error('delivery_province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="qt-chips mt-2">
                                    @foreach(['Phnom Penh', 'Siem Reap', 'Battambang', 'Kandal', 'Preah Sihanouk'] as $pop)
                                        <button type="button" class="qt-chip province-chip" data-province="{{ $pop }}" style="height: 26px; font-size: 11.5px; padding: 0 10px;">{{ $pop }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="district">District / Khan</label>
                                <input type="text" id="district" name="delivery_district" class="form-control" placeholder="e.g. Khan Chamkarmon" value="{{ old('delivery_district') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="commune">Commune / Sangkat</label>
                                <input type="text" id="commune" name="delivery_commune" class="form-control" placeholder="e.g. Sangkat Boeng Keng Kang" value="{{ old('delivery_commune') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="address">Street &amp; house no. <span class="text-danger">*</span></label>
                                <input type="text" id="address" name="delivery_address" class="form-control @error('delivery_address') is-invalid @enderror" placeholder="e.g. St. 271, House #14B" value="{{ old('delivery_address') }}" required autocomplete="street-address">
                                @error('delivery_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="form-label">Delivery method</div>
                                <div class="row g-2">
                                    @foreach($carriers as $cName => $cData)
                                        <div class="col-md-6">
                                            <label class="qt-option">
                                                <input class="form-check-input carrier-radio" type="radio" name="delivery_carrier" value="{{ $cName }}" data-fee="{{ $cData['fee'] }}" {{ $selectedCarrier === $cName ? 'checked' : '' }}>
                                                <span class="qt-option__body">
                                                    <span class="qt-option__title">{{ $cName }}</span>
                                                    <span class="qt-option__desc">{{ $cData['desc'] }}</span>
                                                </span>
                                                <span class="qt-option__aside">${{ number_format($cData['fee'], 2) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="notes">Delivery notes <span class="text-muted fw-normal">(optional)</span></label>
                                <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="e.g. Call before delivery">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 3. PAYMENT -->
                <section class="qt-card">
                    <div class="qt-card__head">
                        <h2 class="qt-card__title"><span class="qt-step-dot">3</span> Payment method</h2>
                    </div>
                    <div class="qt-card__body">
                        <div class="row g-2">
                            @foreach($payments as $value => $pay)
                                <div class="col-md-6">
                                    <label class="qt-option">
                                        <input class="form-check-input" type="radio" name="payment_method" value="{{ $value }}" {{ $selectedPayment === $value ? 'checked' : '' }}>
                                        <span class="qt-bank-logo" style="background: {{ $pay['color'] }}">{!! $pay['logo'] !!}</span>
                                        <span class="qt-option__body">
                                            <span class="qt-option__title">{{ $pay['title'] }}</span>
                                            <span class="qt-option__desc">{{ $pay['desc'] }}</span>
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex gap-2 align-items-start mt-3 p-3 rounded-3" style="background: var(--qt-gold-100); font-size: 12.5px; color: #7a5d1f;">
                            <i class="fa-solid fa-circle-info mt-1"></i>
                            <span>For KHQR payments, a QR code with your order number and exact USD total is shown on the next step.</span>
                        </div>
                    </div>
                </section>
            </div>

            <!-- SUMMARY -->
            <div class="col-lg-4">
                <aside class="qt-card qt-card__body qt-summary">
                    <h2 class="qt-card__title mb-2">Order summary</h2>

                    <div class="mb-3" style="max-height: 260px; overflow-y: auto;">
                        @foreach($cart as $item)
                            <div class="qt-mini-item">
                                <div class="qt-mini-item__img">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <span class="qt-mini-item__qty">{{ $item['quantity'] }}</span>
                                </div>
                                <div class="flex-grow-1 min-w-0"><div class="qt-mini-item__name">{{ $item['name'] }}</div></div>
                                <strong class="small text-dark text-nowrap">${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                            </div>
                        @endforeach
                    </div>

                    <div class="qt-summary__row"><span>Subtotal</span><strong>${{ number_format($subtotal, 2) }}</strong></div>
                    <div class="qt-summary__row"><span>Delivery</span><strong id="shippingFeeText">${{ number_format($initialFee, 2) }}</strong></div>
                    <div class="qt-summary__total">
                        <span>Total</span>
                        <strong id="orderTotalText">${{ number_format($subtotal + $initialFee, 2) }}</strong>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" id="btnPlaceOrder">
                        <i class="fa-solid fa-lock fa-sm"></i> Place order
                    </button>
                    <div class="qt-secure-note"><i class="fa-solid fa-shield-halved"></i> Secure checkout · NBC Bakong KHQR standard</div>
                </aside>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const subtotal = {{ $subtotal }};

    function refreshTotals() {
        const fee = parseFloat($('.carrier-radio:checked').data('fee')) || 0;
        $('#shippingFeeText').text('$' + fee.toFixed(2));
        $('#orderTotalText').text('$' + (subtotal + fee).toFixed(2));
    }

    function syncProvinceChips() {
        const current = $('#provinceSelect').val();
        $('.province-chip').each(function () {
            $(this).toggleClass('is-active', $(this).data('province') === current);
        });
    }

    $('.carrier-radio').on('change', refreshTotals);
    $('#provinceSelect').on('change', syncProvinceChips);
    $('.province-chip').on('click', function () {
        $('#provinceSelect').val($(this).data('province')).trigger('change');
    });

    $(function () { refreshTotals(); syncProvinceChips(); });

    $('#checkoutForm').on('submit', function (e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            $(this).find(':invalid').addClass('is-invalid').first().trigger('focus');
            return;
        }
        $('#btnPlaceOrder').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Placing order...');
    });
    $('#checkoutForm').on('input change', '.is-invalid', function () {
        if (this.checkValidity()) $(this).removeClass('is-invalid');
    });
</script>
@endsection
