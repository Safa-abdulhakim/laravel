@extends('layouts.dashboard')
@section('title', __('my_prompts_title'))
@section('page-title', __('my_prompts_title'))
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-white mb-1">{{ __('my_prompts_title') }}</h4>
        <p class="text-muted small mb-0">{{ __('total_prompts_count', ['count' => $prompts->total()]) }}</p>
    </div>
    <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient"><i class="bi bi-plus me-2"></i>{{ __('nav_new_prompt') }}</a>
</div>

{{-- Filters --}}
<div class="card-dark p-3 mb-4">
    <form method="GET" action="{{ route('my-prompts.index') }}" class="row g-2 align-items-end">
        <div class="col-md-6">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-dark" placeholder="{{ __('search_my_prompts') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-dark">
                <option value="">{{ __('all_status') }}</option>
                <option value="public" {{ request('status')=='public'?'selected':'' }}>{{ __('status_public') }}</option>
                <option value="private" {{ request('status')=='private'?'selected':'' }}>{{ __('status_private') }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-gradient flex-grow-1"><i class="bi bi-search me-1"></i>{{ __('search') }}</button>
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
                        <th>{{ __('title_label') }}</th>
                        <th>{{ __('platform_label') }}</th>
                        <th>{{ __('category_label') }}</th>
                        <th>{{ __('status') }}</th>
                        <th>{{ __('views') }}</th>
                        <th>{{ __('date') }}</th>
                        <th>{{ __('actions') }}</th>
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
                                <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-sm" style="background:rgba(6,182,212,0.15);color:#06b6d4;border:none;border-radius:8px;" title="{{ __('view_prompt_title') }}"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('my-prompts.edit', $prompt) }}" class="btn btn-sm" style="background:rgba(124,58,237,0.15);color:#a78bfa;border:none;border-radius:8px;" title="{{ __('edit_prompt_title') }}"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('my-prompts.destroy', $prompt) }}" onsubmit="return confirm('{{ __('delete_prompt_confirm') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.15);color:#f87171;border:none;border-radius:8px;" title="{{ __('delete_prompt_title') }}"><i class="bi bi-trash"></i></button>
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
        <h5 class="text-muted mb-3">{{ __('no_prompts_msg') }}</h5>
        <a href="{{ route('my-prompts.create') }}" class="btn btn-gradient">{{ __('create_first_msg') }}</a>
    </div>
@endif
@endsection
