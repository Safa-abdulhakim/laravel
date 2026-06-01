@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <div class="flex-grow-1">
        <h4 class="fw-bold mb-0">{{ $product->name }}</h4>
        <p class="text-muted mb-0 small">الكود: {{ $product->sku }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil me-1"></i>تعديل</a>
        @if(auth()->user()->isAdmin())
        <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('هل تريد حذف هذا المنتج؟')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>حذف</button>
        </form>
        @endif
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card table-card mb-3">
            <div class="card-body text-center p-4">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded mb-3" style="max-height:200px;object-fit:cover;width:100%;" alt="{{ $product->name }}">
                @else
                <div class="d-flex align-items-center justify-content-center mb-3" style="height:180px;background:#f1f5f9;border-radius:10px;">
                    <i class="bi bi-box fs-1 text-muted opacity-40"></i>
                </div>
                @endif
                <h5 class="fw-bold">{{ $product->name }}</h5>
                <p class="text-muted small mb-2">{{ $product->description }}</p>
                <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $product->category->name }}</span>
                <span class="ms-1 badge {{ $product->status==='active' ? 'bg-success' : ($product->status==='inactive' ? 'bg-secondary' : 'bg-danger') }}">
                    {{ $product->status==='active' ? 'نشط' : ($product->status==='inactive' ? 'غير نشط' : 'نفد المخزون') }}
                </span>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-6">
                        <div class="fw-bold fs-5 text-primary">${{ number_format($product->price, 2) }}</div>
                        <div class="text-muted small">سعر الوحدة</div>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold fs-5 {{ $product->quantity<=0 ? 'text-danger' : ($product->isLowStock() ? 'text-warning' : 'text-success') }}">
                            {{ $product->quantity }}
                        </div>
                        <div class="text-muted small">المخزون الحالي</div>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold fs-5">{{ $product->low_stock_threshold }}</div>
                        <div class="text-muted small">حد التنبيه</div>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold fs-5">{{ $product->saleItems->sum('quantity') }}</div>
                        <div class="text-muted small">إجمالي المباع</div>
                    </div>
                </div>
                @if($product->isLowStock())
                <div class="alert alert-warning mt-3 mb-0 py-2 px-3 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>المخزون منخفض! يُنصح بإعادة التوريد.
                </div>
                @elseif($product->isOutOfStock())
                <div class="alert alert-danger mt-3 mb-0 py-2 px-3 small">
                    <i class="bi bi-x-circle me-1"></i>نفد المخزون بالكامل!
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-arrow-left-right me-2 text-primary"></i>سجل حركة المخزون</h6>
                @if(auth()->user()->isAdmin())
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal">
                    <i class="bi bi-plus me-1"></i>تعديل المخزون
                </button>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">النوع</th>
                                <th>الكمية</th>
                                <th>قبل</th>
                                <th>بعد</th>
                                <th>بواسطة</th>
                                <th>المرجع</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->inventoryLogs->sortByDesc('created_at') as $log)
                            <tr>
                                <td class="px-4">
                                    @if($log->type === 'stock_in')
                                        <span class="badge badge-stock-in"><i class="bi bi-arrow-up-circle me-1"></i>إضافة</span>
                                    @elseif($log->type === 'stock_out')
                                        <span class="badge badge-stock-out"><i class="bi bi-arrow-down-circle me-1"></i>خصم</span>
                                    @else
                                        <span class="badge badge-adjustment"><i class="bi bi-sliders me-1"></i>تعديل</span>
                                    @endif
                                </td>
                                <td class="fw-semibold small">{{ $log->quantity }}</td>
                                <td class="text-muted small">{{ $log->quantity_before }}</td>
                                <td class="fw-semibold small">{{ $log->quantity_after }}</td>
                                <td class="text-muted small">{{ $log->user->name }}</td>
                                <td class="text-muted small">{{ $log->reference ?: '-' }}</td>
                                <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">لا توجد حركات مخزون</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
{{-- Modal تعديل المخزون --}}
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">تعديل مخزون: {{ $product->name }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" id="stockTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#addStock">إضافة مخزون</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#removeStock">خصم مخزون</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#adjustStock">تعديل الكمية</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="addStock">
                        <form method="POST" action="{{ route('inventory.stock-in') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">الكمية المضافة</label>
                                <input type="number" name="quantity" class="form-control" min="1" placeholder="أدخل الكمية" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">المرجع (اختياري)</label>
                                <input type="text" name="reference" class="form-control" placeholder="رقم فاتورة الشراء...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">ملاحظات</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات إضافية..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100"><i class="bi bi-arrow-up-circle me-1"></i>إضافة للمخزون</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="removeStock">
                        <form method="POST" action="{{ route('inventory.stock-out') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">الكمية المخصومة</label>
                                <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->quantity }}" placeholder="أدخل الكمية" required>
                                <div class="form-text">المتاح: {{ $product->quantity }} وحدة</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">ملاحظات</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="سبب الخصم..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-arrow-down-circle me-1"></i>خصم من المخزون</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="adjustStock">
                        <form method="POST" action="{{ route('inventory.adjust') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">الكمية الجديدة</label>
                                <input type="number" name="new_quantity" class="form-control" min="0" value="{{ $product->quantity }}" required>
                                <div class="form-text">الكمية الحالية: {{ $product->quantity }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">سبب التعديل <span class="text-danger">*</span></label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="سبب تعديل المخزون..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 text-dark"><i class="bi bi-sliders me-1"></i>تعديل المخزون</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
