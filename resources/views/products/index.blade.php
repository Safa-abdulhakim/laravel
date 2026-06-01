@extends('layouts.app')
@section('title', __('products.shop_title'))
@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-bag me-2 text-primary"></i>{{ __('products.shop_title') }}</h2>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 mt-2">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('common.home') }}</a></li>
            <li class="breadcrumb-item active text-white">{{ __('common.shop') }}</li>
        </ol></nav>
    </div>
</div>

<div class="container my-5">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold">{{ __('common.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="{{ __('products.search_ph') }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">{{ __('common.category') }}</label>
                    <select name="category" class="form-select">
                        <option value="">{{ __('products.all_categories') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">{{ __('products.sort_by') }}</label>
                    <select name="sort" class="form-select">
                        <option value="">{{ __('products.sort_latest') }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('products.sort_price_asc') }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('products.sort_price_desc') }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('products.sort_newest') }}</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i> {{ __('common.filter') }}</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0 small">
            {{ __('products.showing', ['first' => $products->firstItem() ?? 0, 'last' => $products->lastItem() ?? 0, 'total' => $products->total()]) }}
        </p>
    </div>

    @if($products->count())
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card h-100 position-relative">
                @if($product->category)
                    <span class="badge bg-primary position-absolute m-2" style="top:0;{{ app()->getLocale()==='ar'?'right':'left' }}:0;z-index:1;">{{ $product->category }}</span>
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
                            {{ $product->stock > 0 ? ($product->stock <= 5 ? __('products.low_stock') : __('products.in_stock')) : __('products.out_of_stock') }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3 d-flex gap-2">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye"></i></a>
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-fill">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn btn-primary btn-sm w-100" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-cart-plus me-1"></i>{{ __('products.add_to_cart') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 d-block mb-3"></i>
            <h5>{{ __('products.no_products') }}</h5>
            <p>{{ __('products.no_products_sub') }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">{{ __('products.clear_filters') }}</a>
        </div>
    @endif
</div>
@endsection
