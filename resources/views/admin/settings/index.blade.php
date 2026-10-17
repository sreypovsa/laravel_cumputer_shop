@extends('layouts.admin')

@section('title', 'Store Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Store Configuration & Cambodian Banking</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <h5 class="fw-bold mb-3 border-bottom pb-2 text-primary">
                    <i class="ti ti-building-store me-1"></i> Store General Information
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Store Brand Name</label>
                        <input type="text" name="store_name" class="form-control" value="{{ $settings['store_name'] }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Hotline / Phone (Cambodia)</label>
                        <input type="text" name="store_phone" class="form-control" value="{{ $settings['store_phone'] }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Support Email</label>
                        <input type="email" name="store_email" class="form-control" value="{{ $settings['store_email'] }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Telegram Channel / Support</label>
                        <input type="text" name="store_telegram" class="form-control" value="{{ $settings['store_telegram'] }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fs-13 fw-semibold">Physical Store Address</label>
                        <input type="text" name="store_address" class="form-control" value="{{ $settings['store_address'] }}" required>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2 text-danger">
                    <i class="ti ti-qrcode me-1"></i> NBC Bakong KHQR Banking Accounts
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">ABA Bank Account Name</label>
                        <input type="text" name="aba_account_name" class="form-control" value="{{ $settings['aba_account_name'] }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">ABA Bank Account Number</label>
                        <input type="text" name="aba_account_no" class="form-control" value="{{ $settings['aba_account_no'] }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">ACLEDA Bank Account Name</label>
                        <input type="text" name="acleda_account_name" class="form-control" value="{{ $settings['acleda_account_name'] }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">ACLEDA Bank Account Number</label>
                        <input type="text" name="acleda_account_no" class="form-control" value="{{ $settings['acleda_account_no'] }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Wing Bank Account Name</label>
                        <input type="text" name="wing_account_name" class="form-control" value="{{ $settings['wing_account_name'] }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Wing Bank Account Number</label>
                        <input type="text" name="wing_account_no" class="form-control" value="{{ $settings['wing_account_no'] }}">
                    </div>
                </div>

                <h5 class="fw-bold mb-3 border-bottom pb-2 text-success">
                    <i class="ti ti-truck me-1"></i> Cambodia Shipping Rates
                </h5>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Phnom Penh Delivery Fee ($)</label>
                        <input type="number" step="0.01" name="phnom_penh_shipping" class="form-control" value="{{ $settings['phnom_penh_shipping'] }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fs-13 fw-semibold">Provincial Delivery Fee ($) (Virak Buntham / J&T)</label>
                        <input type="number" step="0.01" name="provincial_shipping" class="form-control" value="{{ $settings['provincial_shipping'] }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                    <i class="ti ti-device-floppy me-1"></i> Save Store Settings
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
            <h6 class="fw-bold mb-3 text-dark"><i class="ti ti-info-circle me-1 text-primary"></i> About Store Settings</h6>
            <p class="fs-13 text-muted" style="line-height: 1.7;">
                These settings configure the store branding, contacts, customer care telegram handles, and banking destination accounts displayed on checkout KHQR screens for ABA, Acleda, and Wing Bank.
            </p>
            <div class="border-top pt-3 fs-13">
                <span class="badge bg-success mb-2">Active Banking: USD</span>
                <p class="mb-0 text-muted">All prices and mobile banking transactions are processed in US Dollars ($ USD) compliant with Cambodia National Bank standard.</p>
            </div>
        </div>
    </div>
</div>
@endsection
