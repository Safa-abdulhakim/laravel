@extends('layouts.app')
@section('title', __('app.dashboard'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">{{ __('app.dashboard') }}</h4>
        <p class="text-muted mb-0 small">{{ __('app.welcome', ['name' => auth()->user()->name]) }}</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <form method="GET" class="d-flex gap-2">
            <select name="period" class="form-select form-select-sm" onchange="this.form.submit()" style="width:auto;">
                <option value="7"  {{ $period == 7  ? 'selected' : '' }}>{{ app()->getLocale()==='ar' ? 'آخر 7 أيام' : 'Last 7 days' }}</option>
                <option value="30" {{ $period == 30 ? 'selected' : '' }}>{{ app()->getLocale()==='ar' ? 'آخر 30 يوم' : 'Last 30 days' }}</option>
                <option value="90" {{ $period == 90 ? 'selected' : '' }}>{{ app()->getLocale()==='ar' ? 'آخر 90 يوم' : 'Last 90 days' }}</option>
            </select>
        </form>
        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>{{ __('app.new_sale') }}
        </a>
    </div>
</div>

{{-- إحصائيات --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#ede9fe;"><i class="bi bi-cash-stack" style="color:#7c3aed;"></i></div>
                <div>
                    <div class="text-muted small">{{ __('app.total_revenue') }}</div>
                    <div class="fw-bold fs-5">${{ number_format($totalSales, 2) }}</div>
                    <div class="text-muted" style="font-size:0.72rem;">{{ __('app.last_x_days', ['days' => $period]) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#dcfce7;"><i class="bi bi-receipt-cutoff" style="color:#16a34a;"></i></div>
                <div>
                    <div class="text-muted small">{{ __('app.total_orders') }}</div>
                    <div class="fw-bold fs-5">{{ number_format($totalOrders) }}</div>
                    <div class="text-muted" style="font-size:0.72rem;">{{ __('app.last_x_days', ['days' => $period]) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#dbeafe;"><i class="bi bi-people" style="color:#2563eb;"></i></div>
                <div>
                    <div class="text-muted small">{{ __('app.total_customers') }}</div>
                    <div class="fw-bold fs-5">{{ number_format($totalCustomers) }}</div>
                    <div class="text-muted" style="font-size:0.72rem;">{{ __('app.registered') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fef9c3;"><i class="bi bi-box-seam" style="color:#ca8a04;"></i></div>
                <div>
                    <div class="text-muted small">{{ __('app.active_products') }}</div>
                    <div class="fw-bold fs-5">{{ number_format($totalProducts) }}</div>
                    @if($outOfStockProducts > 0)
                    <div style="font-size:0.72rem;color:#dc2626;">{{ __('app.out_of_stock_count', ['count' => $outOfStockProducts]) }}</div>
                    @else
                    <div class="text-muted" style="font-size:0.72rem;">{{ __('app.all_in_stock') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card table-card h-100">
            <div class="card-header px-4 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>{{ __('app.sales_overview') }}</h6>
            </div>
            <div class="card-body"><canvas id="salesChart" height="110"></canvas></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card table-card h-100">
            <div class="card-header px-4 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-trophy me-2 text-warning"></i>{{ __('app.top_selling') }}</h6>
            </div>
            <div class="card-body p-0">
                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center gap-3 px-4 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <span class="fw-bold text-muted" style="width:1.5rem;font-size:0.85rem;">{{ $i + 1 }}</span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $product->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">{{ __('app.units_sold', ['qty' => number_format($product->total_qty)]) }}</div>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold">${{ number_format($product->total_revenue, 0) }}</span>
                </div>
                @empty
                <div class="text-center py-4 text-muted small">{{ __('app.no_sales_data') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    @if($lowStockProducts->isNotEmpty())
    <div class="col-lg-5">
        <div class="card table-card">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>{{ __('app.low_stock_alerts') }}</h6>
                <span class="badge bg-warning text-dark">{{ $lowStockProducts->count() }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">{{ __('app.product') }}</th>
                            <th>{{ __('app.quantity') }}</th>
                            <th>{{ __('app.low_stock_alert') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td class="px-4">
                                <a href="{{ route('products.show', $product) }}" class="text-decoration-none fw-semibold small">{{ $product->name }}</a>
                                <div class="text-muted" style="font-size:0.7rem;">{{ $product->category->name }}</div>
                            </td>
                            <td><span class="badge bg-danger">{{ $product->quantity }}</span></td>
                            <td class="text-muted small">{{ $product->low_stock_threshold }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-{{ $lowStockProducts->isNotEmpty() ? '7' : '12' }}">
        <div class="card table-card">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>{{ __('app.recent_sales') }}</h6>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light">{{ __('app.view_all') }}</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">{{ __('app.invoice') }}</th>
                            <th>{{ __('app.customer') }}</th>
                            <th>{{ __('app.items') }}</th>
                            <th>{{ __('app.total') }}</th>
                            <th>{{ __('app.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td class="px-4">
                                <a href="{{ route('sales.show', $sale) }}" class="text-decoration-none fw-semibold small text-primary">{{ $sale->invoice_number }}</a>
                            </td>
                            <td class="small">{{ $sale->customer?->name ?? __('app.walk_in') }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $sale->items->count() }}</span></td>
                            <td class="fw-semibold small">${{ number_format($sale->total, 2) }}</td>
                            <td class="text-muted small">{{ $sale->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('app.no_sales_yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($salesChart->pluck('date')),
        datasets: [{
            label: '{{ app()->getLocale() === "ar" ? "المبيعات ($)" : "Sales ($)" }}',
            data: @json($salesChart->pluck('total')),
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79,70,229,0.08)',
            borderWidth: 2, fill: true, tension: 0.4,
            pointBackgroundColor: '#4f46e5', pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '$' + v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
