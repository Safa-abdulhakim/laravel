@extends('layouts.app')
@section('title', 'Shopping Cart')
@section('content')
<div class="bg-dark text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-cart3 me-2 text-primary"></i>Shopping Cart</h2>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 mt-2">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol></nav>
    </div>
</div>

<div class="container my-5">
@if(empty($cart))
    <div class="text-center py-5">
        <i class="bi bi-cart-x" style="font-size:5rem;color:#dee2e6;"></i>
        <h4 class="mt-4 text-muted">Your cart is empty</h4>
        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mt-3">
            <i class="bi bi-bag me-2"></i>Start Shopping
        </a>
    </div>
@else
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Cart Items ({{ array_sum(array_column($cart, 'quantity')) }})</h5>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Clear entire cart?')">
                        <i class="bi bi-trash me-1"></i>Clear All
                    </button>
                </form>
            </div>
            <div class="card-body p-0">
                @foreach($cart as $productId => $item)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : asset('images/no-image.png') }}"
                         alt="{{ $item['name'] }}" class="rounded" style="width:80px;height:80px;object-fit:cover;">
                    <div class="flex-fill">
                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                        <span class="text-primary fw-semibold">${{ number_format($item['price'], 2) }}</span>
                    </div>
                    <form action="{{ route('cart.update', $productId) }}" method="POST" class="d-flex align-items-center gap-2" style="width:160px;">
                        @csrf @method('PATCH')
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="let i=this.nextElementSibling;if(i.value>1){i.value--;this.form.submit()}">-</button>
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}"
                               class="form-control form-control-sm text-center" style="width:55px;"
                               onchange="this.form.submit()">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="let i=this.previousElementSibling;if(i.value<{{ $item['stock'] }}){i.value++;this.form.submit()}">+</button>
                    </form>
                    <div class="text-end" style="min-width:80px;">
                        <div class="fw-bold">${{ number_format($item['subtotal'], 2) }}</div>
                        <form action="{{ route('cart.remove', $productId) }}" method="POST" class="mt-1">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-link text-danger p-0">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3"><h5 class="mb-0">Order Summary</h5></div>
            <div class="card-body">
                @foreach($cart as $item)
                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                    <span>${{ number_format($item['subtotal'], 2) }}</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-1">
                    <span>Subtotal</span><span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between text-success mb-1">
                    <span>Shipping</span><span>{{ $total >= 50 ? 'Free' : '$5.99' }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary">${{ number_format($total >= 50 ? $total : $total + 5.99, 2) }}</span>
                </div>
                @if($total < 50)
                <div class="alert alert-info small mt-3 mb-0 py-2">
                    <i class="bi bi-info-circle me-1"></i>Add ${{ number_format(50 - $total, 2) }} more for free shipping!
                </div>
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-lg">
                    <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
</div>
@endif
</div>
@endsection
