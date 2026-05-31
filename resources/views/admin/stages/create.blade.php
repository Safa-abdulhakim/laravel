@extends('layouts.admin')
@section('title', 'Create Stage')
@section('page-title', 'Create Stage')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.stages.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Career Path <span class="text-danger">*</span></label>
                            <select name="career_path_id" class="form-select" required>
                                <option value="">Select Career Path</option>
                                @foreach($careerPaths as $cp)
                                    <option value="{{ $cp->id }}" {{ (old('career_path_id', request('career_path_id')) == $cp->id) ? 'selected' : '' }}>{{ $cp->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}" min="1">
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Create Stage</button>
                                <a href="{{ route('admin.stages.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
