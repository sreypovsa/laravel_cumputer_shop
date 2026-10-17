@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 fw-bold">Manage Product Categories</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Categories List -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold text-dark">All Categories ({{ $categories->count() }})</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-13">
                    <thead class="table-light text-uppercase fs-12">
                        <tr>
                            <th class="ps-3">Category Name</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Products Count</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                        <tr>
                            <td class="ps-3 fw-bold text-dark">
                                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" target="_blank" class="text-decoration-none">
                                    {{ $cat->name }}
                                </a>
                            </td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td><i class="ti {{ $cat->icon ?? 'ti-folder' }} fs-18 text-primary"></i></td>
                            <td><span class="badge bg-primary-subtle text-primary border">{{ $cat->products_count }} products</span></td>
                            <td class="text-end pe-3">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $cat->id }}" title="Edit Category">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>

                                <!-- Edit Modal -->
                                <div class="modal fade text-start" id="editCategoryModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title fw-bold">Edit Category: {{ $cat->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fs-13 fw-semibold">Category Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fs-13 fw-semibold">Icon Class</label>
                                                        <input type="text" name="icon" class="form-control" value="{{ $cat->icon }}">
                                                        <div class="form-text fs-11">Examples: ti-device-laptop, ti-device-desktop, ti-cpu, ti-mouse, ti-keyboard, ti-headphones</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fs-13 fw-semibold">Description</label>
                                                        <textarea name="description" class="form-control" rows="3">{{ $cat->description }}</textarea>
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
        </div>
    </div>

    <!-- Create Category Form -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Add New Category</h5>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="e.g. Gaming Monitors" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold">Icon Class (Tabler Icons)</label>
                    <input type="text" name="icon" class="form-control form-control-sm" placeholder="e.g. ti-device-desktop" value="ti-device-laptop">
                </div>

                <div class="mb-3">
                    <label class="form-label fs-13 fw-semibold">Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Category description..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold rounded-pill">
                    <i class="ti ti-plus me-1"></i> Create Category
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
