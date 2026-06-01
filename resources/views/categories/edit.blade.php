@extends('layouts.app')
@section('title', 'تعديل التصنيف')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-right"></i></a>
    <h4 class="fw-bold mb-0">تعديل التصنيف <small class="text-muted fs-6 fw-normal">Edit Category</small></h4>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card table-card">
            <div class="card-body p-4">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">اسم التصنيف <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">الوصف <small class="text-muted">Description</small></label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-check-lg me-1"></i>تحديث التصنيف</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-light">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
