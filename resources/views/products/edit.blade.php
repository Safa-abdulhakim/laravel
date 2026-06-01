@extends('layouts.app')
@section('title', 'تعديل المنتج')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <div>
        <h4 class="fw-bold mb-0">تعديل المنتج</h4>
        <p class="text-muted mb-0 small">{{ $product->name }}</p>
    </div>
</div>

<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card table-card mb-3">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">بيانات المنتج</h6></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم المنتج <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">التصنيف <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">الكود (SKU)</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control @error('sku') is-invalid @enderror">
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
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror" step="0.01" min="0">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">الكمية <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-control @error('quantity') is-invalid @enderror" min="0">
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">حد التنبيه <span class="text-danger">*</span></label>
                            <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" class="form-control @error('low_stock_threshold') is-invalid @enderror" min="1">
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
                    @if($product->image)
                    <img id="preview" src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded mb-2 w-100" style="max-height:150px;object-fit:cover;">
                    @else
                    <img id="preview" src="" class="img-fluid rounded mb-2 w-100 d-none" style="max-height:150px;object-fit:cover;">
                    @endif
                    <input type="file" name="image" class="form-control form-control-sm @error('image') is-invalid @enderror" accept="image/*" onchange="previewImg(this)">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card table-card">
                <div class="card-header px-4 py-3"><h6 class="fw-bold mb-0">الحالة والحفظ</h6></div>
                <div class="card-body">
                    <label class="form-label fw-semibold">حالة المنتج</label>
                    <select name="status" class="form-select mb-3">
                        <option value="active"       {{ old('status',$product->status)=='active'       ?'selected':'' }}>نشط</option>
                        <option value="inactive"     {{ old('status',$product->status)=='inactive'     ?'selected':'' }}>غير نشط</option>
                        <option value="out_of_stock" {{ old('status',$product->status)=='out_of_stock' ?'selected':'' }}>نفد المخزون</option>
                    </select>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-check-lg me-1"></i>تحديث المنتج</button>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-light">إلغاء</a>
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
            const img = document.getElementById('preview');
            img.src = e.target.result;
            img.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
