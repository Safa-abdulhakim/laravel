@extends('admin.layouts.app')
@section('title', 'Add Experience')
@section('page-title', 'Add Work Experience')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Add Work Experience</h5>
            <a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.experiences.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Company <span class="text-danger">*</span></label>
                            <input type="text" name="company" value="{{ old('company') }}"
                                   class="form-control @error('company') is-invalid @enderror"
                                   placeholder="Company Name">
                            @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Position <span class="text-danger">*</span></label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                   class="form-control @error('position') is-invalid @enderror"
                                   placeholder="Job Title">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}"
                                   class="form-control @error('start_date') is-invalid @enderror">
                            @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   id="endDateInput">
                            @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_current" value="1"
                                   id="isCurrentCheck" {{ old('is_current') ? 'checked' : '' }}
                                   onchange="document.getElementById('endDateInput').disabled=this.checked">
                            <label class="form-check-label fw-medium" for="isCurrentCheck">
                                I currently work here
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                               class="form-control" placeholder="City, Country or Remote">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" rows="4" class="form-control"
                                  placeholder="Describe your responsibilities and achievements...">{{ old('description') }}</textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Save Experience
                        </button>
                        <a href="{{ route('admin.experiences.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
