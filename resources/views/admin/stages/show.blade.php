@extends('layouts.admin')
@section('title', $stage->title)
@section('page-title', $stage->title)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.career-paths.show', $stage->careerPath) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back to {{ $stage->careerPath->title }}</a>
    <a href="{{ route('admin.skills.create') }}?stage_id={{ $stage->id }}" class="btn btn-success btn-sm"><i class="bi bi-plus me-1"></i>Add Skill</a>
</div>
<div class="card">
    <div class="card-body p-4">
        <h5 class="fw-semibold mb-4">Skills in this Stage</h5>
        <div class="row g-3">
            @forelse($stage->skills as $skill)
                <div class="col-md-6">
                    <div class="p-3 border rounded-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-semibold mb-0">{{ $skill->title }}</h6>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary p-1"><i class="bi bi-pencil" style="font-size:.75rem;"></i></a>
                                <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger p-1"><i class="bi bi-trash" style="font-size:.75rem;"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-{{ $skill->difficulty_color }}-subtle text-{{ $skill->difficulty_color }}" style="font-size:.72rem;">{{ $skill->difficulty }}</span>
                            <span class="badge bg-light text-muted" style="font-size:.72rem;"><i class="bi bi-clock me-1"></i>{{ $skill->estimated_hours }}h</span>
                        </div>
                        @if($skill->learningResources->count())
                            <small class="text-muted"><i class="bi bi-book me-1"></i>{{ $skill->learningResources->count() }} resources</small>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4"><p class="text-muted">No skills yet. <a href="{{ route('admin.skills.create') }}?stage_id={{ $stage->id }}">Add first skill</a></p></div>
            @endforelse
        </div>
    </div>
</div>
@endsection
