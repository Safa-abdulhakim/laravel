@extends('layouts.admin')
@section('title', $skill->title)
@section('page-title', $skill->title)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.stages.show', $skill->stage) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
    <a href="{{ route('admin.resources.create') }}?skill_id={{ $skill->id }}" class="btn btn-success btn-sm"><i class="bi bi-plus me-1"></i>Add Resource</a>
</div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Skill Info</h6>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Stage</span><span>{{ $skill->stage->title }}</span></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Path</span><span>{{ $skill->stage->careerPath->title }}</span></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Difficulty</span><span class="badge bg-{{ $skill->difficulty_color }}-subtle text-{{ $skill->difficulty_color }}">{{ $skill->difficulty }}</span></div>
            <div class="d-flex justify-content-between small"><span class="text-muted">Estimated</span><span>{{ $skill->estimated_hours }}h</span></div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-4">
            <h6 class="fw-semibold mb-4">Learning Resources</h6>
            @forelse($skill->learningResources as $res)
                <div class="d-flex align-items-center justify-content-between p-2 border rounded-3 mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-{{ $res->type_color }}-subtle text-{{ $res->type_color }}"><i class="{{ $res->type_icon }}"></i></span>
                        <div>
                            <div class="small fw-semibold">{{ $res->title }}</div>
                            <small class="text-muted">{{ $res->provider }} · {{ $res->type }}</small>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <a href="{{ $res->url }}" target="_blank" class="btn btn-sm btn-outline-info p-1"><i class="bi bi-box-arrow-up-right" style="font-size:.75rem;"></i></a>
                        <a href="{{ route('admin.resources.edit', $res) }}" class="btn btn-sm btn-outline-primary p-1"><i class="bi bi-pencil" style="font-size:.75rem;"></i></a>
                        <form method="POST" action="{{ route('admin.resources.destroy', $res) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger p-1"><i class="bi bi-trash" style="font-size:.75rem;"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-3">No resources yet. <a href="{{ route('admin.resources.create') }}?skill_id={{ $skill->id }}">Add one</a></p>
            @endforelse
        </div>
    </div>
</div>
@endsection
