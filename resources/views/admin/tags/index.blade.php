@extends('layouts.dashboard')
@section('title', 'Tags')
@section('page-title', 'Manage Tags')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-white mb-0">Tags</h4>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus me-2"></i>New Tag
    </a>
</div>

<div class="card-dark">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr><th>Tag</th><th>Slug</th><th>Prompts</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)
                <tr>
                    <td>
                        <span style="background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);padding:4px 14px;border-radius:20px;font-size:0.85rem;font-weight:500;">
                            {{ $tag->name }}
                        </span>
                    </td>
                    <td>
                        <code style="color:#94a3b8;font-size:0.8rem">{{ $tag->slug }}</code>
                    </td>
                    <td>
                        <span class="badge" style="background:rgba(6,182,212,0.15);color:#06b6d4;border:1px solid rgba(6,182,212,0.3)">
                            {{ $tag->prompts_count }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $tag->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm"
                                style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                onsubmit="return confirm('Delete this tag?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                    style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-tags d-block fs-2 mb-2" style="color:#334155"></i>
                        No tags yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tags->hasPages())
        <div class="p-4 d-flex justify-content-center">
            {{ $tags->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
