@extends('layouts.admin')

@section('title', 'Manage Customer Orders')

@section('content')
<!-- Page Header -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Customer Orders & Confirmations</h4>
            <div class="page-title-right">
                <span class="text-muted fs-13">Total Orders: <strong>{{ $counts['all'] }}</strong></span>
            </div>
        </div>
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <ul class="nav nav-pills gap-1 fs-13">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ !request('status') || request('status') === 'all' ? 'active' : '' }}" href="{{ route('admin.orders.index', request()->except(['status', 'page'])) }}">
                        All Orders ({{ $counts['all'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ request('status') === 'pending' ? 'active bg-warning text-dark' : 'text-warning' }}" href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'pending'])) }}">
                        Pending Confirm ({{ $counts['pending'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ request('status') === 'confirmed' ? 'active bg-info' : 'text-info' }}" href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'confirmed'])) }}">
                        Confirmed ({{ $counts['confirmed'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ request('status') === 'shipping' ? 'active bg-primary' : 'text-primary' }}" href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'shipping'])) }}">
                        Shipping ({{ $counts['shipping'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ request('status') === 'delivered' ? 'active bg-success' : 'text-success' }}" href="{{ route('admin.orders.index', array_merge(request()->except(['page']), ['status' => 'delivered'])) }}">
                        Delivered ({{ $counts['delivered'] }})
                    </a>
                </li>
            </ul>

            <!-- Search & Payment Filter Form -->
            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                
                <select name="payment_status" class="form-select form-select-sm" style="width: 140px;" onchange="this.form.submit()">
                    <option value="">All Payments</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Unpaid / Pending</option>
                    <option value="rejected" {{ request('payment_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Order #, customer, phone..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="ti ti-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Orders Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-13">
            <thead class="table-light text-uppercase fs-12">
                <tr>
                    <th class="ps-3">Order Number</th>
                    <th>Customer Name & Phone</th>
                    <th>Destination & Courier</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="ps-3 fw-bold text-nowrap">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary text-decoration-none">
                            {{ $order->order_number }}
                        </a>
                        <div class="text-danger fs-11">Code: {{ $order->tracking_code }}</div>
                        <div class="text-muted fs-11 fw-normal">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </td>
                    <td class="text-nowrap">
                        <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                        <div class="text-muted fs-12"><i class="ti ti-phone me-1"></i>{{ $order->customer_phone }}</div>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $order->delivery_province }}</div>
                        <span class="text-muted fs-11 text-truncate d-block" style="max-width: 160px;">{{ $order->delivery_address }}</span>
                        <span class="badge bg-light text-dark border fs-11 mt-1">{{ $order->delivery_carrier }}</span>
                        @if($order->courier_tracking_number)
                            <div class="text-success fs-11 fw-bold">{{ $order->courier_tracking_number }}</div>
                        @endif
                    </td>
                    <td class="fw-bold text-dark fs-14 text-nowrap">
                        ${{ number_format($order->total, 2) }}
                    </td>
                    <td>
                        <span class="badge bg-secondary-subtle text-dark border fs-11">{{ $order->payment_method_name }}</span>
                        <div class="mt-1">
                            @if($order->payment_status === 'paid')
                                <span class="badge bg-success-subtle text-success fs-11"><i class="ti ti-check"></i> Paid</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning fs-11">Unpaid</span>
                            @endif
                            @if($order->payment_slip)
                                <a href="{{ $order->payment_slip_url }}" target="_blank" class="badge bg-info text-white ms-1 text-decoration-none" title="View Payment Slip">
                                    <i class="ti ti-receipt"></i> Slip
                                </a>
                            @endif
                        </div>
                    </td>
                    <td>
                        {!! $order->order_status_badge !!}
                    </td>
                    <td class="text-end pe-3">
                        <div class="d-inline-flex align-items-center justify-content-end gap-1">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm btn-icon" title="View Order Details">
                                <i class="ti ti-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-outline-secondary btn-sm btn-icon" title="Print Invoice">
                                <i class="ti ti-printer"></i>
                            </a>
                            @if($order->order_status === 'pending')
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm order #{{ $order->order_number }}?');">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm btn-icon" title="Confirm Order">
                                        <i class="ti ti-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete order #{{ $order->order_number }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Delete Order">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="ti ti-inbox fs-32 d-block mb-2"></i>
                        No customer orders match the selected filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="card-footer bg-white p-3 d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
