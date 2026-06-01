@extends('layouts.dashboard')
@section('title', $user->name)
@section('page-title', __('user_profile_title'))
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none small">
        <i class="bi bi-arrow-left me-1"></i>{{ __('users_page_title') }}
    </a>
</div>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card-dark p-4 text-center mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                style="width:80px;height:80px;background:linear-gradient(135deg,#7c3aed,#4f46e5)">
                <span class="text-white fw-bold" style="font-size:2rem">{{ strtoupper(substr($user->name,0,1)) }}</span>
            </div>
            <h5 class="fw-bold text-white mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            @if($user->role === 'admin')
                <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);padding:6px 14px;">
                    <i class="bi bi-shield-check me-1"></i>{{ __('administrator_label') }}
                </span>
            @else
                <span class="badge" style="background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid #334155;padding:6px 14px;">
                    <i class="bi bi-person me-1"></i>{{ __('regular_user_label') }}
                </span>
            @endif
            <hr style="border-color:#334155;margin:1.5rem 0">
            <div class="row text-center">
                <div class="col-6">
                    <div class="fw-bold text-white fs-5">{{ $user->prompts->count() }}</div>
                    <div class="text-muted" style="font-size:0.75rem">{{ __('nav_prompts') }}</div>
                </div>
                <div class="col-6">
                    <div class="fw-bold text-white fs-5">{{ $user->created_at->format('M Y') }}</div>
                    <div class="text-muted" style="font-size:0.75rem">{{ __('joined_label') }}</div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        @if($user->id !== auth()->id())
        <div class="card-dark p-4">
            <h6 class="fw-semibold text-white mb-3">{{ __('actions') }}</h6>
            <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}" class="mb-2">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn w-100"
                    style="background:rgba(245,158,11,0.1);color:#f59e0b;border:1px solid rgba(245,158,11,0.3);border-radius:10px;padding:10px;">
                    <i class="bi bi-shield-{{ $user->role === 'admin' ? 'x' : 'check' }} me-2"></i>
                    {{ $user->role === 'admin' ? __('revoke_admin') : __('grant_admin') }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                onsubmit="return confirm('Permanently delete this user and all their data?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn w-100"
                    style="background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:10px;">
                    <i class="bi bi-trash me-2"></i>{{ __('delete_user_btn') }}
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- User's Prompts --}}
    <div class="col-md-8">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">{{ __('users_prompts_title') }} ({{ $user->prompts->count() }})</h5>
            @forelse($user->prompts as $prompt)
                <div class="d-flex justify-content-between align-items-start mb-3 pb-3"
                    style="border-bottom:1px solid #1e293b">
                    <div class="flex-grow-1 me-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="platform-badge platform-{{ strtolower($prompt->platform) }}">{{ $prompt->platform }}</span>
                            <span class="badge {{ $prompt->status === 'public' ? 'badge-public' : 'badge-private' }}">
                                {{ ucfirst($prompt->status) }}
                            </span>
                        </div>
                        <a href="{{ route('prompts.show', $prompt) }}" class="text-white text-decoration-none fw-semibold">
                            {{ $prompt->title }}
                        </a>
                        <p class="text-muted small mb-0 mt-1" style="font-size:0.78rem">
                            {{ Str::limit($prompt->prompt_content, 80) }}
                        </p>
                    </div>
                    <div class="text-end flex-shrink-0">
                        <div class="text-muted small"><i class="bi bi-eye me-1"></i>{{ $prompt->views }}</div>
                        <div class="text-muted" style="font-size:0.75rem">{{ $prompt->created_at->format('M d') }}</div>
                        <div class="d-flex gap-1 mt-1">
                            <a href="{{ route('admin.prompts.edit', $prompt) }}" class="btn btn-sm"
                                style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:6px;padding:3px 8px;">
                                <i class="bi bi-pencil" style="font-size:0.75rem"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.prompts.destroy', $prompt) }}"
                                onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                    style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:6px;padding:3px 8px;">
                                    <i class="bi bi-trash" style="font-size:0.75rem"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-collection d-block fs-2 mb-2" style="color:#334155"></i>
                    <p class="text-muted">{{ __('no_user_prompts') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
