@extends('layouts.dashboard')
@section('title', __('dashboard.manage_messages'))
@section('page-title', __('dashboard.manage_messages'))
@section('content')
<div class="admin-card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr class="{{ !$message->is_read ? 'font-semibold' : '' }}">
                <td>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                             style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                            {{ strtoupper(substr($message->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="color: var(--color-heading);">{{ $message->name }}</div>
                            <div class="text-xs" style="color: var(--color-muted);">{{ $message->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="max-w-xs">
                    <span class="truncate block" style="color: var(--color-body);">{{ $message->subject ?? Str::limit($message->message, 50) }}</span>
                </td>
                <td>
                    @if($message->is_read)
                    <span class="px-2 py-1 rounded-full text-xs font-medium" style="background: rgba(107, 114, 128, 0.1); color: var(--color-muted);">{{ __('messages.read') }}</span>
                    @else
                    <span class="px-2 py-1 rounded-full text-xs font-bold" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);">{{ __('messages.unread') }}</span>
                    @endif
                </td>
                <td class="text-sm" style="color: var(--color-muted);">{{ $message->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.messages.show', $message) }}"
                           class="text-xs px-3 py-1.5 rounded-lg font-medium"
                           style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                              x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
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
                    <i class="fas fa-inbox text-4xl mb-3 block opacity-30"></i>
                    {{ __('messages.no_messages') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($messages->hasPages())
    <div class="p-4 border-t" style="border-color: var(--color-border);">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
