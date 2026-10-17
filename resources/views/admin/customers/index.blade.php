@extends('layouts.admin')

@section('title', 'Customers Directory')

@php $isAccounts = request('view') === 'accounts'; @endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Customer Directory & Purchasing History</h4>
            <span class="text-muted fs-13">
                @if($isAccounts)
                    Registered Accounts: <strong>{{ $accounts->total() }}</strong>
                @else
                    Total Customers: <strong>{{ $customers->total() }}</strong>
                @endif
            </span>
        </div>
    </div>
</div>

<!-- Tabs & Search Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <ul class="nav nav-pills gap-1 fs-13">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ $isAccounts ? '' : 'active' }}" href="{{ route('admin.customers.index') }}">
                        <i class="ti ti-shopping-bag me-1"></i> Order Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 {{ $isAccounts ? 'active' : '' }}" href="{{ route('admin.customers.index', ['view' => 'accounts']) }}">
                        <i class="ti ti-user-check me-1"></i> Registered Accounts ({{ $accountCount }})
                    </a>
                </li>
            </ul>

            <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                @if($isAccounts)<input type="hidden" name="view" value="accounts">@endif
                <div class="input-group input-group-sm" style="width: 280px;">
                    <span class="input-group-text bg-light"><i class="ti ti-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search name, phone number or email..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Search</button>
                <a href="{{ route('admin.customers.index', $isAccounts ? ['view' => 'accounts'] : []) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
            </form>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-13">
            @if($isAccounts)
                <thead class="table-light text-uppercase fs-12">
                    <tr>
                        <th class="ps-3">Account Name</th>
                        <th>Email Address</th>
                        <th>Phone (Cambodia)</th>
                        <th>Orders Placed</th>
                        <th>Total Ordered</th>
                        <th>Joined</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $a)
                    <tr>
                        <td class="ps-3 py-2 fw-bold text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">
                                    {{ strtoupper(mb_substr($a->name, 0, 1)) }}
                                </div>
                                <span>{{ $a->name }}</span>
                            </div>
                        </td>
                        <td>{{ $a->email }}</td>
                        <td>
                            @if($a->phone)
                                <strong class="text-primary"><i class="ti ti-phone me-1"></i>{{ $a->phone }}</strong>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info-subtle text-info border fw-bold">{{ $a->orders_count }} orders</span>
                        </td>
                        <td class="fw-bold text-success fs-14">
                            ${{ number_format($a->orders_sum_total ?? 0, 2) }}
                        </td>
                        <td class="text-muted fs-12">
                            {{ $a->created_at?->format('d M Y, h:i A') }}
                        </td>
                        <td class="text-end pe-3">
                            @if($a->phone && $a->orders_count)
                                <a href="{{ route('admin.customers.show', urlencode($a->phone)) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="ti ti-history me-1"></i> Order History
                                </a>
                            @else
                                <span class="text-muted fs-12">No orders yet</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No registered accounts found</td>
                    </tr>
                    @endforelse
                </tbody>
            @else
                <thead class="table-light text-uppercase fs-12">
                    <tr>
                        <th class="ps-3">Customer Name</th>
                        <th>Phone (Cambodia)</th>
                        <th>Email Address</th>
                        <th>Primary Location</th>
                        <th>Orders Placed</th>
                        <th>Total Spent</th>
                        <th>Last Active</th>
                        <th class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td class="ps-3 py-2 fw-bold text-dark">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">
                                    {{ strtoupper(mb_substr($c->customer_name, 0, 1)) }}
                                </div>
                                <span>{{ $c->customer_name }}</span>
                                @if($c->user_id)
                                    <span class="badge bg-success-subtle text-success border fs-11" title="Has a store account">Registered</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong class="text-primary"><i class="ti ti-phone me-1"></i>{{ $c->customer_phone }}</strong>
                        </td>
                        <td>{{ $c->customer_email ?: 'N/A' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $c->delivery_province }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info-subtle text-info border fw-bold">{{ $c->total_orders }} orders</span>
                        </td>
                        <td class="fw-bold text-success fs-14">
                            ${{ number_format($c->total_spent, 2) }}
                        </td>
                        <td class="text-muted fs-12">
                            {{ \Carbon\Carbon::parse($c->last_order_at)->format('d M Y, h:i A') }}
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.customers.show', urlencode($c->customer_phone)) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="ti ti-history me-1"></i> Order History
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
            @endif
        </table>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-center">
        {{ ($isAccounts ? $accounts : $customers)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
