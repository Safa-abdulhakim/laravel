@extends('layouts.app')
@section('title', 'العملاء - Customers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">العملاء <span class="text-muted fs-6 fw-normal">Customers</span></h4>
        <p class="text-muted mb-0 small">إدارة قاعدة بيانات العملاء</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-1"></i>إضافة عميل
    </a>
</div>

<div class="card table-card">
    <div class="card-header px-4 py-3">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="بحث بالاسم أو الإيميل أو الهاتف..." style="max-width:350px;">
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>بحث</button>
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-light">إعادة تعيين</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4">العميل / Customer</th>
                        <th>الهاتف / Phone</th>
                        <th>البريد / Email</th>
                        <th>العنوان / Address</th>
                        <th>الطلبات / Orders</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:38px;height:38px;background:#ede9fe;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.9rem;font-weight:700;color:#7c3aed;flex-shrink:0;">
                                    {{ strtoupper(mb_substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $customer->name }}</div>
                                    <div class="text-muted" style="font-size:0.7rem;">منذ {{ $customer->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small">{{ $customer->phone ?? '-' }}</td>
                        <td class="small text-muted">{{ $customer->email ?? '-' }}</td>
                        <td class="small text-muted">{{ Str::limit($customer->address, 35) ?: '-' }}</td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $customer->sales_count }} طلب</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-light" title="عرض"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-light" title="تعديل"><i class="bi bi-pencil"></i></a>
                                @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('هل تريد حذف هذا العميل؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 opacity-30"></i>
                            لا يوجد عملاء. <a href="{{ route('customers.create') }}">أضف أول عميل</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($customers->hasPages())
    <div class="card-footer bg-white px-4 py-2">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
