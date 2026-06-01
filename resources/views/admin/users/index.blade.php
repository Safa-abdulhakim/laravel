@extends('layouts.dashboard')
@section('title', __('users_page_title'))
@section('page-title', __('users_page_title'))
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-white mb-0">{{ __('users_page_title') }}</h4>
    <span class="badge" style="background:rgba(124,58,237,0.2);color:#a78bfa;font-size:0.85rem;padding:8px 14px;border-radius:10px;">
        {{ $users->total() }} {{ __('nav_prompts') }}
    </span>
</div>

{{-- Search --}}
<div class="card-dark p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control form-control-dark" placeholder="{{ __('search_users') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-gradient w-100">
                <i class="bi bi-search me-1"></i>{{ __('search') }}
            </button>
        </div>
        @if(request('search'))
        <div class="col-md-2">
            <a href="{{ route('admin.users.index') }}" class="btn w-100"
                style="background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.3);border-radius:10px;">
                <i class="bi bi-x me-1"></i>{{ __('clear_filters') }}
            </a>
        </div>
        @endif
    </form>
</div>

<div class="card-dark">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr><th>{{ __('user_col') }}</th><th>{{ __('email_col') }}</th><th>{{ __('role_col') }}</th><th>{{ __('prompts_col') }}</th><th>{{ __('joined_label') }}</th><th>{{ __('actions') }}</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width:36px;height:36px;background:linear-gradient(135deg,#7c3aed,#4f46e5)">
                                <span class="text-white fw-bold" style="font-size:0.8rem">{{ strtoupper(substr($user->name,0,1)) }}</span>
                            </div>
                            <span class="fw-semibold text-white">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                                <span class="badge" style="background:rgba(6,182,212,0.15);color:#06b6d4;font-size:0.65rem">{{ __('you_label') }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge" style="background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.3)">
                                <i class="bi bi-shield-check me-1"></i>{{ __('administrator_label') }}
                            </span>
                        @else
                            <span class="badge" style="background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid #334155">
                                <i class="bi bi-person me-1"></i>{{ __('regular_user_label') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->prompts_count }}</td>
                    <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm"
                                style="background:rgba(6,182,212,0.15);color:#06b6d4;border:none;border-radius:8px;" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm"
                                        style="background:rgba(245,158,11,0.15);color:#f59e0b;border:none;border-radius:8px;"
                                        title="{{ $user->role === 'admin' ? __('revoke_admin_title') : __('make_admin_title') }}">
                                        <i class="bi bi-shield-{{ $user->role === 'admin' ? 'x' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('Delete user {{ $user->name }} and all their data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:8px;" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-people d-block fs-2 mb-2" style="color:#334155"></i>
                        {{ __('no_results') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="p-4 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
