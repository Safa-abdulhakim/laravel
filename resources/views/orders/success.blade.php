@extends('layouts.app')
@section('title', 'Order Confirmed')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" style="width:100px;height:100px;">
                            <i class="bi bi-check-lg text-white" style="font-size:3rem;"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-success mb-2">Order Confirmed!</h2>
                    <p class="text-muted mb-1">Thank you, <strong>{{ $order->customer_name }}</strong>!</p>
                    <p class="text-muted mb-4">Your order <strong>#{{ $order->id }}</strong> has been placed successfully.</p>

                    <div class="card bg-light border-0 mb-4 text-start">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Order #</small>
                                    <span class="fw-bold">#{{ $order->id }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $order->customer_phone }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Total</small>
                                    <span class="fw-bold text-primary">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Delivery Address</small>
                                    <span>{{ $order->customer_address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-start mb-3">Items Ordered:</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm text-start">
                            <thead class="table-light"><tr><th>Product</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr></thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="2">Total</td>
                                    <td class="text-end text-primary">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="bi bi-house me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-bag me-2"></i>Continue Shopping
                        </a>
                        @auth
                        <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-box me-2"></i>My Orders
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
