@extends('layouts.dashboard')

@section('title', __('dashboard.title'))
@section('page-title', __('dashboard.overview'))

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                 style="background: rgba(79, 70, 229, 0.1);">
                <i class="fas fa-code" style="color: var(--color-accent);"></i>
            </div>
            <span class="text-xs font-medium px-2 py-1 rounded-lg" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">Total</span>
        </div>
        <div class="text-3xl font-extrabold mb-1 gradient-text">{{ $stats['projects'] }}</div>
        <div class="text-sm font-medium" style="color: var(--color-muted);">{{ __('dashboard.total_projects') }}</div>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                 style="background: rgba(16, 185, 129, 0.1);">
                <i class="fas fa-star" style="color: var(--color-success);"></i>
            </div>
            <span class="text-xs font-medium px-2 py-1 rounded-lg" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">Total</span>
        </div>
        <div class="text-3xl font-extrabold mb-1" style="color: var(--color-success);">{{ $stats['skills'] }}</div>
        <div class="text-sm font-medium" style="color: var(--color-muted);">{{ __('dashboard.total_skills') }}</div>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                 style="background: rgba(245, 158, 11, 0.1);">
                <i class="fas fa-certificate" style="color: var(--color-warning);"></i>
            </div>
            <span class="text-xs font-medium px-2 py-1 rounded-lg" style="background: rgba(245, 158, 11, 0.1); color: var(--color-warning);">Total</span>
        </div>
        <div class="text-3xl font-extrabold mb-1" style="color: var(--color-warning);">{{ $stats['certificates'] }}</div>
        <div class="text-sm font-medium" style="color: var(--color-muted);">{{ __('dashboard.total_certificates') }}</div>
    </div>

    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                 style="background: {{ $stats['unread_messages'] > 0 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(107, 114, 128, 0.1)' }};">
                <i class="fas fa-envelope" style="color: {{ $stats['unread_messages'] > 0 ? 'var(--color-danger)' : 'var(--color-muted)' }};"></i>
            </div>
            @if($stats['unread_messages'] > 0)
            <span class="text-xs font-bold px-2 py-1 rounded-lg text-white" style="background: var(--color-danger);">{{ $stats['unread_messages'] }} New</span>
            @endif
        </div>
        <div class="text-3xl font-extrabold mb-1" style="color: var(--color-danger);">{{ $stats['messages'] }}</div>
        <div class="text-sm font-medium" style="color: var(--color-muted);">{{ __('dashboard.total_messages') }}</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="admin-card p-6 mb-8">
    <h2 class="font-bold text-lg mb-4" style="color: var(--color-heading);">Quick Actions</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('admin.projects.create') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(79, 70, 229, 0.1);">
                <i class="fas fa-plus" style="color: var(--color-accent);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Add Project</span>
        </a>
        <a href="{{ route('admin.skills.create') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(16, 185, 129, 0.1);">
                <i class="fas fa-star" style="color: var(--color-success);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Add Skill</span>
        </a>
        <a href="{{ route('admin.experiences.create') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(245, 158, 11, 0.1);">
                <i class="fas fa-briefcase" style="color: var(--color-warning);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Add Experience</span>
        </a>
        <a href="{{ route('admin.certificates.create') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(139, 92, 246, 0.1);">
                <i class="fas fa-certificate" style="color: var(--color-secondary);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Add Certificate</span>
        </a>
        <a href="{{ route('admin.messages.index') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239, 68, 68, 0.1);">
                <i class="fas fa-envelope" style="color: var(--color-danger);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Messages</span>
        </a>
        <a href="{{ route('admin.settings.index') }}"
           class="flex flex-col items-center gap-2 p-4 rounded-xl transition-all hover:-translate-y-1 hover:shadow-md"
           style="border: 1px solid var(--color-border);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(107, 114, 128, 0.1);">
                <i class="fas fa-cog" style="color: var(--color-muted);"></i>
            </div>
            <span class="text-xs font-medium text-center" style="color: var(--color-body);">Settings</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Messages --}}
    <div class="admin-card">
        <div class="p-5 border-b flex items-center justify-between" style="border-color: var(--color-border);">
            <h2 class="font-bold" style="color: var(--color-heading);">{{ __('dashboard.recent_messages') }}</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium" style="color: var(--color-accent);">View All</a>
        </div>
        <div class="divide-y" style="--tw-divide-opacity: 1; border-color: var(--color-border);">
            @forelse($recentMessages as $message)
            <div class="p-4 flex items-start gap-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    {{ strtoupper(substr($message->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-medium text-sm truncate" style="color: var(--color-heading);">{{ $message->name }}</span>
                        @if(!$message->is_read)
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background: var(--color-danger);"></span>
                        @endif
                    </div>
                    <p class="text-xs truncate mt-0.5" style="color: var(--color-muted);">{{ $message->subject ?? $message->message }}</p>
                    <p class="text-xs mt-1" style="color: var(--color-muted);">{{ $message->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('admin.messages.show', $message) }}" class="text-xs font-medium flex-shrink-0" style="color: var(--color-accent);">View</a>
            </div>
            @empty
            <div class="p-6 text-center text-sm" style="color: var(--color-muted);">{{ __('messages.no_messages') }}</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Projects --}}
    <div class="admin-card">
        <div class="p-5 border-b flex items-center justify-between" style="border-color: var(--color-border);">
            <h2 class="font-bold" style="color: var(--color-heading);">{{ __('dashboard.recent_projects') }}</h2>
            <a href="{{ route('admin.projects.index') }}" class="text-sm font-medium" style="color: var(--color-accent);">View All</a>
        </div>
        <div class="divide-y" style="border-color: var(--color-border);">
            @forelse($recentProjects as $project)
            <div class="p-4 flex items-center gap-3">
                @if($project->cover_image)
                <img src="{{ Storage::url($project->cover_image) }}" class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                @else
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    <i class="fas fa-code text-white text-xs"></i>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm truncate" style="color: var(--color-heading);">{{ $project->title }}</div>
                    <div class="text-xs mt-0.5" style="color: var(--color-muted);">{{ ucfirst($project->category) }}</div>
                </div>
                <div class="flex items-center gap-2">
                    @if($project->featured)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">Featured</span>
                    @endif
                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs font-medium" style="color: var(--color-accent);">Edit</a>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-sm" style="color: var(--color-muted);">{{ __('messages.no_projects') }}</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Skills Overview --}}
<div class="admin-card mt-6 p-6">
    <h2 class="font-bold mb-6" style="color: var(--color-heading);">Skills Overview</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($skillsByCategory as $category => $skills)
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold capitalize" style="color: var(--color-heading);">{{ $category }}</h3>
                <span class="text-xs px-2 py-0.5 rounded-full" style="background: var(--color-border); color: var(--color-muted);">{{ $skills->count() }}</span>
            </div>
            <div class="space-y-2">
                @foreach($skills->take(4) as $skill)
                <div class="flex items-center justify-between gap-3">
                    <span class="text-xs" style="color: var(--color-body);">{{ $skill->name }}</span>
                    <div class="flex-1 h-1.5 rounded-full" style="background: var(--color-border);">
                        <div class="h-full rounded-full" style="width: {{ $skill->percentage }}%; background: linear-gradient(90deg, var(--color-accent), var(--color-secondary));"></div>
                    </div>
                    <span class="text-xs font-bold w-8 text-right" style="color: var(--color-accent);">{{ $skill->percentage }}%</span>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
