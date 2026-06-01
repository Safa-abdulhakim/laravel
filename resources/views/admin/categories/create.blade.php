@extends('layouts.dashboard')
@section('title', __('new_category_title'))
@section('page-title', __('new_category_title'))
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">
                <i class="bi bi-folder-plus me-2" style="color:#f59e0b"></i>{{ __('new_category_title') }}
            </h5>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">{{ __('category_name_label') }} <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control form-control-dark @error('name') is-invalid @enderror"
                        placeholder="{{ __('category_name_placeholder') }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <p class="text-muted mt-1" style="font-size:0.78rem">{{ __('slug_auto_note') }}</p>
                </div>
                <div class="mb-4">
                    <label class="form-label">{{ __('description_label') }}</label>
                    <textarea name="description" rows="3"
                        class="form-control form-control-dark"
                        placeholder="{{ __('description_placeholder') }}">{{ old('description') }}</textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-check2 me-2"></i>{{ __('create_category_btn') }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn"
                        style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px 20px;">{{ __('cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
