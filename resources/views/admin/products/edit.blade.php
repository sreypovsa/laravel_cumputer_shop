@extends('layouts.admin')

@section('title', 'Edit Product #' . $product->id)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Edit Product: {{ $product->name }}</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="ti ti-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fs-13 fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Model / SKU Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $product->code) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Brand</label>
                <select name="brand_id" class="form-select">
                    <option value="">-- None / Other --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Sale Price ($) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Original Price ($)</label>
                <input type="number" step="0.01" name="original_price" class="form-control" value="{{ old('original_price', $product->original_price) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fs-13 fw-semibold">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Product Image URL</label>
                <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $product->image) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fs-13 fw-semibold">Replace Local Image</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>

            @if($product->image)
            <div class="col-12">
                <label class="form-label fs-13 fw-semibold d-block">Current Product Image</label>
                <div class="p-2 border rounded d-inline-block bg-light">
                    <img src="{{ $product->image_url }}" alt="Preview" style="max-height: 120px; max-width: 180px; object-fit: contain;">
                </div>
            </div>
            @endif

            <div class="col-12">
                <label class="form-label fs-13 fw-semibold">Free Gifts Included</label>
                <input type="text" name="free_gifts" class="form-control" value="{{ old('free_gifts', $product->free_gifts) }}">
            </div>

            <div class="col-12">
                <label class="form-label fs-13 fw-semibold">Technical Specifications</label>
                <textarea name="specs" class="form-control" rows="6">{{ old('specs', $product->specs) }}</textarea>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fs-13" for="is_featured">Mark as Featured Product on Homepage</label>
                </div>
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill">
                    <i class="ti ti-check me-1"></i> Update Product
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
