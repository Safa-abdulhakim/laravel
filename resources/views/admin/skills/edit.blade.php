@extends('admin.layouts.app')
@section('title', 'Edit Skill')
@section('page-title', 'Edit Skill')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Edit Skill</h5>
            <a href="{{ route('admin.skills.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.skills.update', $skill) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-medium">Skill Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $skill->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-select">
                            <option value="frontend" {{ old('category',$skill->category)=='frontend'?'selected':'' }}>Frontend</option>
                            <option value="backend" {{ old('category',$skill->category)=='backend'?'selected':'' }}>Backend</option>
                            <option value="tools" {{ old('category',$skill->category)=='tools'?'selected':'' }}>Tools & DevOps</option>
                            <option value="other" {{ old('category',$skill->category)=='other'?'selected':'' }}>Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium d-flex justify-content-between">
                            Proficiency
                            <span id="percentageLabel" class="text-primary fw-bold">{{ old('percentage',$skill->percentage) }}%</span>
                        </label>
                        <input type="range" name="percentage" id="percentageRange"
                               value="{{ old('percentage',$skill->percentage) }}" min="0" max="100"
                               class="form-range"
                               oninput="document.getElementById('percentageLabel').textContent=this.value+'%'">
                        <div class="d-flex justify-content-between text-muted small">
                            <span>Beginner</span><span>Intermediate</span><span>Expert</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order',$skill->sort_order) }}"
                               class="form-control" min="0">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Skill
                        </button>
                        <a href="{{ route('admin.skills.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
