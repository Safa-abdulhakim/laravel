@extends('layouts.dashboard')
@section('title', __('edit_category_title'))
@section('page-title', __('edit_category_title'))
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">
                <i class="bi bi-folder-symlink me-2" style="color:#f59e0b"></i>{{ __('edit_category_title') }}
            </h5>
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">{{ __('category_name_label') }} <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        class="form-control form-control-dark @error('name') is-invalid @enderror">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <p class="text-muted mt-1" style="font-size:0.78rem">{{ __('current_slug_label') }} <code style="color:#a78bfa">{{ $category->slug }}</code></p>
                </div>
                <div class="mb-4">
                    <label class="form-label">{{ __('description_label') }}</label>
                    <textarea name="description" rows="3"
                        class="form-control form-control-dark">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-check2 me-2"></i>{{ __('update_category_btn') }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn"
                        style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px 20px;">{{ __('cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
