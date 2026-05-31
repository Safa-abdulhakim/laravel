@extends('layouts.admin')
@section('title', 'Create Skill')
@section('page-title', 'Create Skill')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.skills.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Stage <span class="text-danger">*</span></label>
                            <select name="stage_id" class="form-select" required>
                                <option value="">Select Stage</option>
                                @foreach($stages as $stage)
                                    <option value="{{ $stage->id }}" {{ (old('stage_id', request('stage_id')) == $stage->id) ? 'selected' : '' }}>{{ $stage->careerPath->title }} › {{ $stage->title }}</option>
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
                            <label class="form-label fw-semibold">Difficulty <span class="text-danger">*</span></label>
                            <select name="difficulty" class="form-select" required>
                                @foreach(['Beginner','Intermediate','Advanced'] as $d)
                                    <option value="{{ $d }}" {{ old('difficulty') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Estimated Hours</label>
                            <input type="number" name="estimated_hours" class="form-control" value="{{ old('estimated_hours', 0) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}" min="0">
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Create Skill</button>
                                <a href="{{ route('admin.skills.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
