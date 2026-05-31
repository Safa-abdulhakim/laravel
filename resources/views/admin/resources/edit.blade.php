@extends('layouts.admin')
@section('title', 'Edit Resource')
@section('page-title', 'Edit Resource')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.resources.update', $learningResource) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $learningResource->title) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" class="form-select" required>
                                @foreach(['Article','Video','Course','Documentation'] as $type)
                                    <option value="{{ $type }}" {{ old('type', $learningResource->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Provider</label>
                            <input type="text" name="provider" class="form-control" value="{{ old('provider', $learningResource->provider) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">URL</label>
                            <input type="url" name="url" class="form-control" value="{{ old('url', $learningResource->url) }}" required>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.skills.show', $learningResource->skill_id) }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
