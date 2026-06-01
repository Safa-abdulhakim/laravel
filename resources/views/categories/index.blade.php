@extends('layouts.app')
@section('title', 'التصنيفات - Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1">التصنيفات <span class="text-muted fs-6 fw-normal">Categories</span></h4>
        <p class="text-muted mb-0 small">تنظيم المنتجات في فئات</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-1"></i>إضافة تصنيف
    </a>
</div>

<div class="card table-card">
    <div class="card-header px-4 py-3">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="بحث عن تصنيف..." style="max-width:300px;">
            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>بحث</button>
            <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light">إعادة تعيين</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="px-4">#</th>
                        <th>الاسم / Name</th>
                        <th>الوصف / Description</th>
                        <th>عدد المنتجات</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-4 text-muted small">{{ $category->id }}</td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted small">{{ Str::limit($category->description, 60) ?: '-' }}</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $category->products_count }} منتج</span></td>
                        <td class="text-muted small">{{ $category->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-light" title="تعديل"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('هل تريد حذف هذا التصنيف؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger" title="حذف"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-tag fs-1 d-block mb-2 opacity-30"></i>
                            لا توجد تصنيفات. <a href="{{ route('categories.create') }}">أضف أول تصنيف</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white px-4 py-2">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
