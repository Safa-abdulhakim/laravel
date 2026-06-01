@extends('layouts.app')
@section('title', 'إضافة منتج')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <div>
        <h4 class="fw-bold mb-0">إضافة منتج جديد</h4>
        <p class="text-muted mb-0 small">أدخل بيانات المنتج</p>
    </div>
</div>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card table-card mb-3">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">بيانات المنتج</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم المنتج <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="مثال: لاب توب Dell Inspiron">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="وصف المنتج...">{{ old('description') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">التصنيف <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- اختر التصنيف --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">الكود (SKU)</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control @error('sku') is-invalid @enderror" placeholder="يتولّد تلقائياً إذا تُرك فارغاً">
                            @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">السعر والمخزون</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">السعر ($) <span class="text-danger">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" step="0.01" min="0" placeholder="0.00">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">الكمية الأولية <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" value="{{ old('quantity', 0) }}" class="form-control @error('quantity') is-invalid @enderror" min="0">
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">حد التنبيه <span class="text-danger">*</span></label>
                            <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 10) }}" class="form-control @error('low_stock_threshold') is-invalid @enderror" min="1">
                            <div class="form-text">تنبيه عند انخفاض المخزون عن هذا الحد</div>
                            @error('low_stock_threshold')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card table-card mb-3">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">صورة المنتج</h6></div>
                <div class="card-body">
                    <div class="border rounded p-3 text-center" style="border-style:dashed!important;background:#fafafa;">
                        <img id="preview" src="" class="mb-2 d-none img-fluid rounded" style="max-height:150px;">
                        <i class="bi bi-image fs-2 text-muted d-block mb-2" id="previewIcon"></i>
                        <input type="file" name="image" class="form-control form-control-sm @error('image') is-invalid @enderror" accept="image/*" onchange="previewImg(this)">
                        <small class="text-muted d-block mt-1">JPG, PNG, WEBP - الحجم الأقصى 2MB</small>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">الحالة والحفظ</h6></div>
                <div class="card-body">
                    <label class="form-label fw-semibold">حالة المنتج</label>
                    <select name="status" class="form-select mb-3">
                        <option value="active"       {{ old('status','active')=='active'       ? 'selected':'' }}>نشط</option>
                        <option value="inactive"     {{ old('status')=='inactive'              ? 'selected':'' }}>غير نشط</option>
                        <option value="out_of_stock" {{ old('status')=='out_of_stock'          ? 'selected':'' }}>نفد المخزون</option>
                    </select>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-check-lg me-1"></i>حفظ المنتج</button>
                        <a href="{{ route('products.index') }}" class="btn btn-light">إلغاء</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImg(input) {
    if (input.files?.[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').classList.remove('d-none');
            document.getElementById('previewIcon').classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
