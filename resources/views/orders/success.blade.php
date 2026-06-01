@extends('layouts.app')
@section('title', __('orders.confirmed'))
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
                    <h2 class="fw-bold text-success mb-2">{{ __('orders.confirmed') }}</h2>
                    <p class="text-muted mb-1">{{ __('orders.thank_you', ['name' => $order->customer_name]) }}</p>
                    <p class="text-muted mb-4">{{ __('orders.order_placed', ['id' => $order->id]) }}</p>

                    <div class="card bg-light border-0 mb-4 text-start">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">{{ __('orders.order_num') }}</small>
                                    <span class="fw-bold">#{{ $order->id }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">{{ __('common.status') }}</small>
                                    <span class="badge bg-warning text-dark">{{ __('orders.status_pending') }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">{{ __('orders.phone') }}</small>
                                    <span>{{ $order->customer_phone }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">{{ __('common.total') }}</small>
                                    <span class="fw-bold text-primary">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">{{ __('orders.address') }}</small>
                                    <span>{{ $order->customer_address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-start mb-3">{{ __('orders.items_ordered') }}</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm text-start">
                            <thead class="table-light">
                                <tr><th>{{ __('orders.product') }}</th><th class="text-center">{{ __('orders.qty') }}</th><th class="text-end">{{ __('cart.subtotal') }}</th></tr>
                            </thead>
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
                                    <td colspan="2">{{ __('common.total') }}</td>
                                    <td class="text-end text-primary">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="bi bi-house me-2"></i>{{ __('orders.back_home') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-bag me-2"></i>{{ __('orders.cont_shopping') }}
                        </a>
                        @auth
                        <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-box me-2"></i>{{ __('orders.my_orders') }}
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
