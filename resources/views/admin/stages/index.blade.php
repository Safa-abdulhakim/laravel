@extends('layouts.admin')
@section('title', 'Stages')
@section('page-title', 'Stages Management')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.stages.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>New Stage</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-4">Stage</th><th>Career Path</th><th>Order</th><th>Skills</th><th class="pe-4">Actions</th></tr></thead>
                <tbody>
                    @forelse($stages as $stage)
                        <tr>
                            <td class="ps-4 py-3"><div class="fw-semibold small">{{ $stage->title }}</div></td>
                            <td><a href="{{ route('admin.career-paths.show', $stage->careerPath) }}" class="text-decoration-none small">{{ $stage->careerPath->title }}</a></td>
                            <td><span class="badge bg-primary-subtle text-primary">{{ $stage->order }}</span></td>
                            <td>{{ $stage->skills_count }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.stages.edit', $stage) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.stages.destroy', $stage) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No stages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $stages->links() }}</div>
</div>
@endsection
