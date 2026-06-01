@extends('layouts.app')
@section('title', __('orders.checkout'))
@section('content')
<div class="bg-dark text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-credit-card me-2 text-primary"></i>{{ __('orders.checkout') }}</h2>
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0 mt-2">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">{{ __('common.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-white-50">{{ __('cart.title') }}</a></li>
            <li class="breadcrumb-item active text-white">{{ __('orders.checkout') }}</li>
        </ol></nav>
    </div>
</div>
<div class="container my-5">
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-0"><i class="bi bi-person me-2"></i>{{ __('orders.delivery_info') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('orders.full_name') }} *</label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name', $user->name ?? '') }}" required>
                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('orders.phone') }} *</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone') }}" required>
                        </div>
                        @error('customer_phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('orders.address') }} *</label>
                        <textarea name="customer_address" class="form-control @error('customer_address') is-invalid @enderror"
                                  rows="3" placeholder="{{ __('orders.address_ph') }}" required>{{ old('customer_address') }}</textarea>
                        @error('customer_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('orders.notes') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('orders.notes_ph') }}">{{ old('notes') }}</textarea>
                    </div>
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <small>{{ __('orders.demo_note') }}</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-circle me-2"></i>{{ __('orders.place_order') }} — ${{ number_format($total >= 50 ? $total : $total + 5.99, 2) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent py-3"><h5 class="mb-0"><i class="bi bi-bag me-2"></i>{{ __('cart.order_summary') }}</h5></div>
            <div class="card-body p-0">
                @foreach($cart as $item)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : asset('images/no-image.png') }}"
                         alt="{{ $item['name'] }}" class="rounded" style="width:55px;height:55px;object-fit:cover;">
                    <div class="flex-fill">
                        <div class="fw-semibold small">{{ $item['name'] }}</div>
                        <div class="text-muted small">{{ __('common.quantity') }}: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</div>
                    </div>
                    <span class="fw-bold">${{ number_format($item['subtotal'], 2) }}</span>
                </div>
                @endforeach
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between text-muted small mb-2">
                    <span>{{ __('cart.subtotal') }}</span><span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between text-success small mb-2">
                    <span>{{ __('cart.shipping') }}</span><span>{{ $total >= 50 ? __('cart.free') : '$5.99' }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between fw-bold">
                    <span>{{ __('common.total') }}</span>
                    <span class="text-primary fs-5">${{ number_format($total >= 50 ? $total : $total + 5.99, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-arrow-left me-2"></i>{{ __('common.back') }}
            </a>
        </div>
    </div>
</div>
</div>
@endsection
