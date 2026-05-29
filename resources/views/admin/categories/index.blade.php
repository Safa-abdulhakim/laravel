@extends('layouts.dashboard')
@section('title', 'Categories')
@section('page-title', 'Manage Categories')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-white mb-0">Categories</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-gradient">
        <i class="bi bi-plus me-2"></i>New Category
    </a>
</div>

<div class="card-dark">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Name</th><th>Slug</th><th>Description</th><th>Prompts</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-semibold text-white">{{ $category->name }}</td>
                    <td>
                        <code style="color:#a78bfa;background:rgba(124,58,237,0.1);padding:2px 8px;border-radius:4px;font-size:0.8rem">
                            {{ $category->slug }}
                        </code>
                    </td>
                    <td class="text-muted small">{{ Str::limit($category->description, 50) ?? '—' }}</td>
                    <td>
                        <span class="badge" style="background:rgba(6,182,212,0.15);color:#06b6d4;border:1px solid rgba(6,182,212,0.3)">
                            {{ $category->prompts_count }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-sm"
                                style="background:rgba(6,182,212,0.15);color:#06b6d4;border:none;border-radius:8px;" title="View Public">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm"
                                style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                onsubmit="return confirm('Delete category? This may affect related prompts.')">
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
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-folder-x d-block fs-2 mb-2" style="color:#334155"></i>
                        No categories yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="p-4 d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
