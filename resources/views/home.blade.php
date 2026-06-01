@extends('layouts.app')
@section('title', __('common.home'))
@section('content')

<div class="bg-dark text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">
                    {{ __('common.welcome') }} <span class="text-primary">{{ __('common.app_name') }}</span>
                </h1>
                <p class="lead text-muted mb-4">{{ __('common.tagline') }}</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-bag me-2"></i>{{ __('products.view_all') }}
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">{{ __('common.register') }}</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="bi bi-shop-window" style="font-size:10rem;color:#0d6efd;opacity:.4;"></i>
            </div>
        </div>
    </div>
</div>

<div class="bg-primary text-white py-3">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-md-3"><i class="bi bi-truck me-2"></i>{{ __('common.free_shipping') }}</div>
            <div class="col-md-3"><i class="bi bi-arrow-return-left me-2"></i>{{ __('common.returns') }}</div>
            <div class="col-md-3"><i class="bi bi-shield-check me-2"></i>{{ __('common.secure_payment') }}</div>
            <div class="col-md-3"><i class="bi bi-headset me-2"></i>{{ __('common.support') }}</div>
        </div>
    </div>
</div>

@if($categories->count())
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">{{ __('products.shop_by_cat') }}</h2>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $cat)
        <div class="col-6 col-md-3 col-lg-2">
            <a href="{{ route('products.index', ['category' => $cat]) }}" class="text-decoration-none">
                <div class="card text-center py-4 h-100 border-0 shadow-sm" style="transition:transform .2s;"
                     onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                    <div class="card-body">
                        @php $icons=['Electronics'=>'bi-cpu','Clothing'=>'bi-bag','Books'=>'bi-book','Home & Garden'=>'bi-house','Sports'=>'bi-bicycle','default'=>'bi-grid']; $icon=$icons[$cat]??$icons['default']; @endphp
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

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">{{ __('products.featured') }}</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
            {{ __('products.view_all') }} <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    @if($featured->count())
    <div class="row g-4">
        @foreach($featured as $product)
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
                    <p class="text-muted small mb-auto">{{ Str::limit($product->description, 60) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                        <span class="badge {{ $product->stock > 5 ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $product->stock > 0 ? __('products.in_stock') : __('products.out_of_stock') }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <form action="{{ route('cart.add', $product) }}" method="POST">
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
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
            <p>{{ __('products.no_products') }}</p>
        </div>
    @endif
</div>

<div class="bg-dark text-white py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">{{ __('common.welcome') }} {{ __('common.app_name') }}</h3>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">{{ __('common.register') }}</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg">{{ __('products.all_products') }}</a>
        @else
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">{{ __('products.all_products') }}</a>
        @endguest
    </div>
</div>
@endsection
