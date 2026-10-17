@extends('layouts.admin')

@section('title', 'Manage Brands')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Manage Computer Brands</h4>
            <span class="text-muted fs-13">Total Brands: <strong>{{ $brands->total() }}</strong></span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Brands Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold text-dark">Brand Partners & Manufacturers</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-13">
                    <thead class="table-light text-uppercase fs-12">
                        <tr>
                            <th class="ps-3">Brand Name</th>
                            <th>Slug</th>
                            <th>Products Sourced</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td class="ps-3 py-2 fw-bold text-dark">
                                <a href="{{ route('shop.index', ['brand' => $brand->slug]) }}" target="_blank" class="text-decoration-none d-flex align-items-center gap-2">
                                    <span class="badge bg-secondary-subtle text-dark border px-2 py-1">{{ $brand->name }}</span>
                                </a>
                            </td>
                            <td><code>{{ $brand->slug }}</code></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border">{{ $brand->products_count }} products</span>
                            </td>
                            <td class="text-end pe-3">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id }}" title="Edit Brand">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this brand?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>

                                <!-- Edit Brand Modal -->
                                <div class="modal fade text-start" id="editBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title fw-bold">Edit Brand: {{ $brand->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fs-13 fw-semibold">Brand Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fs-13 fw-semibold">Logo Asset Path</label>
                                                        <input type="text" name="logo" class="form-control" value="{{ $brand->logo }}">
                                                        <div class="form-text fs-11">Path to SVG or PNG logo inside public folder</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top">
                                                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-3 d-flex justify-content-center">
                {{ $brands->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Create Brand Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Add New Brand</h5>
            <form action="{{ route('admin.brands.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold">Brand Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="e.g. Gigabyte / Corsair" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold">Logo Asset Path (Optional)</label>
                    <input type="text" name="logo" class="form-control form-control-sm" placeholder="nevixra_assets/images/our-brands-image-1.svg">
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold rounded-pill">
                    <i class="ti ti-plus me-1"></i> Create Brand
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
