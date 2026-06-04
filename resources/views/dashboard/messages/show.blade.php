@extends('layouts.dashboard')
@section('title', 'Message from ' . $message->name)
@section('page-title', 'View Message')
@section('content')
<div class="max-w-2xl">
    <div class="admin-card p-6 mb-4">
        <div class="flex items-start justify-between gap-4 mb-6 pb-6" style="border-bottom: 1px solid var(--color-border);">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    {{ strtoupper(substr($message->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-lg" style="color: var(--color-heading);">{{ $message->name }}</div>
                    <a href="mailto:{{ $message->email }}" class="text-sm" style="color: var(--color-accent);">{{ $message->email }}</a>
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm" style="color: var(--color-muted);">{{ $message->created_at->format('M d, Y \a\t H:i') }}</div>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-medium"
                      style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">
                    <i class="fas fa-check-circle"></i> Read
                </span>
            </div>
        </div>
        @if($message->subject)
        <div class="mb-4">
            <div class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: var(--color-muted);">Subject</div>
            <div class="font-semibold" style="color: var(--color-heading);">{{ $message->subject }}</div>
        </div>
        @endif
        <div>
            <div class="text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--color-muted);">Message</div>
            <div class="leading-relaxed whitespace-pre-wrap p-4 rounded-xl" style="background: var(--color-bg); color: var(--color-body);">{{ $message->message }}</div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.messages.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('dashboard.back') }}
        </a>
        <a href="mailto:{{ $message->email }}" class="btn-primary">
            <i class="fas fa-reply"></i> Reply via Email
        </a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
              x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()" class="ms-auto">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger"><i class="fas fa-trash"></i> {{ __('dashboard.delete') }}</button>
        </form>
    </div>
</div>
@endsection
