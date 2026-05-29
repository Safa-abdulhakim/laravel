@extends('layouts.dashboard')
@section('title', 'Edit Tag')
@section('page-title', 'Edit Tag')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">
                <i class="bi bi-tag me-2" style="color:#ec4899"></i>Edit Tag
            </h5>
            <form method="POST" action="{{ route('admin.tags.update', $tag) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Tag Name <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $tag->name) }}"
                        class="form-control form-control-dark @error('name') is-invalid @enderror">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <p class="text-muted mt-1" style="font-size:0.78rem">Current slug: <code style="color:#a78bfa">{{ $tag->slug }}</code></p>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gradient px-4">
                        <i class="bi bi-check2 me-2"></i>Update Tag
                    </button>
                    <a href="{{ route('admin.tags.index') }}" class="btn"
                        style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px 20px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
