@extends('layouts.app')

@section('title', 'KHQR Payment | Order #' . $order->order_number)

@section('content')
<div class="qt-page-head">
    <div class="container">
        <div class="mb-3">@include('frontend.partials.checkout-steps', ['current' => 3])</div>
        <h1>Complete your payment</h1>
        <p>Order <strong class="text-dark">#{{ $order->order_number }}</strong> · scan the KHQR with any Cambodian banking app</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4 justify-content-center">
        <!-- KHQR CARD -->
        <div class="col-lg-5 col-md-8">
            <div class="qt-khqr">
                <div class="qt-khqr__head" style="background: {{ $bankInfo['color'] }};">
                    <span class="qt-khqr__brand">KHQR</span>
                    <span class="qt-khqr__bank">{{ $bankInfo['name'] }}<br><span style="opacity: .75">Bakong network</span></span>
                </div>
                <div class="qt-khqr__amount">
                    <small>{{ $bankInfo['account_name'] }}</small>
                    <strong>${{ number_format($order->total, 2) }}</strong>
                </div>
                <div class="qt-khqr__qr">
                    <img src="{{ $qrCodeUrl }}" alt="KHQR code for order {{ $order->order_number }}">
                    <span class="qt-khqr__qr-badge" style="color: {{ $bankInfo['color'] }}">{{ $bankInfo['bank_short'] }}</span>
                </div>
                <div class="px-4 pb-4">
                    <dl class="qt-kv mb-0">
                        <dt>Account no.</dt>
                        <dd>{{ $bankInfo['account_no'] }} <button type="button" class="qt-copy" onclick="copyText('{{ $bankInfo['account_no'] }}', this)">Copy</button></dd>
                        <dt>Order no.</dt>
                        <dd>{{ $order->order_number }} <button type="button" class="qt-copy" onclick="copyText('{{ $order->order_number }}', this)">Copy</button></dd>
                        <dt>Tracking</dt>
                        <dd>{{ $order->tracking_code }}</dd>
                    </dl>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ $qrCodeUrl }}" download="KHQR_{{ $order->order_number }}.png" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-download"></i> Save QR image
                </a>
            </div>
        </div>

        <!-- STEPS + UPLOAD -->
        <div class="col-lg-6 col-md-10 d-flex flex-column gap-3">
            <section class="qt-card qt-card__body">
                <h2 class="qt-card__title mb-3"><i class="fa-solid fa-mobile-screen-button" style="color: var(--qt-gold-600)"></i> How to pay</h2>
                <ol class="qt-howto">
                    <li><span>Open your <strong class="text-dark">{{ $bankInfo['bank_short'] }}</strong> app (or any app that supports KHQR / Bakong).</span></li>
                    <li><span>Tap <strong class="text-dark">Scan QR</strong> and scan the code — or upload the saved image.</span></li>
                    <li><span>Check the recipient is <strong class="text-dark">{{ $bankInfo['account_name'] }}</strong> and the amount is <strong class="text-dark">${{ number_format($order->total, 2) }}</strong>.</span></li>
                    <li><span>Confirm payment and take a screenshot of the success screen.</span></li>
                </ol>
            </section>

            <section class="qt-card qt-card__body">
                <h2 class="qt-card__title mb-1"><i class="fa-solid fa-receipt" style="color: var(--qt-success)"></i> Upload payment slip</h2>
                <p class="text-muted small mb-3">Send us your transfer screenshot so we can confirm your order right away.</p>

                <form action="{{ route('payment.upload-slip', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="qt-dropzone mb-2" id="slipDrop">
                        <input type="file" name="payment_slip" id="slipInput" accept="image/*" required onchange="previewSlip(this)">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <strong id="slipLabel">Choose a screenshot or drag it here</strong>
                        <span>JPG, PNG or WEBP · max 5MB</span>
                    </label>
                    @error('payment_slip')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                    <div id="slipPreviewContainer" class="text-center mb-3 d-none">
                        <img id="slipPreview" src="#" alt="Slip preview" class="rounded-3 border" style="max-height: 180px;">
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fa-solid fa-circle-check"></i> Submit &amp; confirm payment
                    </button>
                </form>

                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3 pt-3" style="border-top: 1px solid var(--qt-border);">
                    <a href="tel:015646581" class="btn btn-light btn-sm"><i class="fa-solid fa-phone"></i> 015 646 581</a>
                    <a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" class="btn btn-light btn-sm"><i class="fa-brands fa-telegram" style="color: var(--qt-telegram)"></i> Telegram support</a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewSlip(input) {
        if (!input.files || !input.files[0]) return;
        $('#slipLabel').text(input.files[0].name);
        const reader = new FileReader();
        reader.onload = e => {
            $('#slipPreview').attr('src', e.target.result);
            $('#slipPreviewContainer').removeClass('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.textContent;
            btn.textContent = 'Copied';
            setTimeout(() => btn.textContent = original, 1800);
        });
    }
</script>
@endsection
