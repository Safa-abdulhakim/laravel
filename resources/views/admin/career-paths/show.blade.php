@extends('layouts.admin')
@section('title', $careerPath->title)
@section('page-title', $careerPath->title)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('admin.career-paths.index') }}" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-arrow-left me-1"></i>Back</a>
        <span class="badge bg-{{ $careerPath->difficulty_color }}-subtle text-{{ $careerPath->difficulty_color }}">{{ $careerPath->difficulty_level }}</span>
        <span class="badge {{ $careerPath->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} ms-1">{{ $careerPath->status }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.stages.create') }}?career_path_id={{ $careerPath->id }}" class="btn btn-success btn-sm"><i class="bi bi-plus me-1"></i>Add Stage</a>
        <a href="{{ route('admin.career-paths.edit', $careerPath) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <div class="text-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-3 mb-2"><i class="{{ $careerPath->icon ?? 'bi-code-slash' }} fs-2 text-primary"></i></div>
                <h5 class="fw-bold">{{ $careerPath->title }}</h5>
            </div>
            <p class="text-muted small">{{ $careerPath->description }}</p>
            <hr>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Duration</span><span class="fw-semibold">{{ $careerPath->estimated_duration ?? 'N/A' }}</span></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Stages</span><span class="fw-semibold">{{ $careerPath->stages->count() }}</span></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Total Skills</span><span class="fw-semibold">{{ $careerPath->stages->sum(fn($s) => $s->skills->count()) }}</span></div>
            <div class="d-flex justify-content-between small"><span class="text-muted">Enrolled</span><span class="fw-semibold">{{ number_format($careerPath->enrolled_count) }}</span></div>
        </div>
    </div>
    <div class="col-md-8">
        @foreach($careerPath->stages as $stage)
            <div class="card mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary rounded-pill">{{ $stage->order }}</span>
                            <h6 class="fw-semibold mb-0">{{ $stage->title }}</h6>
                            <span class="badge bg-secondary-subtle text-secondary small">{{ $stage->skills->count() }} skills</span>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.skills.create') }}?stage_id={{ $stage->id }}" class="btn btn-sm btn-outline-success" title="Add Skill"><i class="bi bi-plus"></i></a>
                            <a href="{{ route('admin.stages.edit', $stage) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.stages.destroy', $stage) }}" onsubmit="return confirm('Delete this stage?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="row g-2">
                        @foreach($stage->skills as $skill)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                    <div>
                                        <div class="small fw-semibold">{{ $skill->title }}</div>
                                        <small class="text-muted"><span class="badge bg-{{ $skill->difficulty_color }}-subtle text-{{ $skill->difficulty_color }}" style="font-size:.68rem;">{{ $skill->difficulty }}</span> {{ $skill->estimated_hours }}h · {{ $skill->learningResources->count() }} resources</small>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-sm btn-outline-primary p-1" style="line-height:1;"><i class="bi bi-pencil" style="font-size:.7rem;"></i></a>
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger p-1" style="line-height:1;"><i class="bi bi-trash" style="font-size:.7rem;"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($stage->skills->isEmpty())
                            <div class="col-12"><p class="text-muted small text-center py-2 mb-0">No skills yet. <a href="{{ route('admin.skills.create') }}?stage_id={{ $stage->id }}">Add one</a></p></div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        @if($careerPath->stages->isEmpty())
            <div class="card p-5 text-center">
                <i class="bi bi-layers fs-1 text-muted"></i>
                <p class="text-muted mt-3">No stages yet. <a href="{{ route('admin.stages.create') }}?career_path_id={{ $careerPath->id }}">Add first stage</a></p>
            </div>
        @endif
    </div>
</div>
@endsection
