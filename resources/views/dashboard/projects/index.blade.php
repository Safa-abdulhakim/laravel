@extends('layouts.dashboard')
@section('title', __('dashboard.manage_projects'))
@section('page-title', __('dashboard.manage_projects'))
@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> {{ __('dashboard.add_new') }}
    </a>
</div>
<div class="admin-card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Category</th>
                <th>Technologies</th>
                <th>Featured</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        @if($project->cover_image)
                        <img src="{{ Storage::url($project->cover_image) }}" class="w-12 h-12 rounded-xl object-cover">
                        @else
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                            <i class="fas fa-code text-white text-sm"></i>
                        </div>
                        @endif
                        <div>
                            <div class="font-semibold" style="color: var(--color-heading);">{{ $project->title }}</div>
                            @if($project->title_ar)
                            <div class="text-xs" style="color: var(--color-muted);">{{ $project->title_ar }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td><span class="px-2 py-1 rounded-lg text-xs font-medium" style="background: var(--color-border); color: var(--color-muted);">{{ $project->category }}</span></td>
                <td>
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-1">
                        @foreach(array_slice($project->technologies, 0, 3) as $tech)
                        <span class="px-1.5 py-0.5 rounded text-xs" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">{{ $tech }}</span>
                        @endforeach
                        @if(count($project->technologies) > 3)
                        <span class="text-xs" style="color: var(--color-muted);">+{{ count($project->technologies) - 3 }}</span>
                        @endif
                    </div>
                    @endif
                </td>
                <td>
                    @if($project->featured)
                    <span class="px-2 py-1 rounded-lg text-xs font-bold" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">⭐ Featured</span>
                    @else
                    <span class="text-xs" style="color: var(--color-muted);">—</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank"
                           class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all"
                           style="border: 1px solid var(--color-border); color: var(--color-muted);">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="text-xs px-3 py-1.5 rounded-lg font-medium"
                           style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">
                            <i class="fas fa-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" x-data="{}"
                              @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg font-medium"
                                    style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-12" style="color: var(--color-muted);">
                    <i class="fas fa-folder-open text-4xl mb-3 block opacity-30"></i>
                    {{ __('dashboard.no_data') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($projects->hasPages())
    <div class="p-4 border-t" style="border-color: var(--color-border);">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
