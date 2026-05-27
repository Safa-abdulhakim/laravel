@extends('layouts.admin')
@section('title', isset($product) ? 'Edit Product' : 'Add Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add New Product')
@section('page-subtitle', isset($product) ? 'Update product details' : 'Add a product to your catalog')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ isset($product) ? 'Edit: ' . $product->name : 'New Product' }}</h5>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product)) @method('PUT') @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="4" placeholder="Describe the product...">{{ old('description', $product->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Price ($) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="price" step="0.01" min="0"
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $product->price ?? '') }}" placeholder="0.00" required>
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Stock Quantity *</label>
                                <input type="number" name="stock" min="0"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       value="{{ old('stock', $product->stock ?? 0) }}" required>
                                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-semibold">Category</label>
                            <input type="text" name="category" class="form-control"
                                   value="{{ old('category', $product->category ?? '') }}"
                                   placeholder="e.g. Electronics, Clothing, Books" list="category-list">
                            <datalist id="category-list">
                                @foreach(['Electronics','Clothing','Books','Home & Garden','Sports','Toys','Beauty','Food'] as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product Image</label>
                            <div class="border rounded-3 p-3 text-center mb-2" style="background:#f8f9fa;">
                                <img id="preview" src="{{ isset($product) && $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                                     class="img-fluid rounded mb-2" style="max-height:200px;object-fit:contain;" alt="Preview">
                                <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*" onchange="previewImage(this)">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted d-block mt-1">Max 2MB. JPG, PNG, GIF, WebP</small>
                            </div>
                        </div>

                        <div class="card bg-light border-0 p-3">
                            <h6 class="fw-semibold mb-3">Product Status</h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="statusToggle" value="1"
                                       {{ old('status', $product->status ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="statusToggle">
                                    Active (visible in store)
                                </label>
                            </div>
                            <small class="text-muted mt-2 d-block">Inactive products won't appear in the storefront.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-{{ isset($product) ? 'floppy' : 'plus-circle' }} me-2"></i>
                        {{ isset($product) ? 'Update Product' : 'Create Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
function previewImage(input) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview').src = e.target.result;
    if (input.files[0]) reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
