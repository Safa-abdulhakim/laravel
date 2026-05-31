@extends('layouts.admin')
@section('title', 'Edit Career Path')
@section('page-title', 'Edit: ' . $careerPath->title)
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.career-paths.update', $careerPath) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $careerPath->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $careerPath->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bootstrap Icon Class</label>
                            <input type="text" name="icon" class="form-control" value="{{ old('icon', $careerPath->icon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Difficulty Level</label>
                            <select name="difficulty_level" class="form-select" required>
                                @foreach(['Beginner','Intermediate','Advanced'] as $level)
                                    <option value="{{ $level }}" {{ old('difficulty_level', $careerPath->difficulty_level) == $level ? 'selected' : '' }}>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estimated Duration</label>
                            <input type="text" name="estimated_duration" class="form-control" value="{{ old('estimated_duration', $careerPath->estimated_duration) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status', $careerPath->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $careerPath->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Cover Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('admin.career-paths.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
