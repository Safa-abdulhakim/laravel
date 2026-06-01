@extends('layouts.app')
@section('title', __('app.invoice') . ' ' . $sale->invoice_number)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i></a>
    <div class="flex-grow-1">
        <h4 class="fw-bold mb-0">{{ __('app.invoice') }}: {{ $sale->invoice_number }}</h4>
        <p class="text-muted mb-0 small">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-sm btn-light">
            <i class="bi bi-printer me-1"></i>{{ __('app.print_invoice') }}
        </button>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card table-card mb-3">
            <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">{{ app()->getLocale()==='ar' ? 'معلومات الفاتورة' : 'Invoice Info' }}</h6></div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted small">{{ __('app.invoice_number') }}</td>
                        <td class="fw-semibold small">{{ $sale->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">{{ __('app.status') }}</td>
                        <td>
                            @if($sale->status==='completed')
                                <span class="badge bg-success">{{ __('app.completed') }}</span>
                            @elseif($sale->status==='pending')
                                <span class="badge bg-warning text-dark">{{ __('app.pending') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('app.cancelled') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">{{ __('app.payment_method') }}</td>
                        <td class="small">{{ ['cash'=>__('app.cash'),'card'=>__('app.card'),'bank_transfer'=>__('app.bank_transfer'),'other'=>__('app.other')][$sale->payment_method] ?? $sale->payment_method }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">{{ __('app.sold_by') }}</td>
                        <td class="small">{{ $sale->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">{{ __('app.date') }}</td>
                        <td class="small">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($sale->customer)
        <div class="card table-card mb-3">
            <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">{{ __('app.customer') }}</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div style="width:38px;height:38px;background:#ede9fe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#7c3aed;flex-shrink:0;">
                        {{ strtoupper(mb_substr($sale->customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold small">{{ $sale->customer->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">{{ $sale->customer->phone }}</div>
                    </div>
                </div>
                <a href="{{ route('customers.show', $sale->customer) }}" class="btn btn-sm btn-light w-100">
                    {{ app()->getLocale()==='ar' ? 'عرض الملف' : 'View Profile' }}
                </a>
            </div>
        </div>
        @endif

        <div class="card table-card" style="background: linear-gradient(135deg, #1e1b4b, #4f46e5); color:white;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span style="opacity:0.8; font-size:0.85rem;">{{ __('app.subtotal') }}</span>
                    <span class="fw-semibold">${{ number_format($sale->subtotal, 2) }}</span>
                </div>
                @if($sale->discount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span style="opacity:0.8; font-size:0.85rem;">{{ __('app.discount') }}</span>
                    <span class="fw-semibold">-${{ number_format($sale->discount, 2) }}</span>
                </div>
                @endif
                <hr style="border-color:rgba(255,255,255,0.3);">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-6">{{ __('app.total') }}</span>
                    <span class="fw-bold fs-4">${{ number_format($sale->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header px-4 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2 text-primary"></i>{{ app()->getLocale()==='ar' ? 'تفاصيل المنتجات' : 'Order Items' }}</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">#</th>
                                <th>{{ __('app.product') }}</th>
                                <th>{{ __('app.unit_price') }}</th>
                                <th>{{ __('app.qty') }}</th>
                                <th>{{ __('app.subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $i => $item)
                            <tr>
                                <td class="px-4 text-muted small">{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none fw-semibold small">{{ $item->product->name }}</a>
                                    <div class="text-muted" style="font-size:0.7rem;">{{ $item->product->category->name }}</div>
                                </td>
                                <td class="small">${{ number_format($item->unit_price, 2) }}</td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $item->quantity }}</span></td>
                                <td class="fw-semibold small">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold px-4">{{ __('app.total') }}</td>
                                <td class="fw-bold text-primary">${{ number_format($sale->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @if($sale->notes)
            <div class="card-footer bg-white px-4 py-3">
                <small class="text-muted fw-semibold">{{ __('app.notes') }}: </small>
                <small class="text-muted">{{ $sale->notes }}</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .btn, .page-content > .d-flex { display: none !important; }
    .main-content { margin: 0 !important; }
    .page-content { padding: 0 !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>
@endpush
