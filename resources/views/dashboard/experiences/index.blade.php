@extends('layouts.dashboard')
@section('title', __('dashboard.manage_experiences'))
@section('page-title', __('dashboard.manage_experiences'))
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.experiences.create') }}" class="btn-primary"><i class="fas fa-plus"></i> {{ __('dashboard.add_new') }}</a>
</div>
<div class="admin-card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>{{ __('dashboard.position') }} / {{ __('dashboard.company') }}</th>
                <th>{{ __('dashboard.start_date') }}</th>
                <th>{{ __('dashboard.end_date') }}</th>
                <th>Status</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experiences as $exp)
            <tr>
                <td>
                    <div class="font-semibold" style="color: var(--color-heading);">{{ $exp->position }}</div>
                    <div class="text-sm" style="color: var(--color-accent);">{{ $exp->company_name }}</div>
                    @if($exp->location)
                    <div class="text-xs" style="color: var(--color-muted);"><i class="fas fa-map-marker-alt"></i> {{ $exp->location }}</div>
                    @endif
                </td>
                <td class="text-sm" style="color: var(--color-body);">{{ $exp->start_date->format('M Y') }}</td>
                <td class="text-sm" style="color: var(--color-body);">{{ $exp->is_current ? '—' : ($exp->end_date ? $exp->end_date->format('M Y') : '—') }}</td>
                <td>
                    @if($exp->is_current)
                    <span class="px-2 py-1 rounded-full text-xs font-bold" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">Current</span>
                    @else
                    <span class="px-2 py-1 rounded-full text-xs font-bold" style="background: var(--color-border); color: var(--color-muted);">Past</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.experiences.edit', $exp) }}" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);"><i class="fas fa-edit"></i> {{ __('dashboard.edit') }}</a>
                        <form method="POST" action="{{ route('admin.experiences.destroy', $exp) }}" x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12" style="color: var(--color-muted);">{{ __('dashboard.no_data') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
