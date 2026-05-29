@extends('layouts.dashboard')
@section('title', 'All Prompts')
@section('page-title', 'All Prompts')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-white mb-0">
        All Prompts
        <span class="badge ms-2" style="background:rgba(124,58,237,0.2);color:#a78bfa;font-size:0.75rem;border-radius:8px;">Admin</span>
    </h4>
    <a href="{{ route('admin.prompts.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus me-2"></i>New Prompt
    </a>
</div>

{{-- Filters --}}
<div class="card-dark p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control form-control-dark" placeholder="Search title or content...">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-dark">
                <option value="">All Status</option>
                <option value="public"  {{ request('status')=='public'  ? 'selected':'' }}>Public</option>
                <option value="private" {{ request('status')=='private' ? 'selected':'' }}>Private</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="platform" class="form-select form-select-dark">
                <option value="">All Platforms</option>
                @foreach($platforms as $p)
                    <option value="{{ $p }}" {{ request('platform')==$p ? 'selected':'' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select form-select-dark">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-gradient flex-grow-1">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            @if(request()->hasAny(['search','status','platform','category']))
                <a href="{{ route('admin.prompts.index') }}" class="btn"
                    style="background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:10px;">
                    <i class="bi bi-x"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card-dark">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Title</th><th>User</th><th>Platform</th><th>Category</th>
                    <th>Status</th><th>Views</th><th>Date</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prompts as $prompt)
                <tr>
                    <td class="fw-semibold text-white" style="max-width:200px">
                        {{ Str::limit($prompt->title, 35) }}
                    </td>
                    <td class="text-muted small">{{ $prompt->user->name }}</td>
                    <td><span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span></td>
                    <td class="text-muted small">{{ $prompt->category?->name ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $prompt->status === 'public' ? 'badge-public' : 'badge-private' }}">
                            {{ ucfirst($prompt->status) }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $prompt->views }}</td>
                    <td class="text-muted small">{{ $prompt->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-sm"
                                style="background:rgba(6,182,212,0.15);color:#06b6d4;border:none;border-radius:8px;" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.prompts.edit', $prompt) }}" class="btn btn-sm"
                                style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.prompts.destroy', $prompt) }}"
                                onsubmit="return confirm('Delete this prompt permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                    style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:8px;" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-collection d-block fs-2 mb-2" style="color:#334155"></i>
                        No prompts found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($prompts->hasPages())
        <div class="p-4 d-flex justify-content-center">
            {{ $prompts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
