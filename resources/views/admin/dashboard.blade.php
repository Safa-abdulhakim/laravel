@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                    <i class="bi bi-box-seam text-primary fs-2"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Products</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_products'] }}</div>
                    <small class="text-success">{{ $stats['active_products'] }} active</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                    <i class="bi bi-receipt text-warning fs-2"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Orders</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_orders'] }}</div>
                    <small class="text-warning">{{ $stats['pending_orders'] }} pending</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-info bg-opacity-10">
                    <i class="bi bi-people text-info fs-2"></i>
                </div>
                <div>
                    <div class="text-muted small">Customers</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_users'] }}</div>
                    <small class="text-muted">registered users</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-3 p-3 bg-success bg-opacity-10">
                    <i class="bi bi-currency-dollar text-success fs-2"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Revenue</div>
                    <div class="fs-3 fw-bold">${{ number_format($stats['total_revenue'], 0) }}</div>
                    <small class="text-success">This month: ${{ number_format($stats['monthly_revenue'], 0) }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recent_orders->count())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>#</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none">#{{ $order->id }}</a></td>
                                <td>{{ $order->customer_name }}</td>
                                <td><span class="badge bg-secondary">{{ $order->items->count() }}</span></td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="badge bg-{{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted"><i class="bi bi-receipt d-block fs-3 mb-2"></i>No orders yet</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-warning">Manage</a>
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
                        {{ $product->stock }} left
                    </span>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>
                @endforeach
                @else
                <div class="text-center py-4 text-success">
                    <i class="bi bi-check-circle d-block fs-3 mb-2"></i>
                    <span class="small">All products are well-stocked!</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-transparent py-3"><h5 class="mb-0 fw-bold"><i class="bi bi-lightning me-2 text-primary"></i>Quick Actions</h5></div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-warning">
                    <i class="bi bi-clock me-2"></i>View Pending Orders ({{ $stats['pending_orders'] }})
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-shop me-2"></i>View Storefront
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
