@extends('layouts.dashboard')
@section('title', __('dashboard.manage_skills'))
@section('page-title', __('dashboard.manage_skills'))
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.skills.create') }}" class="btn-primary"><i class="fas fa-plus"></i> {{ __('dashboard.add_new') }}</a>
</div>
@foreach($skillsByCategory as $category => $skills)
<div class="admin-card overflow-hidden mb-6">
    <div class="p-4 border-b flex items-center gap-2" style="border-color: var(--color-border);">
        <span class="font-bold capitalize" style="color: var(--color-heading);">{{ $category }}</span>
        <span class="text-xs px-2 py-0.5 rounded-full" style="background: var(--color-border); color: var(--color-muted);">{{ $skills->count() }}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>{{ __('dashboard.percentage') }}</th>
                <th>Icon</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($skills as $skill)
            <tr>
                <td>
                    <div class="flex items-center gap-2">
                        @if($skill->icon)
                        <i class="{{ $skill->icon }}" style="color: {{ $skill->color ?? 'var(--color-accent)' }};"></i>
                        @endif
                        <span style="color: var(--color-heading);">{{ $skill->name }}</span>
                        @if($skill->name_ar)
                        <span class="text-xs" style="color: var(--color-muted);">({{ $skill->name_ar }})</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-2 rounded-full" style="background: var(--color-border);">
                            <div class="h-full rounded-full" style="width: {{ $skill->percentage }}%; background: linear-gradient(90deg, var(--color-accent), var(--color-secondary));"></div>
                        </div>
                        <span class="text-sm font-bold" style="color: var(--color-accent);">{{ $skill->percentage }}%</span>
                    </div>
                </td>
                <td><span class="text-xs font-mono" style="color: var(--color-muted);">{{ $skill->icon ?? '—' }}</span></td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.skills.edit', $skill) }}" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);"><i class="fas fa-edit"></i> {{ __('dashboard.edit') }}</a>
                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach
@endsection
