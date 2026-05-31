@extends('layouts.admin')
@section('title', 'Skills')
@section('page-title', 'Skills Management')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary"><i class="bi bi-plus me-2"></i>New Skill</a>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th class="ps-4">Skill</th><th>Stage / Path</th><th>Difficulty</th><th>Hours</th><th>Resources</th><th class="pe-4">Actions</th></tr></thead>
                <tbody>
                    @forelse($skills as $skill)
                        <tr>
                            <td class="ps-4 py-3"><div class="fw-semibold small">{{ $skill->title }}</div></td>
                            <td><small class="text-muted">{{ $skill->stage->careerPath->title }} › {{ $skill->stage->title }}</small></td>
                            <td><span class="badge bg-{{ $skill->difficulty_color }}-subtle text-{{ $skill->difficulty_color }}">{{ $skill->difficulty }}</span></td>
                            <td>{{ $skill->estimated_hours }}h</td>
                            <td>{{ $skill->learning_resources_count }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No skills yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $skills->links() }}</div>
</div>
@endsection
