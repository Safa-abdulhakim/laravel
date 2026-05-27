@extends('admin.layouts.app')
@section('title', 'Skills')
@section('page-title', 'Skills')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Skills</h5>
        <small class="text-muted">{{ $skills->total() }} total skills</small>
    </div>
    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Skill
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Skill Name</th>
                        <th>Category</th>
                        <th style="width:240px">Proficiency</th>
                        <th>Level %</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $skill)
                    <tr>
                        <td class="ps-3 fw-medium">{{ $skill->name }}</td>
                        <td>
                            @php
                                $catColors = ['frontend'=>'#eef2ff,#6366f1','backend'=>'#d1fae5,#065f46','tools'=>'#fef3c7,#92400e','other'=>'#f1f5f9,#475569'];
                                [$bg,$fg] = explode(',', $catColors[$skill->category] ?? '#f1f5f9,#475569');
                            @endphp
                            <span class="badge rounded-pill px-3 py-1"
                                  style="background:{{ $bg }};color:{{ $fg }};">
                                {{ ucfirst($skill->category) }}
                            </span>
                        </td>
                        <td>
                            <div class="progress" style="height:8px;border-radius:99px;background:#e2e8f0;">
                                <div class="progress-bar" role="progressbar"
                                     style="width:{{ $skill->percentage }}%;background:linear-gradient(90deg,#6366f1,#818cf8);border-radius:99px;">
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $skill->percentage }}%</td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('{{ route('admin.skills.destroy', $skill) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-lightning-charge fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">No skills found.</span>
                            <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm ms-3">Add Skill</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($skills->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $skills->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection
@push('scripts')
<script>
function confirmDelete(url) {
    if (confirm('Delete this skill?')) {
        const f = document.getElementById('deleteForm');
        f.action = url; f.submit();
    }
}
</script>
@endpush
