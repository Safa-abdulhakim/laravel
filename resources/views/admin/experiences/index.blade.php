@extends('admin.layouts.app')
@section('title', 'Experience')
@section('page-title', 'Work Experience')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h5 class="fw-bold mb-0">Work Experience</h5><small class="text-muted">{{ $experiences->total() }} entries</small></div>
    <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Experience
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Position & Company</th>
                        <th>Period</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($experiences as $exp)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-medium">{{ $exp->position }}</div>
                            <div class="text-muted small">{{ $exp->company }}</div>
                        </td>
                        <td class="small">
                            {{ $exp->start_date->format('M Y') }} —
                            {{ $exp->is_current ? '<span class="text-success fw-medium">Present</span>' : $exp->end_date->format('M Y') }}
                        </td>
                        <td class="text-muted small">{{ $exp->location ?? '—' }}</td>
                        <td>
                            @if($exp->is_current)
                                <span class="badge rounded-pill px-3" style="background:#d1fae5;color:#065f46;">Current</span>
                            @else
                                <span class="badge rounded-pill px-3" style="background:#f1f5f9;color:#64748b;">Past</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.experiences.edit', $exp) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('{{ route('admin.experiences.destroy', $exp) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-briefcase fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">No experience entries yet.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($experiences->hasPages())
    <div class="card-footer bg-white border-0">{{ $experiences->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection
@push('scripts')
<script>
function confirmDelete(url){if(confirm('Delete this experience?')){const f=document.getElementById('deleteForm');f.action=url;f.submit();}}
</script>
@endpush
