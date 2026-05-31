@extends('layouts.admin')
@section('title', 'Career Paths')
@section('page-title', 'Career Paths Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.career-paths.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>New Career Path</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-4">Path</th><th>Level</th><th>Status</th><th>Stages</th><th>Enrolled</th><th class="pe-4">Actions</th></tr></thead>
                <tbody>
                    @forelse($careerPaths as $path)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 rounded-2 p-2"><i class="{{ $path->icon ?? 'bi-code-slash' }} text-primary"></i></div>
                                    <div>
                                        <div class="fw-semibold small">{{ $path->title }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ Str::limit($path->description, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-{{ $path->difficulty_color }}-subtle text-{{ $path->difficulty_color }}">{{ $path->difficulty_level }}</span></td>
                            <td><span class="badge {{ $path->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">{{ $path->status }}</span></td>
                            <td>{{ $path->stages_count }}</td>
                            <td>{{ number_format($path->enrolled_count) }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.career-paths.show', $path) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.career-paths.edit', $path) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.career-paths.destroy', $path) }}" onsubmit="return confirm('Delete this career path?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No career paths yet. <a href="{{ route('admin.career-paths.create') }}">Create one</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $careerPaths->links() }}</div>
</div>
@endsection
