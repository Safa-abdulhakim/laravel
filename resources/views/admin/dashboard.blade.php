@extends('layouts.admin')
@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))
@section('page-subtitle', __('admin.welcome_back', ['name' => auth()->user()->name]))

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10"><i class="bi bi-box-seam text-primary fs-2"></i></div>
                <div>
                    <div class="text-muted small">{{ __('admin.total_products') }}</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_products'] }}</div>
                    <small class="text-success">{{ $stats['active_products'] }} {{ __('admin.active_products') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10"><i class="bi bi-receipt text-warning fs-2"></i></div>
                <div>
                    <div class="text-muted small">{{ __('admin.total_orders') }}</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_orders'] }}</div>
                    <small class="text-warning">{{ $stats['pending_orders'] }} {{ __('admin.pending') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-info bg-opacity-10"><i class="bi bi-people text-info fs-2"></i></div>
                <div>
                    <div class="text-muted small">{{ __('admin.customers') }}</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_users'] }}</div>
                    <small class="text-muted">{{ __('admin.registered') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10"><i class="bi bi-currency-dollar text-success fs-2"></i></div>
                <div>
                    <div class="text-muted small">{{ __('admin.total_revenue') }}</div>
                    <div class="fs-3 fw-bold">${{ number_format($stats['total_revenue'], 0) }}</div>
                    <small class="text-success">{{ __('admin.this_month') }}: ${{ number_format($stats['monthly_revenue'], 0) }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>{{ __('admin.recent_orders') }}</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">{{ __('admin.view_all') }}</a>
            </div>
            <div class="card-body p-0">
                @if($recent_orders->count())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>#</th><th>{{ __('admin.customer') }}</th><th>{{ __('admin.items') }}</th><th>{{ __('common.total') }}</th><th>{{ __('common.status') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none">#{{ $order->id }}</a></td>
                                <td>{{ $order->customer_name }}</td>
                                <td><span class="badge bg-secondary">{{ $order->items->count() }}</span></td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $order->status_badge }}">{{ __('orders.status_' . $order->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted"><i class="bi bi-receipt d-block fs-3 mb-2"></i>{{ __('admin.no_orders') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>{{ __('admin.low_stock') }}</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-warning">{{ __('admin.manage') }}</a>
            </div>
            <div class="card-body p-0">
                @if($low_stock->count())
                @foreach($low_stock as $product)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="flex-fill">
                        <div class="fw-semibold small">{{ $product->name }}</div>
                        <div class="text-muted small">{{ $product->category }}</div>
                    </div>
                    <span class="badge {{ $product->stock == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                        {{ __('admin.left', ['count' => $product->stock]) }}
                    </span>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                @endforeach
                @else
                <div class="text-center py-4 text-success">
                    <i class="bi bi-check-circle d-block fs-3 mb-2"></i>
                    <span class="small">{{ __('admin.all_stocked') }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2 text-primary"></i>{{ __('admin.quick_actions') }}</h5></div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('admin.add_product') }}
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-warning">
                    <i class="bi bi-clock me-2"></i>{{ __('admin.pending_orders', ['count' => $stats['pending_orders']]) }}
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-shop me-2"></i>{{ __('admin.view_store') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
