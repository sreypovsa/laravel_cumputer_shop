@extends('layouts.admin')

@section('title', 'Sales Invoice #' . $order->order_number)

@section('styles')
<style>
    @media print {
        body {
            background: #fff !important;
            color: #000 !important;
        }
        .sidenav-menu, .app-topbar, .footer, .btn-print-hide, .page-title-box {
            display: none !important;
        }
        .page-content {
            margin: 0 !important;
            padding: 0 !important;
        }
        .invoice-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
    }
    .invoice-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 40px;
    }
    .invoice-header-title {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
</style>
@endsection

@section('content')
<!-- Header Buttons -->
<div class="row btn-print-hide mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="ti ti-arrow-left me-1"></i> Back to Invoices
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="ti ti-printer me-1"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="ti ti-eye me-1"></i> View Order Details
            </a>
        </div>
    </div>
</div>

<!-- Printable Invoice Card -->
<div class="invoice-card mx-auto" style="max-width: 850px;">
    <!-- Top Branding & Invoice Info -->
    <div class="row align-items-center pb-4 mb-4 border-bottom g-3">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 mb-2">
                <img src="{{ asset('images/quicktech-logo.png') }}" alt="{{ $settings['store_name'] ?? 'QuickTech Cambodia' }}" style="height: 40px; width: auto;">
            </div>
            <p class="text-muted fs-12 mb-0" style="line-height: 1.6;">
                <strong>{{ $settings['store_name'] ?? 'QuickTech Cambodia' }}</strong><br>
                {{ $settings['store_address'] ?? 'Phnom Penh, Cambodia' }}<br>
                Tel: {{ $settings['store_phone'] ?? '+855 15 646 581 / 012 646 581' }}<br>
                Telegram: {{ $settings['store_telegram'] ?? '@QUICKTECHCAM' }}
            </p>
        </div>
        <div class="col-sm-6 text-sm-end">
            <h2 class="text-uppercase fw-bold text-dark mb-1">INVOICE</h2>
            <div class="text-muted fs-13">Invoice No: <strong class="text-dark">INV-{{ substr($order->order_number, 3) }}</strong></div>
            <div class="text-muted fs-13">Order Ref: <strong>{{ $order->order_number }}</strong></div>
            <div class="text-muted fs-13">Tracking Code: <strong class="text-danger">{{ $order->tracking_code }}</strong></div>
            <div class="text-muted fs-13">Date: <strong>{{ $order->created_at->format('F d, Y') }}</strong></div>
        </div>
    </div>

    <!-- Customer & Shipping Destination -->
    <div class="row pb-4 mb-4 border-bottom g-3 fs-13">
        <div class="col-sm-6">
            <span class="text-muted text-uppercase fw-bold fs-11 d-block mb-1">BILLED & DELIVERED TO:</span>
            <h5 class="fw-bold text-dark mb-1">{{ $order->customer_name }}</h5>
            <div class="text-muted"><i class="ti ti-phone me-1"></i> {{ $order->customer_phone }}</div>
            @if($order->customer_email)
                <div class="text-muted"><i class="ti ti-mail me-1"></i> {{ $order->customer_email }}</div>
            @endif
            <div class="text-dark mt-1">
                <strong>Address:</strong> {{ $order->delivery_address }}<br>
                {{ $order->delivery_province }}, Cambodia
            </div>
        </div>
        <div class="col-sm-6 text-sm-end">
            <span class="text-muted text-uppercase fw-bold fs-11 d-block mb-1">ORDER & PAYMENT SUMMARY:</span>
            <div class="mb-1">Payment Method: <span class="badge bg-secondary">{{ $order->payment_method_name }}</span></div>
            <div class="mb-1">Payment Status: 
                @if($order->payment_status === 'paid')
                    <span class="badge bg-success">PAID</span>
                @else
                    <span class="badge bg-warning text-dark">PENDING</span>
                @endif
            </div>
            <div class="mb-1">Delivery Carrier: <strong>{{ $order->delivery_carrier }}</strong></div>
            @if($order->courier_tracking_number)
                <div>Courier Tracking #: <span class="badge bg-info">{{ $order->courier_tracking_number }}</span></div>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle mb-0 fs-13">
            <thead class="table-light text-uppercase fs-12">
                <tr>
                    <th style="width: 50px;" class="text-center">#</th>
                    <th>Item Description</th>
                    <th>Model Code</th>
                    <th class="text-end" style="width: 120px;">Unit Price</th>
                    <th class="text-center" style="width: 80px;">Qty</th>
                    <th class="text-end" style="width: 130px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $idx => $item)
                <tr>
                    <td class="text-center fw-bold">{{ $idx + 1 }}</td>
                    <td>
                        <strong class="text-dark">{{ $item->product_name }}</strong>
                    </td>
                    <td><span class="badge bg-light text-muted border">{{ $item->product_code ?? 'N/A' }}</span></td>
                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end fw-bold text-dark">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="border-0"></td>
                    <td class="text-end text-muted fw-semibold">Subtotal:</td>
                    <td class="text-end fw-bold">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="border-0"></td>
                    <td class="text-end text-muted fw-semibold">Cambodia Delivery:</td>
                    <td class="text-end fw-bold">${{ number_format($order->shipping_fee, 2) }}</td>
                </tr>
                <tr class="fs-15">
                    <td colspan="4" class="border-0"></td>
                    <td class="text-end text-dark fw-bold bg-light">Grand Total:</td>
                    <td class="text-end fw-bold text-primary bg-light fs-16">${{ number_format($order->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Terms and Signatures -->
    <div class="row pt-3 mt-4 border-top g-4 fs-12 text-muted">
        <div class="col-8">
            <h6 class="fw-bold text-dark mb-1">Warranty & Store Policies:</h6>
            <ul class="list-unstyled mb-0" style="line-height: 1.6;">
                <li>• Official manufacturer warranty applies to all laptops and components.</li>
                <li>• 7 days 1-to-1 hardware replacement policy for factory manufacturing defects.</li>
                <li>• Retain this official invoice receipt for warranty claims and customer support.</li>
            </ul>
        </div>
        <div class="col-4 text-center">
            <div class="pt-4 border-bottom mb-2" style="height: 50px;"></div>
            <span class="text-uppercase fw-bold text-dark fs-11">Authorized Signature & Stamp</span>
        </div>
    </div>
</div>
@endsection
