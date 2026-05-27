@extends('admin.layouts.app')
@section('title', 'Certificates')
@section('page-title', 'Certificates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h5 class="fw-bold mb-0">Certificates</h5><small class="text-muted">{{ $certificates->total() }} total</small></div>
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Certificate
    </a>
</div>

<div class="row g-4">
    @forelse($certificates as $cert)
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            @if($cert->image)
                <img src="{{ asset('storage/'.$cert->image) }}" class="card-img-top"
                     style="height:160px;object-fit:cover;">
            @else
                <div class="card-img-top d-flex align-items-center justify-content-center"
                     style="height:120px;background:linear-gradient(135deg,#eef2ff,#e0e7ff);">
                    <i class="bi bi-award-fill" style="font-size:3rem;color:#6366f1;"></i>
                </div>
            @endif
            <div class="card-body">
                <h6 class="fw-bold mb-1">{{ $cert->title }}</h6>
                <div class="text-muted small mb-1">
                    <i class="bi bi-building me-1"></i>{{ $cert->issuer }}
                </div>
                <div class="text-muted small mb-2">
                    <i class="bi bi-calendar3 me-1"></i>{{ $cert->issue_date->format('M Y') }}
                    @if($cert->expiry_date)
                        — {{ $cert->expiry_date->format('M Y') }}
                    @endif
                </div>
                @if($cert->credential_id)
                    <div class="text-muted small">
                        <i class="bi bi-key me-1"></i>{{ $cert->credential_id }}
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white border-0 d-flex justify-content-end gap-2 pb-3 pe-3">
                @if($cert->credential_url)
                    <a href="{{ $cert->credential_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-link-45deg"></i> Verify
                    </a>
                @endif
                <a href="{{ route('admin.certificates.edit', $cert) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="btn btn-sm btn-outline-danger"
                        onclick="confirmDelete('{{ route('admin.certificates.destroy', $cert) }}')">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="bi bi-award fs-1 text-muted d-block mb-2"></i>
        <p class="text-muted">No certificates yet.</p>
        <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">Add Certificate</a>
    </div>
    @endforelse
</div>
@if($certificates->hasPages())
<div class="mt-4">{{ $certificates->links('pagination::bootstrap-5') }}</div>
@endif

<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection
@push('scripts')
<script>
function confirmDelete(url){if(confirm('Delete this certificate?')){const f=document.getElementById('deleteForm');f.action=url;f.submit();}}
</script>
@endpush
