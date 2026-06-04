@extends('layouts.dashboard')
@section('title', __('dashboard.manage_testimonials'))
@section('page-title', __('dashboard.manage_testimonials'))
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.testimonials.create') }}" class="btn-primary"><i class="fas fa-plus"></i> {{ __('dashboard.add_new') }}</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($testimonials as $t)
    <div class="admin-card p-5">
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-center gap-3 mb-3">
                @if($t->avatar)
                <img src="{{ Storage::url($t->avatar) }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    {{ strtoupper(substr($t->name, 0, 1)) }}
                </div>
                @endif
                <div>
                    <div class="font-bold" style="color: var(--color-heading);">{{ $t->name }}</div>
                    <div class="text-xs" style="color: var(--color-accent);">{{ $t->position }} @if($t->company) · {{ $t->company }} @endif</div>
                </div>
            </div>
            <div class="flex gap-1">
                @if($t->is_visible)
                <span class="px-2 py-0.5 rounded-full text-xs font-bold" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">Visible</span>
                @else
                <span class="px-2 py-0.5 rounded-full text-xs" style="background: var(--color-border); color: var(--color-muted);">Hidden</span>
                @endif
            </div>
        </div>
        <div class="flex gap-1 mb-2">
            @for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$t->rating ? '' : 'opacity-20' }}" style="color: var(--color-warning);"></i>@endfor
        </div>
        <p class="text-sm italic mb-4 line-clamp-2" style="color: var(--color-muted);">"{{ $t->content }}"</p>
        <div class="flex gap-2">
            <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);"><i class="fas fa-edit"></i> {{ __('dashboard.edit') }}</a>
            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-2 text-center py-12" style="color: var(--color-muted);">
        <i class="fas fa-quote-right text-4xl mb-3 block opacity-20"></i>
        {{ __('dashboard.no_data') }}
    </div>
    @endforelse
</div>
@endsection
