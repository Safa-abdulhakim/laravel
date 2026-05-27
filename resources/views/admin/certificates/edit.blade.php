@extends('admin.layouts.app')
@section('title', 'Edit Certificate')
@section('page-title', 'Edit Certificate')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Edit Certificate</h5>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-medium">Certificate Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $certificate->title) }}"
                               class="form-control @error('title') is-invalid @enderror">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Issuing Organization <span class="text-danger">*</span></label>
                        <input type="text" name="issuer" value="{{ old('issuer', $certificate->issuer) }}"
                               class="form-control @error('issuer') is-invalid @enderror">
                        @error('issuer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Issue Date <span class="text-danger">*</span></label>
                            <input type="date" name="issue_date"
                                   value="{{ old('issue_date', $certificate->issue_date->format('Y-m-d')) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Expiry Date</label>
                            <input type="date" name="expiry_date"
                                   value="{{ old('expiry_date', $certificate->expiry_date?->format('Y-m-d')) }}"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Credential ID</label>
                            <input type="text" name="credential_id" value="{{ old('credential_id', $certificate->credential_id) }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Credential URL</label>
                            <input type="url" name="credential_url" value="{{ old('credential_url', $certificate->credential_url) }}"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Certificate Image</label>
                        @if($certificate->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$certificate->image) }}" class="rounded"
                                     style="max-height:100px;border:2px solid #e2e8f0;">
                                <div class="form-text">Upload new image to replace</div>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Update Certificate
                        </button>
                        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
