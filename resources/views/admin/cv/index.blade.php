@extends('admin.layouts.app')
@section('title', 'CV Manager')
@section('page-title', 'CV / Resume')

@section('content')
<div class="row g-4">
    {{-- Upload Section --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-semibold">Upload New CV</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('admin.cv.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-medium">PDF File <span class="text-danger">*</span></label>
                        <div class="border-2 border-dashed rounded p-4 text-center"
                             style="border:2px dashed #cbd5e1;background:#f8fafc;cursor:pointer;"
                             onclick="document.getElementById('cvFile').click()">
                            <i class="bi bi-file-earmark-pdf fs-1 text-danger d-block mb-2"></i>
                            <p class="mb-1 fw-medium">Click to select PDF</p>
                            <p class="text-muted small mb-0">Maximum file size: 10MB</p>
                            <div id="selectedFile" class="mt-2 text-primary small"></div>
                        </div>
                        <input type="file" name="cv_file" id="cvFile" accept=".pdf"
                               class="d-none @error('cv_file') is-invalid @enderror"
                               onchange="document.getElementById('selectedFile').textContent = this.files[0]?.name">
                        @error('cv_file')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="alert alert-info d-flex gap-2 py-2 small">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
                        <span>Uploading a new CV will automatically deactivate the current one.</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-cloud-upload me-1"></i> Upload CV
                    </button>
                </form>
            </div>
        </div>

        {{-- Active CV Preview --}}
        @if($activeCv)
        <div class="card border-0 shadow-sm mt-4" style="border-left:4px solid #10b981 !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#d1fae5;">
                        <i class="bi bi-file-earmark-check-fill fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="badge bg-success mb-1">Active CV</div>
                        <div class="fw-medium">{{ $activeCv->original_name }}</div>
                        <div class="text-muted small">{{ $activeCv->file_size }} • {{ $activeCv->download_count }} downloads</div>
                    </div>
                </div>
                <a href="{{ route('cv.download') }}" class="btn btn-outline-success btn-sm mt-3 w-100">
                    <i class="bi bi-download me-1"></i> Download Preview
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- History Table --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-semibold">CV History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">File Name</th>
                                <th>Size</th>
                                <th>Downloads</th>
                                <th>Status</th>
                                <th>Uploaded</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cvs as $cv)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                                        <span class="small">{{ Str::limit($cv->original_name, 30) }}</span>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $cv->file_size }}</td>
                                <td class="text-muted small">{{ $cv->download_count }}</td>
                                <td>
                                    @if($cv->is_active)
                                        <span class="badge bg-success rounded-pill px-3">Active</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $cv->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        @unless($cv->is_active)
                                        <form action="{{ route('admin.cv.activate', $cv) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Activate">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                        @endunless
                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('{{ route('admin.cv.destroy', $cv) }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No CVs uploaded yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($cvs->hasPages())
            <div class="card-footer bg-white border-0">{{ $cvs->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection

@push('scripts')
<script>
function confirmDelete(url){if(confirm('Delete this CV?')){const f=document.getElementById('deleteForm');f.action=url;f.submit();}}
</script>
@endpush
