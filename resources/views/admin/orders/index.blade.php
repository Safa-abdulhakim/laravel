@extends('layouts.admin')
@section('title', __('admin.orders'))
@section('page-title', __('admin.orders'))
@section('page-subtitle', __('admin.manage_orders'))

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="{{ __('common.search') }}..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">{{ __('admin.all_statuses') }}</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ __('orders.status_' . $s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i> {{ __('common.filter') }}</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x"></i> {{ __('common.clear') }}</a>
            </div>
        </form>
    </div>
</div>

<div class="d-flex gap-2 flex-wrap mb-4">
    <a href="{{ route('admin.orders.index') }}" class="badge bg-secondary text-decoration-none fs-6">{{ __('admin.all_status_link') }}</a>
    @foreach($statusList as $s)
    @php $badge = match($s) { 'pending'=>'warning', 'processing'=>'info', 'shipped'=>'primary', 'completed'=>'success', 'cancelled'=>'danger', default=>'secondary' }; @endphp
    <a href="{{ route('admin.orders.index', ['status'=>$s]) }}" class="badge bg-{{ $badge }} text-decoration-none fs-6">{{ __('orders.status_' . $s) }}</a>
    @endforeach
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">{{ __('admin.orders') }} ({{ $orders->total() }})</h5>
    </div>
    <div class="card-body p-0">
        @if($orders->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>{{ __('admin.customer') }}</th><th>{{ __('orders.phone') }}</th>
                        <th class="text-center">{{ __('admin.items') }}</th><th class="text-end">{{ __('common.total') }}</th>
                        <th class="text-center">{{ __('common.status') }}</th><th>{{ __('common.date') }}</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="fw-bold">#{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td class="text-muted small">{{ $order->customer_phone }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $order->items->count() }}</span></td>
                        <td class="text-end fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="text-center"><span class="badge bg-{{ $order->status_badge }}">{{ __('orders.status_' . $order->status) }}</span></td>
                        <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">{{ $orders->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-receipt d-block fs-1 mb-3"></i>
            <h5>{{ __('admin.no_orders_found') }}</h5>
        </div>
        @endif
    </div>
</div>
@endsection
