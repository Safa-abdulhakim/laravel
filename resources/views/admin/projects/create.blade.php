@extends('admin.layouts.app')
@section('title', 'Add Project')
@section('page-title', 'Add New Project')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Add New Project</h5>
        <small class="text-muted">Fill in project details below</small>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-semibold">Project Details</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g., E-Commerce Platform">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="5"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Describe your project...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Technologies</label>
                        <input type="text" name="technologies" value="{{ old('technologies') }}"
                               class="form-control @error('technologies') is-invalid @enderror"
                               placeholder="Laravel, Vue.js, MySQL (comma separated)">
                        <div class="form-text">Separate technologies with commas</div>
                        @error('technologies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">GitHub Link</label>
                            <input type="url" name="github_link" value="{{ old('github_link') }}"
                                   class="form-control @error('github_link') is-invalid @enderror"
                                   placeholder="https://github.com/...">
                            @error('github_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Live Demo URL</label>
                            <input type="url" name="live_demo" value="{{ old('live_demo') }}"
                                   class="form-control @error('live_demo') is-invalid @enderror"
                                   placeholder="https://demo.example.com">
                            @error('live_demo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-semibold">Images</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Main Image</label>
                        <input type="file" name="image" accept="image/*"
                               class="form-control @error('image') is-invalid @enderror"
                               id="mainImageInput" onchange="previewImage(this, 'mainPreview')">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="mainPreview" class="mt-2"></div>
                    </div>
                    <div>
                        <label class="form-label fw-medium">Gallery Images</label>
                        <input type="file" name="gallery[]" accept="image/*" multiple
                               class="form-control @error('gallery.*') is-invalid @enderror">
                        <div class="form-text">Hold Ctrl/Cmd to select multiple images</div>
                        @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-semibold">Settings</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-medium">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                               class="form-control" min="0">
                        <div class="form-text">Lower number = shown first</div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Save Project
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(input.files[0]);
        img.style = 'max-height:150px;border-radius:8px;border:2px solid #e2e8f0;';
        preview.appendChild(img);
    }
}
</script>
@endpush
