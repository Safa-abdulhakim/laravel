@extends('layouts.app')
@section('title', 'Shop')
@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-bag me-2 text-primary"></i>Shop All Products</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 mt-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold">Search</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="">Latest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i> Filter</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Results info -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products</p>
    </div>

    @if($products->count())
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100 position-relative">
                @if($product->category)
                    <span class="badge bg-primary position-absolute m-2" style="top:0;left:0;z-index:1;">{{ $product->category }}</span>
                @endif
                <a href="{{ route('products.show', $product) }}">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                </a>
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-1">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                    </h6>
                    <p class="text-muted small mb-auto">{{ Str::limit($product->description, 70) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                        <small class="badge {{ $product->stock > 5 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $product->stock > 0 ? ($product->stock <= 5 ? 'Low Stock' : 'In Stock') : 'Out of Stock' }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3 d-flex gap-2">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye"></i></a>
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-fill">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn btn-primary btn-sm w-100" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-1"></i>Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 d-block mb-3"></i>
            <h5>No products found</h5>
            <p>Try adjusting your search or filter criteria.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Clear Filters</a>
        </div>
    @endif
</div>
@endsection
