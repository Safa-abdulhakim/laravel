@extends('layouts.app')
@section('title', __('app.inventory_logs'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">{{ __('app.inventory_logs') }}</h4>
        <p class="text-muted mb-0 small">{{ app()->getLocale()==='ar' ? 'تتبع جميع حركات المخزون' : 'Track all stock movements' }}</p>
    </div>
    @if(auth()->user()->isAdmin())
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockActionModal">
        <i class="bi bi-plus me-1"></i>{{ app()->getLocale()==='ar' ? 'تحريك المخزون' : 'Stock Action' }}
    </button>
    @endif
</div>

{{-- Filter --}}
<div class="card table-card mb-3">
    <div class="card-header px-4 py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="product" class="form-select form-select-sm">
                    <option value="">{{ app()->getLocale()==='ar' ? 'كل المنتجات' : 'All Products' }}</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ request('product')==$p->id ? 'selected':'' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">{{ __('app.all_status') }}</option>
                    <option value="stock_in"   {{ request('type')==='stock_in'   ? 'selected':'' }}>{{ __('app.stock_in') }}</option>
                    <option value="stock_out"  {{ request('type')==='stock_out'  ? 'selected':'' }}>{{ __('app.stock_out') }}</option>
                    <option value="adjustment" {{ request('type')==='adjustment' ? 'selected':'' }}>{{ __('app.adjustment') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>{{ __('app.filter') }}</button>
                <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-light">{{ __('app.reset') }}</a>
            </div>
        </form>
    </div>
</div>

<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4">{{ app()->getLocale()==='ar' ? 'النوع' : 'Type' }}</th>
                        <th>{{ __('app.product') }}</th>
                        <th>{{ __('app.quantity') }}</th>
                        <th>{{ __('app.before') }}</th>
                        <th>{{ __('app.after') }}</th>
                        <th>{{ __('app.by') }}</th>
                        <th>{{ __('app.reference') }}</th>
                        <th>{{ app()->getLocale()==='ar' ? 'الملاحظات' : 'Notes' }}</th>
                        <th>{{ __('app.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="px-4">
                            @if($log->type === 'stock_in')
                                <span class="badge badge-stock-in"><i class="bi bi-arrow-up-circle me-1"></i>{{ __('app.stock_in') }}</span>
                            @elseif($log->type === 'stock_out')
                                <span class="badge badge-stock-out"><i class="bi bi-arrow-down-circle me-1"></i>{{ __('app.stock_out') }}</span>
                            @else
                                <span class="badge badge-adjustment"><i class="bi bi-sliders me-1"></i>{{ __('app.adjustment') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $log->product) }}" class="text-decoration-none fw-semibold small">{{ $log->product->name }}</a>
                        </td>
                        <td>
                            <span class="fw-bold {{ $log->type==='stock_in' ? 'text-success' : ($log->type==='stock_out' ? 'text-danger' : 'text-warning') }}">
                                {{ $log->type==='stock_in' ? '+' : ($log->type==='stock_out' ? '-' : '~') }}{{ $log->quantity }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $log->quantity_before }}</td>
                        <td class="fw-semibold small">{{ $log->quantity_after }}</td>
                        <td class="text-muted small">{{ $log->user->name }}</td>
                        <td class="text-muted small">{{ $log->reference ?: '-' }}</td>
                        <td class="text-muted small" style="max-width:150px;">{{ Str::limit($log->notes, 40) ?: '-' }}</td>
                        <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-clipboard-data fs-1 d-block mb-2 opacity-30"></i>
                            {{ __('app.no_logs') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white px-4 py-2">{{ $logs->links() }}</div>
    @endif
</div>

{{-- Stock Action Modal (Admin Only) --}}
@if(auth()->user()->isAdmin())
<div class="modal fade" id="stockActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">
                    {{ app()->getLocale()==='ar' ? 'تحريك المخزون' : 'Stock Action' }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabIn">{{ __('app.stock_in') }}</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabOut">{{ __('app.stock_out') }}</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabAdj">{{ __('app.adjustment') }}</a></li>
                </ul>
                <div class="tab-content">
                    {{-- Stock In --}}
                    <div class="tab-pane fade show active" id="tabIn">
                        <form method="POST" action="{{ route('inventory.stock-in') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.product') }}</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">{{ __('app.select_product') }}</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ app()->getLocale()==='ar' ? 'المخزون:' : 'Stock:' }} {{ $p->quantity }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.quantity_added') }}</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.reference') }}</label>
                                <input type="text" name="reference" class="form-control" placeholder="{{ __('app.reference_hint') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ app()->getLocale()==='ar' ? 'ملاحظات' : 'Notes' }}</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-arrow-up-circle me-1"></i>{{ __('app.add_stock') }}
                            </button>
                        </form>
                    </div>
                    {{-- Stock Out --}}
                    <div class="tab-pane fade" id="tabOut">
                        <form method="POST" action="{{ route('inventory.stock-out') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.product') }}</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">{{ __('app.select_product') }}</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ app()->getLocale()==='ar' ? 'المخزون:' : 'Stock:' }} {{ $p->quantity }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.quantity_removed') }}</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ app()->getLocale()==='ar' ? 'ملاحظات' : 'Notes' }}</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-arrow-down-circle me-1"></i>{{ __('app.remove_stock') }}
                            </button>
                        </form>
                    </div>
                    {{-- Adjust --}}
                    <div class="tab-pane fade" id="tabAdj">
                        <form method="POST" action="{{ route('inventory.adjust') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.product') }}</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">{{ __('app.select_product') }}</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ app()->getLocale()==='ar' ? 'الحالي:' : 'Current:' }} {{ $p->quantity }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.new_quantity') }}</label>
                                <input type="number" name="new_quantity" class="form-control" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('app.adjustment_reason') }} <span class="text-danger">*</span></label>
                                <textarea name="notes" class="form-control" rows="2" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 text-dark">
                                <i class="bi bi-sliders me-1"></i>{{ __('app.adjust_stock') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
