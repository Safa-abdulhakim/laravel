@extends('layouts.app')
@section('title', __('app.sales_history'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">{{ __('app.sales_history') }}</h4>
        <p class="text-muted mb-0 small">{{ app()->getLocale()==='ar' ? 'جميع الفواتير والمعاملات' : 'All invoices and transactions' }}</p>
    </div>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-1"></i>{{ __('app.new_sale') }}
    </a>
</div>

<div class="card table-card">
    <div class="card-header px-4 py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="{{ app()->getLocale()==='ar' ? 'بحث برقم الفاتورة...' : 'Search invoice...' }}">
            </div>
            <div class="col-md-2">
                <select name="customer" class="form-select form-select-sm">
                    <option value="">{{ __('app.all_customers') }}</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ request('customer')==$c->id ? 'selected':'' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">{{ __('app.all_status') }}</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>{{ __('app.completed') }}</option>
                    <option value="pending"   {{ request('status')=='pending'   ? 'selected':'' }}>{{ __('app.pending') }}</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>{{ __('app.cancelled') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-sm btn-primary w-100"><i class="bi bi-search"></i></button>
            </div>
        </form>
        @if(request()->hasAny(['search','customer','status','date_from','date_to']))
        <div class="mt-2">
            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light text-muted py-0 px-2 small">
                <i class="bi bi-x me-1"></i>{{ __('app.reset') }}
            </a>
        </div>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4">{{ __('app.invoice') }}</th>
                        <th>{{ __('app.customer') }}</th>
                        <th>{{ __('app.items') }}</th>
                        <th>{{ __('app.subtotal') }}</th>
                        <th>{{ __('app.discount') }}</th>
                        <th>{{ __('app.total') }}</th>
                        <th>{{ __('app.payment_method') }}</th>
                        <th>{{ __('app.status') }}</th>
                        <th>{{ __('app.date') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td class="px-4">
                            <a href="{{ route('sales.show', $sale) }}" class="fw-semibold small text-primary text-decoration-none">{{ $sale->invoice_number }}</a>
                        </td>
                        <td class="small">{{ $sale->customer?->name ?? __('app.walk_in') }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $sale->items->count() }}</span></td>
                        <td class="small">${{ number_format($sale->subtotal, 2) }}</td>
                        <td class="small text-danger">{{ $sale->discount > 0 ? '-$'.number_format($sale->discount,2) : '-' }}</td>
                        <td class="fw-semibold small">${{ number_format($sale->total, 2) }}</td>
                        <td class="small text-muted">
                            {{ ['cash'=>__('app.cash'),'card'=>__('app.card'),'bank_transfer'=>__('app.bank_transfer'),'other'=>__('app.other')][$sale->payment_method] ?? $sale->payment_method }}
                        </td>
                        <td>
                            @if($sale->status==='completed')
                                <span class="badge bg-success">{{ __('app.completed') }}</span>
                            @elseif($sale->status==='pending')
                                <span class="badge bg-warning text-dark">{{ __('app.pending') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('app.cancelled') }}</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $sale->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2 opacity-30"></i>
                            {{ __('app.no_sales') }}
                            <a href="{{ route('sales.create') }}">{{ __('app.create_first_sale') }}</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sales->hasPages())
    <div class="card-footer bg-white px-4 py-2">{{ $sales->links() }}</div>
    @endif
</div>
@endsection
