@extends('admin.layouts.app')
@section('title', 'Projects')
@section('page-title', 'Projects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">All Projects</h5>
        <small class="text-muted">{{ $projects->total() }} total projects</small>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Project
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width:60px">#</th>
                        <th>Project</th>
                        <th>Technologies</th>
                        <th>Status</th>
                        <th>Links</th>
                        <th>Date</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td class="ps-3 text-muted">{{ $project->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($project->image)
                                    <img src="{{ asset('storage/'.$project->image) }}"
                                         alt="{{ $project->title }}"
                                         class="rounded" style="width:48px;height:36px;object-fit:cover;">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center"
                                         style="width:48px;height:36px;background:#e0e7ff;color:#6366f1;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-medium">{{ $project->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($project->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($project->technologies)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                        <span class="badge bg-light text-dark border">{{ $tech }}</span>
                                    @endforeach
                                    @if(count($project->technologies) > 3)
                                        <span class="badge bg-light text-muted">+{{ count($project->technologies) - 3 }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-status-{{ $project->status }} rounded-pill px-3 py-1">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($project->github_link)
                                    <a href="{{ $project->github_link }}" target="_blank"
                                       class="btn btn-sm btn-light" title="GitHub">
                                        <i class="bi bi-github"></i>
                                    </a>
                                @endif
                                @if($project->live_demo)
                                    <a href="{{ $project->live_demo }}" target="_blank"
                                       class="btn btn-sm btn-light" title="Live Demo">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted small">{{ $project->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.projects.edit', $project) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('{{ route('admin.projects.destroy', $project) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-folder-x fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">No projects found.</span>
                            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm ms-3">
                                Add First Project
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($projects->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $projects->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- Delete Form --}}
<form id="deleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this project? This action cannot be undone.')) {
        const form = document.getElementById('deleteForm');
        form.action = url;
        form.submit();
    }
}
</script>
@endpush
