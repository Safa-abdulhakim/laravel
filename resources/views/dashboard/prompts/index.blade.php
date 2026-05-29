@extends('layouts.dashboard')
@section('title', 'My Prompts')
@section('page-title', 'My Prompts')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-white mb-1">My Prompts</h4>
        <p class="text-muted small mb-0">{{ $prompts->total() }} total prompts</p>
    </div>
    <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient"><i class="bi bi-plus me-2"></i>New Prompt</a>
</div>

{{-- Filters --}}
<div class="card-dark p-3 mb-4">
    <form method="GET" action="{{ route('my-prompts.index') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-dark" placeholder="Search prompts...">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-dark">
                <option value="">All Status</option>
                <option value="public" {{ request('status')=='public'?'selected':'' }}>Public</option>
                <option value="private" {{ request('status')=='private'?'selected':'' }}>Private</option>
            </select>
        </div>
        <div class="col-md-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-search me-1"></i>Search</button>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('my-prompts.index') }}" class="btn" style="background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:10px;"><i class="bi bi-x"></i></a>
                @endif
            </div>
        </div>
    </form>
</div>

@if($prompts->count())
    <div class="card-dark">
        <div class="table-responsive">
            <table class="table table-dark-custom mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Platform</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prompts as $prompt)
                    <tr>
                        <td>
                            <div class="fw-semibold text-white">{{ Str::limit($prompt->title, 40) }}</div>
                            <div class="text-muted" style="font-size:0.75rem">{{ $prompt->tags->pluck('name')->join(', ') }}</div>
                        </td>
                        <td><span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span></td>
                        <td class="text-muted small">{{ $prompt->category?->name ?? '—' }}</td>
                        <td><span class="badge {{ $prompt->status === 'public' ? 'badge-public' : 'badge-private' }}">{{ ucfirst($prompt->status) }}</span></td>
                        <td class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }}</td>
                        <td class="text-muted small">{{ $prompt->created_at->format('M d') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-sm" style="background:rgba(6,182,212,0.15);color:#06b6d4;border:none;border-radius:8px;" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('my-prompts.edit', $prompt) }}" class="btn btn-sm" style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('my-prompts.destroy', $prompt) }}" onsubmit="return confirm('Delete this prompt?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:8px;" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($prompts->hasPages())
            <div class="p-4 d-flex justify-content-center">
                {{ $prompts->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@else
    <div class="card-dark p-5 text-center">
        <i class="bi bi-collection fs-1 mb-3" style="color:#334155"></i>
        <h5 class="text-muted mb-3">No prompts found</h5>
        <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient">Create Your First Prompt</a>
    </div>
@endif
@endsection
