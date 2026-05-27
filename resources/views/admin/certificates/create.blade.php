@extends('admin.layouts.app')
@section('title', 'Add Certificate')
@section('page-title', 'Add Certificate')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Add Certificate</h5>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Certificate Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g., AWS Certified Developer">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Issuing Organization <span class="text-danger">*</span></label>
                        <input type="text" name="issuer" value="{{ old('issuer') }}"
                               class="form-control @error('issuer') is-invalid @enderror"
                               placeholder="e.g., Amazon Web Services">
                        @error('issuer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date" value="{{ old('issue_date') }}"
                                   class="form-control @error('issue_date') is-invalid @enderror">
                            @error('issue_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Expiry Date</label>
                            <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                                   class="form-control @error('expiry_date') is-invalid @enderror">
                            @error('expiry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Credential ID</label>
                            <input type="text" name="credential_id" value="{{ old('credential_id') }}"
                                   class="form-control" placeholder="Optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Credential URL</label>
                            <input type="url" name="credential_url" value="{{ old('credential_url') }}"
                                   class="form-control @error('credential_url') is-invalid @enderror"
                                   placeholder="https://...">
                            @error('credential_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Certificate Image</label>
                        <input type="file" name="image" accept="image/*"
                               class="form-control @error('image') is-invalid @enderror">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Save Certificate
                        </button>
                        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
