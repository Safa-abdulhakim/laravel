@extends('admin.layouts.app')
@section('title', 'Edit Project')
@section('page-title', 'Edit Project')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Edit Project</h5>
        <small class="text-muted">{{ $project->title }}</small>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-semibold">Project Details</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $project->title) }}"
                               class="form-control @error('title') is-invalid @enderror">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="5"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Technologies</label>
                        <input type="text" name="technologies"
                               value="{{ old('technologies', $project->technologies ? implode(', ', $project->technologies) : '') }}"
                               class="form-control" placeholder="Laravel, Vue.js, MySQL">
                        <div class="form-text">Separate with commas</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">GitHub Link</label>
                            <input type="url" name="github_link" value="{{ old('github_link', $project->github_link) }}"
                                   class="form-control @error('github_link') is-invalid @enderror">
                            @error('github_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Live Demo URL</label>
                            <input type="url" name="live_demo" value="{{ old('live_demo', $project->live_demo) }}"
                                   class="form-control @error('live_demo') is-invalid @enderror">
                            @error('live_demo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-semibold">Images</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Main Image</label>
                        @if($project->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$project->image) }}"
                                     alt="Current" class="rounded" style="max-height:120px;border:2px solid #e2e8f0;">
                                <div class="form-text">Current image — upload a new one to replace it</div>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*"
                               class="form-control @error('image') is-invalid @enderror">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label fw-medium">Gallery Images</label>
                        @if($project->gallery && count($project->gallery) > 0)
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($project->gallery as $img)
                                    <img src="{{ asset('storage/'.$img) }}"
                                         class="rounded" style="height:70px;width:90px;object-fit:cover;border:2px solid #e2e8f0;">
                                @endforeach
                            </div>
                            <div class="form-text mb-2">Upload new images to replace the gallery</div>
                        @endif
                        <input type="file" name="gallery[]" accept="image/*" multiple class="form-control">
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
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="featured" {{ old('status', $project->status) == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="inactive" {{ old('status', $project->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-medium">Sort Order</label>
                        <input type="number" name="sort_order"
                               value="{{ old('sort_order', $project->sort_order) }}"
                               class="form-control" min="0">
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Project
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
