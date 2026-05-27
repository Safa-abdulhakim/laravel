@extends('admin.layouts.app')
@section('title', 'Messages')
@section('page-title', 'Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Messages</h5>
        <small class="text-muted">{{ $messages->total() }} total
            @if($newCount > 0)
                — <span class="text-danger fw-medium">{{ $newCount }} unread</span>
            @endif
        </small>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Sender</th>
                        <th>Subject / Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr class="{{ $msg->status === 'new' ? 'table-light fw-semibold' : '' }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                @if($msg->status === 'new')
                                    <span class="rounded-circle bg-primary d-inline-block"
                                          style="width:8px;height:8px;flex-shrink:0;"></span>
                                @endif
                                <div>
                                    <div>{{ $msg->name }}</div>
                                    <div class="text-muted small fw-normal">{{ $msg->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($msg->subject)
                                <div class="small fw-medium">{{ $msg->subject }}</div>
                            @endif
                            <div class="text-muted small fw-normal">{{ Str::limit($msg->message, 60) }}</div>
                        </td>
                        <td>
                            <span class="badge badge-status-{{ $msg->status }} rounded-pill px-3">
                                {{ ucfirst($msg->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $msg->created_at->diffForHumans() }}</td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.messages.show', $msg) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('{{ route('admin.messages.destroy', $msg) }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-chat-dots fs-1 text-muted d-block mb-2"></i>
                            <span class="text-muted">No messages yet.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
    <div class="card-footer bg-white border-0">{{ $messages->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection
@push('scripts')
<script>
function confirmDelete(url){if(confirm('Delete this message?')){const f=document.getElementById('deleteForm');f.action=url;f.submit();}}
</script>
@endpush
