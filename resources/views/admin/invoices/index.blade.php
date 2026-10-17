@extends('layouts.admin')

@section('title', 'Sales Invoices & Receipts')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Customer Sales Invoices & Receipts</h4>
            <span class="text-muted fs-13">Total Invoices: <strong>{{ $invoices->total() }}</strong></span>
        </div>
    </div>
</div>

<!-- Search Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('admin.invoices.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="ti ti-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by invoice / order number, customer name, phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Search</button>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Invoices Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-13">
            <thead class="table-light text-uppercase fs-12">
                <tr>
                    <th class="ps-3">Invoice #</th>
                    <th>Issue Date</th>
                    <th>Billed To</th>
                    <th>Delivery Carrier</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                <tr>
                    <td class="ps-3 fw-bold">
                        <span class="text-dark">INV-{{ substr($inv->order_number, 3) }}</span>
                        <div class="text-muted fs-11">Order: {{ $inv->order_number }}</div>
                    </td>
                    <td class="text-muted fs-12">
                        {{ $inv->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $inv->customer_name }}</div>
                        <div class="text-muted fs-12">{{ $inv->customer_phone }} ({{ $inv->delivery_province }})</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $inv->delivery_carrier }}</span>
                    </td>
                    <td class="fw-bold text-dark fs-14">
                        ${{ number_format($inv->total, 2) }}
                    </td>
                    <td>
                        {!! $inv->payment_status_badge !!}
                    </td>
                    <td class="text-end pe-3">
                        <a href="{{ route('admin.invoices.show', $inv->id) }}" class="btn btn-sm btn-primary rounded-pill">
                            <i class="ti ti-printer me-1"></i> Print / View Invoice
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">No invoices found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-center">
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
