@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('common.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('common.shop') }}</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category]) }}">{{ $product->category }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm overflow-hidden rounded-3">
                <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->name }}" style="max-height:450px;object-fit:cover;">
            </div>
        </div>
        <div class="col-md-7">
            @if($product->category)
                <span class="badge bg-primary mb-2">{{ $product->category }}</span>
            @endif
            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
            <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
                <span class="display-6 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                @if($product->stock > 0)
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ $product->stock <= 5 ? __('products.only_left', ['count' => $product->stock]) : __('products.in_stock') }}
                    </span>
                @else
                    <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>{{ __('products.out_of_stock') }}</span>
                @endif
            </div>

            <p class="text-muted mb-4" style="line-height:1.8;">{{ $product->description }}</p>

            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-auto">
                        <label class="form-label fw-semibold">{{ __('common.quantity') }}</label>
                        <div class="input-group" style="width:140px;">
                            <button type="button" class="btn btn-outline-secondary" onclick="let i=document.getElementById('qty');if(i.value>1)i.value--">-</button>
                            <input type="number" id="qty" name="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" class="btn btn-outline-secondary" onclick="let i=document.getElementById('qty');if(i.value<{{ $product->stock }})i.value++">+</button>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-cart-plus me-2"></i>{{ __('products.add_to_cart') }}
                        </button>
                    </div>
                </div>
            </form>
            @else
                <div class="alert alert-danger"><i class="bi bi-x-circle me-2"></i>{{ __('products.out_of_stock') }}</div>
            @endif

            <div class="mt-4 d-flex gap-3 text-muted small flex-wrap">
                <span><i class="bi bi-truck me-1"></i>{{ __('products.free_ship_msg') }}</span>
                <span><i class="bi bi-arrow-return-left me-1"></i>{{ __('products.returns_msg') }}</span>
                <span><i class="bi bi-shield-check me-1"></i>{{ __('products.secure_msg') }}</span>
            </div>
        </div>
    </div>

    @if($related->count())
    <div class="mt-5">
        <h3 class="fw-bold mb-4">{{ __('products.related') }}</h3>
        <div class="row g-4">
            @foreach($related as $item)
            <div class="col-sm-6 col-md-3">
                <div class="card product-card h-100">
                    <a href="{{ route('products.show', $item) }}">
                        <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->name }}" style="height:160px;object-fit:cover;">
                    </a>
                    <div class="card-body">
                        <h6><a href="{{ route('products.show', $item) }}" class="text-decoration-none text-dark">{{ $item->name }}</a></h6>
                        <span class="text-primary fw-bold">${{ number_format($item->price, 2) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
