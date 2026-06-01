@extends('layouts.app')
@section('title', __('orders.my_orders'))
@section('content')
<div class="bg-dark text-white py-4">
    <div class="container">
        <h2 class="fw-bold mb-0"><i class="bi bi-box me-2 text-primary"></i>{{ __('orders.my_orders') }}</h2>
    </div>
</div>
<div class="container my-5">
@if($orders->count())
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('common.date') }}</th>
                        <th>{{ __('admin.items') }}</th>
                        <th>{{ __('common.total') }}</th>
                        <th>{{ __('common.status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="fw-bold">#{{ $order->id }}</td>
                        <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="fw-bold text-primary">${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status_badge }}">
                                {{ __('orders.status_' . $order->status) }}
                            </span>
                        </td>
                        <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">{{ __('common.view') }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@else
<div class="text-center py-5">
    <i class="bi bi-box-seam" style="font-size:5rem;color:#dee2e6;"></i>
    <h4 class="mt-4 text-muted">{{ __('orders.no_orders') }}</h4>
    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">{{ __('orders.start_shopping') }}</a>
</div>
@endif
</div>
@endsection
