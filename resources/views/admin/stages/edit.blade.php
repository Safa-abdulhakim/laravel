@extends('layouts.admin')
@section('title', 'Edit Stage')
@section('page-title', 'Edit Stage')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.stages.update', $stage) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $stage->title) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $stage->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $stage->order) }}" min="1">
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Stage</button>
                                <a href="{{ route('admin.career-paths.show', $stage->career_path_id) }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
