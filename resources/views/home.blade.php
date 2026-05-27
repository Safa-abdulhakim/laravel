@extends('layouts.app')
@section('title', 'Home')
@section('content')

<!-- Hero -->
<div class="bg-dark text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Welcome to <span class="text-primary">ShopLaravel</span></h1>
                <p class="lead text-muted mb-4">Discover amazing products at unbeatable prices. Quality guaranteed, fast delivery, easy returns.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-bag me-2"></i>Shop Now
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Join Free</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="bi bi-shop-window" style="font-size: 10rem; color: #0d6efd; opacity:.4;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<div class="bg-primary text-white py-3">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-md-3"><i class="bi bi-truck me-2"></i>Free Shipping over $50</div>
            <div class="col-md-3"><i class="bi bi-arrow-return-left me-2"></i>30-Day Returns</div>
            <div class="col-md-3"><i class="bi bi-shield-check me-2"></i>Secure Payment</div>
            <div class="col-md-3"><i class="bi bi-headset me-2"></i>24/7 Support</div>
        </div>
    </div>
</div>

<!-- Categories -->
@if($categories->count())
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">Shop by Category</h2>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $cat)
        <div class="col-6 col-md-3 col-lg-2">
            <a href="{{ route('products.index', ['category' => $cat]) }}" class="text-decoration-none">
                <div class="card text-center py-4 h-100 border-0 shadow-sm" style="transition: transform .2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                    <div class="card-body">
                        @php
                            $icons = ['Electronics'=>'bi-cpu','Clothing'=>'bi-bag','Books'=>'bi-book','Home & Garden'=>'bi-house','Sports'=>'bi-bicycle','default'=>'bi-grid'];
                            $icon = $icons[$cat] ?? $icons['default'];
                        @endphp
                        <i class="bi {{ $icon }} fs-2 text-primary mb-2 d-block"></i>
                        <span class="fw-semibold text-dark">{{ $cat }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Featured Products -->
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Featured Products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    @if($featured->count())
    <div class="row g-4">
        @foreach($featured as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
                <a href="{{ route('products.show', $product) }}">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                </a>
                @if($product->category)
                    <span class="badge bg-primary position-absolute m-2" style="top:0;left:0;">{{ $product->category }}</span>
                @endif
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-1">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                    </h6>
                    <p class="text-muted small mb-auto">{{ Str::limit($product->description, 60) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                        <span class="badge {{ $product->stock > 5 ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <form action="{{ route('cart.add', $product) }}" method="POST">
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
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
            <p>No products available yet. Check back soon!</p>
        </div>
    @endif
</div>

<!-- CTA -->
<div class="bg-dark text-white py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">Ready to start shopping?</h3>
        <p class="text-muted mb-4">Join thousands of happy customers today.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">Create Account</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg">Browse Products</a>
        @else
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Browse All Products</a>
        @endguest
    </div>
</div>
@endsection
