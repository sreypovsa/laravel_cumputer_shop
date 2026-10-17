@extends('layouts.admin')

@section('title', 'Customer History - ' . ($customer->customer_name ?? 'Customer'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mb-2">
                    <i class="ti ti-arrow-left me-1"></i> Back to Customers
                </a>
                <h4 class="mb-0 fw-bold">Customer Profile & Order History</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Customer Info Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width:64px;height:64px;font-size:24px;">
                {{ strtoupper(substr($customer->customer_name ?? 'C', 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $customer->customer_name ?? 'Customer' }}</h5>
            <p class="text-muted fs-13 mb-3"><i class="ti ti-phone text-primary me-1"></i> {{ $phone }}</p>

            <div class="border-top pt-3 text-start fs-13">
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Email:</span>
                    <strong class="text-dark">{{ $customer->customer_email ?? 'Not provided' }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Location:</span>
                    <strong>{{ $customer->delivery_province ?? 'Cambodia' }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Total Orders:</span>
                    <span class="badge bg-primary">{{ $orders->count() }}</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">Total Spent:</span>
                    <strong class="text-success fs-15">${{ number_format($orders->sum('total'), 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders History Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold text-dark">Order History ({{ $orders->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-13">
                    <thead class="table-light text-uppercase fs-12">
                        <tr>
                            <th class="ps-3">Order Number</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                        <tr>
                            <td class="ps-3 fw-bold">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-primary text-decoration-none">
                                    {{ $ord->order_number }}
                                </a>
                            </td>
                            <td class="text-muted fs-12">{{ $ord->created_at->format('d M Y') }}</td>
                            <td>{{ $ord->items->count() }} items</td>
                            <td class="fw-bold text-dark">${{ number_format($ord->total, 2) }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $ord->payment_method_name }}</span></td>
                            <td>{!! $ord->order_status_badge !!}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="ti ti-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
