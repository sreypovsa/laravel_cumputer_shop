@extends('layouts.admin')

@section('title', 'Sales & Order Dashboard')

@section('content')
<!-- Page Header -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Admin Dashboard Overview</h4>
            <div class="page-title-right d-flex gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                    <i class="ti ti-plus me-1"></i> Add Product
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="ti ti-settings me-1"></i> Store Settings
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm rounded-pill">
                    <i class="ti ti-shopping-bag me-1"></i> View Orders
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI Metric Cards -->
<div class="row g-3 mb-4">
    <!-- Total Revenue -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-1">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fs-12 text-uppercase fw-bold letter-spacing-1">Total Revenue</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#ecfdf5;color:#10b981;">
                        <i class="ti ti-currency-dollar fs-22"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">${{ number_format($totalRevenue, 2) }}</h3>
                <span class="text-success fs-12 fw-medium"><i class="ti ti-circle-check"></i> Across confirmed & paid orders</span>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-1">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fs-12 text-uppercase fw-bold letter-spacing-1">Total Orders</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#eff6ff;color:#2563eb;">
                        <i class="ti ti-shopping-cart fs-22"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">{{ $totalOrders }}</h3>
                <span class="text-muted fs-12"><i class="ti ti-clock text-warning"></i> {{ $pendingOrders }} pending confirmation</span>
            </div>
        </div>
    </div>

    <!-- Pending Confirmation -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-1" style="border-left: 4px solid #f59e0b !important;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fs-12 text-uppercase fw-bold letter-spacing-1">Pending Confirm</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#fffbeb;color:#f59e0b;">
                        <i class="ti ti-alert-circle fs-22"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-warning" style="letter-spacing: -0.5px;">{{ $pendingOrders }}</h3>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-warning fs-12 fw-semibold text-decoration-none d-inline-flex align-items-center gap-1">
                    Review orders awaiting approval &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="col-xl-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100 p-1">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fs-12 text-uppercase fw-bold letter-spacing-1">Products Catalog</span>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#f5f3ff;color:#7c3aed;">
                        <i class="ti ti-device-laptop fs-22"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">{{ $totalProducts }}</h3>
                <span class="text-muted fs-12"><i class="ti ti-check text-success"></i> Sourced from QuickTech</span>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Counters Row -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <span class="fw-bold fs-14 text-dark"><i class="ti ti-filter me-1 text-primary"></i> Order Status Breakdown:</span>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        All: <strong>{{ $totalOrders }}</strong>
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                        Pending: <strong>{{ $pendingOrders }}</strong>
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                        Confirmed: <strong>{{ $confirmedOrders }}</strong>
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'shipping']) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Shipping: <strong>{{ $shippingOrders }}</strong>
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        Delivered: <strong>{{ $deliveredOrders }}</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Category Overview -->
<div class="row g-4">
    <!-- Recent Orders Table -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold text-dark">Recent Customer Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-13 text-nowrap">
                    <thead class="table-light text-uppercase fs-12">
                        <tr>
                            <th class="ps-3">Order Number</th>
                            <th>Customer & Phone</th>
                            <th>Province & Carrier</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-3 fw-bold">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary text-decoration-none">
                                    {{ $order->order_number }}
                                </a>
                                <div class="text-muted fs-11">Code: {{ $order->tracking_code }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                                <div class="text-muted fs-12">{{ $order->customer_phone }}</div>
                            </td>
                            <td>
                                <div>{{ $order->delivery_province }}</div>
                                <span class="badge bg-light text-muted border fs-11">{{ $order->delivery_carrier }}</span>
                            </td>
                            <td class="fw-bold text-dark">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border fs-11">{{ $order->payment_method_name }}</span>
                                @if($order->payment_slip)
                                    <span class="badge bg-success ms-1" title="Slip attached"><i class="ti ti-file-check"></i> Slip</span>
                                @endif
                            </td>
                            <td>
                                {!! $order->order_status_badge !!}
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm btn-icon" title="View Order">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @if($order->order_status === 'pending')
                                        <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm order #{{ $order->order_number }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="One-Click Confirm">
                                                <i class="ti ti-check"></i> Confirm
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <h5 class="fw-bold mb-0">Catalog Categories</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">Manage Products</a>
            </div>
            <div class="row g-2 fs-13">
                @foreach($topCategories as $cat)
                <div class="col-md-6 col-xl-4">
                    <div class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-2 h-100">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti {{ $cat->icon ?? 'ti-folder' }} text-primary fs-18"></i>
                            <span class="fw-medium text-dark">{{ $cat->name }}</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $cat->products_count }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
