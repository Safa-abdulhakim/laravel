@extends('layouts.app')
@section('title', 'المنتجات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">المنتجات</h4>
        <p class="text-muted mb-0 small">إدارة مخزون المنتجات</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-1"></i>إضافة منتج
    </a>
</div>

<div class="card table-card">
    <div class="card-header px-4 py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="بحث بالاسم أو الكود...">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">كل التصنيفات</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">كل الحالات</option>
                    <option value="active"       {{ request('status')=='active'       ? 'selected':'' }}>نشط</option>
                    <option value="inactive"     {{ request('status')=='inactive'     ? 'selected':'' }}>غير نشط</option>
                    <option value="out_of_stock" {{ request('status')=='out_of_stock' ? 'selected':'' }}>نفد المخزون</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>بحث</button>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-light">إعادة تعيين</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4">المنتج</th>
                        <th>الكود (SKU)</th>
                        <th>التصنيف</th>
                        <th>السعر</th>
                        <th>المخزون</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" style="width:42px;height:42px;object-fit:cover;border-radius:8px;" alt="">
                                @else
                                <div style="width:42px;height:42px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-box text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $product->name }}</div>
                                    <div class="text-muted" style="font-size:0.7rem;">{{ $product->category->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $product->sku }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $product->category->name }}</span></td>
                        <td class="fw-semibold">${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->quantity <= 0)
                                <span class="badge bg-danger">نفد</span>
                            @elseif($product->isLowStock())
                                <span class="badge bg-warning text-dark">{{ $product->quantity }} (منخفض)</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success">{{ $product->quantity }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status === 'active')
                                <span class="badge bg-success">نشط</span>
                            @elseif($product->status === 'inactive')
                                <span class="badge bg-secondary">غير نشط</span>
                            @else
                                <span class="badge bg-danger">نفد المخزون</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-light" title="عرض"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-light" title="تعديل"><i class="bi bi-pencil"></i></a>
                                @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger" title="حذف"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-30"></i>
                            لا توجد منتجات. <a href="{{ route('products.create') }}">أضف أول منتج</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white px-4 py-2">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
