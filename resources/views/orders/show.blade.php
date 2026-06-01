@extends('layouts.app')
@section('title', __('orders.order_num') . $order->id)
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">{{ __('orders.order_num') }}{{ $order->id }}</h2>
        <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>{{ __('orders.my_orders') }}
        </a>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent"><h5 class="mb-0">{{ __('admin.order_items') }}</h5></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>{{ __('orders.product') }}</th><th class="text-center">{{ __('orders.qty') }}</th><th class="text-end">{{ __('orders.unit_price') }}</th><th class="text-end">{{ __('cart.subtotal') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->product_price, 2) }}</td>
                                <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr><td colspan="3" class="text-end fw-bold">{{ __('common.total') }}</td>
                            <td class="text-end fw-bold text-primary">${{ number_format($order->total_amount, 2) }}</td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">{{ __('admin.customer_info') }}</h6>
                    <p class="mb-2"><small class="text-muted">{{ __('common.status') }}</small><br>
                        <span class="badge bg-{{ $order->status_badge }} mt-1">{{ __('orders.status_' . $order->status) }}</span></p>
                    <p class="mb-2"><small class="text-muted">{{ __('common.date') }}</small><br>{{ $order->created_at->format('M d, Y H:i') }}</p>
                    <p class="mb-2"><small class="text-muted">{{ __('orders.phone') }}</small><br>{{ $order->customer_phone }}</p>
                    <p class="mb-0"><small class="text-muted">{{ __('orders.address') }}</small><br>{{ $order->customer_address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
