@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Add New Computer Product</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="ti ti-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fs-13 fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. ASUS ROG Strix G16 (2026)" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Model / SKU Code</label>
                <input type="text" name="code" class="form-control" placeholder="e.g. L001-B1503CVA1" value="{{ old('code') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">-- Select Brand --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Sale Price ($) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="899.00" value="{{ old('price') }}" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Original Price ($) (Optional)</label>
                <input type="number" step="0.01" name="original_price" class="form-control" placeholder="999.00" value="{{ old('original_price') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="20" value="{{ old('stock', 15) }}" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Product Image URL</label>
                <input type="url" name="image_url" class="form-control" placeholder="https://..." value="{{ old('image_url') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Or Upload Local Image</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>

            <div class="col-12">
                <label class="form-label fs-13 fw-semibold">Free Gift Package</label>
                <input type="text" name="free_gifts" class="form-control" placeholder="e.g. Backpack, Wireless Mouse, Mousepad, Cleaning Kit" value="{{ old('free_gifts') }}">
            </div>

            <div class="col-12">
                <label class="form-label fs-13 fw-semibold">Technical Specifications (One per line or formatted)</label>
                <textarea name="specs" class="form-control" rows="5" placeholder="- CPU : Intel Core Ultra 7&#10;- RAM : 16GB DDR5&#10;- SSD : 1TB PCIe&#10;- Display : 16 inch 144Hz&#10;- GPU : RTX 4060 8GB">{{ old('specs') }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label fs-13" for="is_featured">Mark as Featured Product on Homepage</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                    <i class="ti ti-check me-1"></i> Save Product
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
