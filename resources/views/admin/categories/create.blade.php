@extends('layouts.dashboard')
@section('title', 'Create Category')
@section('page-title', 'Create Category')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">
                <i class="bi bi-folder-plus me-2" style="color:#f59e0b"></i>New Category
            </h5>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Category Name <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control form-control-dark @error('name') is-invalid @enderror"
                        placeholder="e.g. Writing, Coding, Marketing...">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <p class="text-muted mt-1" style="font-size:0.78rem">Slug will be auto-generated from the name.</p>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                        class="form-control form-control-dark"
                        placeholder="Optional: describe what kinds of prompts belong here...">{{ old('description') }}</textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-check2 me-2"></i>Create Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn"
                        style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px 20px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
