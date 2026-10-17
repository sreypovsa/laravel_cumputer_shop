@extends('layouts.admin')

@section('title', 'Order Details #' . $order->order_number)

@section('content')
<!-- Page Header -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                    <i class="ti ti-arrow-left me-1"></i> Back to Orders
                </a>
                <h4 class="mb-0 fw-bold">Order Details: <span class="text-primary">{{ $order->order_number }}</span></h4>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                    <i class="ti ti-printer me-1"></i> Print / View Invoice
                </a>
                <span class="fs-13 text-muted">Tracking: <strong class="text-danger fs-14">{{ $order->tracking_code }}</strong></span>
                {!! $order->order_status_badge !!}
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left: Order Breakdown, Delivery & Items -->
    <div class="col-lg-8">
        <!-- Customer & Cambodia Delivery Details -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="ti ti-truck-delivery text-primary"></i> Customer & Cambodia Delivery Address
            </h5>
            <div class="row g-3 fs-13">
                <div class="col-md-6">
                    <span class="text-muted d-block">Customer Name:</span>
                    <strong class="text-dark fs-14">{{ $order->customer_name }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block">Phone Number (Cambodia):</span>
                    <strong class="text-primary fs-14">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $order->customer_phone) }}" class="text-decoration-none">
                            <i class="ti ti-phone me-1"></i>{{ $order->customer_phone }}
                        </a>
                    </strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block">Email Address:</span>
                    <span>{{ $order->customer_email ?: 'N/A' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted d-block">Delivery Courier:</span>
                    <span class="badge bg-primary fs-12">{{ $order->delivery_carrier }}</span>
                </div>
                <div class="col-12">
                    <span class="text-muted d-block">Delivery Province / City:</span>
                    <strong class="text-dark">{{ $order->delivery_province }}</strong>
                    @if($order->delivery_district) - {{ $order->delivery_district }} @endif
                    @if($order->delivery_commune) - {{ $order->delivery_commune }} @endif
                </div>
                <div class="col-12">
                    <span class="text-muted d-block">Street Address & House #:</span>
                    <div class="p-2 bg-light rounded text-dark fw-medium">{{ $order->delivery_address }}</div>
                </div>
                @if($order->notes)
                <div class="col-12">
                    <span class="text-muted d-block">Customer Special Request:</span>
                    <div class="p-2 bg-warning-subtle text-dark rounded">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Ordered Items Table -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold text-dark">Ordered Items ({{ $order->items->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 fs-13">
                    <thead class="table-light text-uppercase fs-12">
                        <tr>
                            <th class="ps-3">Product</th>
                            <th>Model Code</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th class="text-end pe-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="ps-3 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light p-1 rounded" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-muted border">{{ $item->product_code ?? 'N/A' }}</span></td>
                            <td class="fw-semibold">${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end pe-3 fw-bold text-primary">${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light fs-13">
                        <tr>
                            <td colspan="4" class="text-end text-muted">Subtotal:</td>
                            <td class="text-end pe-3 fw-semibold">${{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-muted">Cambodia Shipping Fee:</td>
                            <td class="text-end pe-3 fw-semibold">${{ number_format($order->shipping_fee, 2) }}</td>
                        </tr>
                        <tr class="fs-15 fw-bold">
                            <td colspan="4" class="text-end text-dark">Grand Total:</td>
                            <td class="text-end pe-3 text-primary fs-16">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Order Status Management & Payment Slip -->
    <div class="col-lg-4">
        <!-- Status Update & Courier Tracking -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="ti ti-settings text-primary"></i> Order Actions & Status
            </h5>

            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fs-13 fw-bold">Order Status</label>
                    <select name="order_status" class="form-select form-select-sm">
                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->order_status === 'confirmed' ? 'selected' : '' }}>Confirmed (Order Approved)</option>
                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing (Packaging)</option>
                        <option value="shipping" {{ $order->order_status === 'shipping' ? 'selected' : '' }}>Shipping (Courier En Route)</option>
                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered (Completed)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-bold">Payment Status</label>
                    <select name="payment_status" class="form-select form-select-sm">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="rejected" {{ $order->payment_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-bold">Courier Tracking Number</label>
                    <input type="text" name="courier_tracking_number" class="form-control form-control-sm" placeholder="e.g. VET-882194 or JNT-77123" value="{{ old('courier_tracking_number', $order->courier_tracking_number) }}">
                    <div class="form-text fs-11">Customer can view this on their Tracking page!</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-bold">Internal Admin Notes</label>
                    <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Private internal note">{{ old('notes', $order->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm rounded-3">
                    <i class="ti ti-device-floppy me-1"></i> Update Order Status
                </button>
            </form>
        </div>

        <!-- Payment Slip Verification Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                <i class="ti ti-qrcode text-danger"></i> KHQR Payment Verification
            </h5>

            <div class="mb-3 fs-13">
                <span class="text-muted d-block">Payment Method:</span>
                <span class="badge bg-primary-subtle text-primary border fs-12">{{ $order->payment_method_name }}</span>
            </div>

            @if($order->payment_slip)
                <div class="text-center">
                    <span class="text-muted fs-12 d-block mb-2">Customer Uploaded Transfer Slip:</span>
                    <a href="{{ $order->payment_slip_url }}" target="_blank">
                        <img src="{{ $order->payment_slip_url }}" alt="Payment Slip" class="img-fluid rounded border shadow-sm" style="max-height: 250px;">
                    </a>
                    <div class="mt-2">
                        <a href="{{ $order->payment_slip_url }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="ti ti-zoom-in me-1"></i> Enlarge Slip Image
                        </a>
                    </div>
                </div>
            @else
                <div class="p-3 bg-light rounded text-center text-muted fs-13">
                    <i class="ti ti-receipt-off fs-24 d-block mb-1"></i>
                    No payment slip uploaded yet by customer.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
