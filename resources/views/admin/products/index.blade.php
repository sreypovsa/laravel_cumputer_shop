@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Products Inventory ({{ $products->total() }})</h4>
            <div class="page-title-right">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm rounded-pill">
                    <i class="ti ti-plus me-1"></i> Add New Product
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="ti ti-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by product name or code..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Filter by Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 text-md-end">
                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-13">
            <thead class="table-light text-uppercase fs-12">
                <tr>
                    <th class="ps-3">Product</th>
                    <th>Category</th>
                    <th>Code / SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Featured</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $prod)
                <tr>
                    <td class="ps-3 py-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-light p-1 rounded" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                            <div style="max-width: 320px;">
                                <a href="{{ route('shop.show', $prod->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none d-block text-truncate">
                                    {{ $prod->name }}
                                </a>
                                @if($prod->brand)
                                    <span class="badge bg-secondary-subtle text-secondary fs-10">{{ $prod->brand->name }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $prod->category->name ?? 'Uncategorized' }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $prod->code }}</span></td>
                    <td class="fw-bold text-primary">${{ number_format($prod->price, 2) }}</td>
                    <td>
                        @if($prod->stock > 5)
                            <span class="badge bg-success-subtle text-success">{{ $prod->stock }} in stock</span>
                        @elseif($prod->stock > 0)
                            <span class="badge bg-warning-subtle text-warning">{{ $prod->stock }} left</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">Out of stock</span>
                        @endif
                    </td>
                    <td>
                        @if($prod->is_featured)
                            <span class="badge bg-primary"><i class="ti ti-star"></i> Featured</span>
                        @else
                            <span class="text-muted fs-12">-</span>
                        @endif
                    </td>
                    <td class="text-end pe-3">
                        <div class="d-inline-flex align-items-center justify-content-end gap-1">
                            <a href="{{ route('shop.show', $prod->slug) }}" target="_blank" class="btn btn-outline-info btn-sm btn-icon" title="View on Store">
                                <i class="ti ti-external-link"></i>
                            </a>
                            <form action="{{ route('admin.products.duplicate', $prod->id) }}" method="POST" class="d-inline" title="Duplicate / Clone Product">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm btn-icon" title="Duplicate" onclick="return confirm('Duplicate this product?');">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="btn btn-outline-primary btn-sm btn-icon" title="Edit">
                                <i class="ti ti-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Delete">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
