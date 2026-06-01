@extends('layouts.app')
@section('title', $customer->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <div class="flex-grow-1">
        <h4 class="fw-bold mb-0">{{ $customer->name }}</h4>
        <p class="text-muted mb-0 small">ملف العميل / Customer Profile</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil me-1"></i>تعديل</a>
        <a href="{{ route('sales.create') }}?customer={{ $customer->id }}" class="btn btn-sm btn-primary"><i class="bi bi-plus me-1"></i>بيع جديد</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card table-card mb-3">
            <div class="card-body p-4 text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:80px;height:80px;background:#ede9fe;border-radius:50%;font-size:2.2rem;font-weight:800;color:#7c3aed;">
                    {{ strtoupper(mb_substr($customer->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                @if($customer->email)
                <p class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i>{{ $customer->email }}</p>
                @endif
                @if($customer->phone)
                <p class="text-muted small mb-1"><i class="bi bi-telephone me-1"></i>{{ $customer->phone }}</p>
                @endif
                @if($customer->address)
                <p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $customer->address }}</p>
                @endif
            </div>
        </div>
        <div class="card table-card">
            <div class="card-body">
                <div class="row text-center g-2">
                    <div class="col-6">
                        <div class="fw-bold fs-5 text-primary">{{ $customer->sales->count() }}</div>
                        <div class="text-muted small">إجمالي الطلبات</div>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold fs-5 text-success">${{ number_format($totalSpent, 2) }}</div>
                        <div class="text-muted small">إجمالي الإنفاق</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header px-4 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>سجل الطلبات / Order History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">الفاتورة</th>
                                <th>المنتجات</th>
                                <th>الإجمالي</th>
                                <th>الدفع</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->sales->sortByDesc('created_at') as $sale)
                            <tr>
                                <td class="px-4 fw-semibold small text-primary">{{ $sale->invoice_number }}</td>
                                <td class="small">{{ $sale->items->count() }} منتج</td>
                                <td class="fw-semibold small">${{ number_format($sale->total, 2) }}</td>
                                <td class="small text-muted">
                                    {{ ['cash'=>'نقدي','card'=>'بطاقة','bank_transfer'=>'تحويل','other'=>'أخرى'][$sale->payment_method] ?? $sale->payment_method }}
                                </td>
                                <td>
                                    @if($sale->status==='completed')
                                        <span class="badge bg-success">مكتمل</span>
                                    @elseif($sale->status==='pending')
                                        <span class="badge bg-warning text-dark">معلق</span>
                                    @else
                                        <span class="badge bg-danger">ملغي</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $sale->created_at->format('d/m/Y') }}</td>
                                <td><a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-light py-0 px-2"><i class="bi bi-eye"></i></a></td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">لا توجد طلبات بعد</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
