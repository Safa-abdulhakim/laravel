@extends('admin.layouts.app')
@section('title', 'Message Details')
@section('page-title', 'Message Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Message from {{ $message->name }}</h5>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Message Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $message->name }}</h6>
                        <a href="mailto:{{ $message->email }}" class="text-muted small">{{ $message->email }}</a>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-status-{{ $message->status }} rounded-pill px-3 mb-1 d-block">
                            {{ ucfirst($message->status) }}
                        </span>
                        <div class="text-muted small">{{ $message->created_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
                @if($message->subject)
                    <div class="mt-2 text-muted"><strong>Subject:</strong> {{ $message->subject }}</div>
                @endif
            </div>
            <div class="card-body px-4 pb-4">
                <div class="p-3 rounded" style="background:#f8fafc;border-left:4px solid #6366f1;">
                    <p class="mb-0" style="white-space:pre-line;">{{ $message->message }}</p>
                </div>
            </div>
        </div>

        {{-- Reply Card --}}
        @if($message->reply)
        <div class="card border-0 shadow-sm mb-4" style="border-left:4px solid #10b981 !important;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-semibold text-success mb-0">
                    <i class="bi bi-reply-fill me-2"></i>Your Reply
                    <span class="text-muted fw-normal small ms-2">
                        {{ $message->replied_at?->format('M d, Y H:i') }}
                    </span>
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <p class="mb-0" style="white-space:pre-line;">{{ $message->reply }}</p>
            </div>
        </div>
        @endif

        {{-- Reply Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-semibold mb-0">
                    <i class="bi bi-reply me-2 text-primary"></i>
                    {{ $message->reply ? 'Edit Reply' : 'Write a Reply' }}
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('admin.messages.update', $message) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <textarea name="reply" rows="5"
                                  class="form-control @error('reply') is-invalid @enderror"
                                  placeholder="Write your reply here...">{{ old('reply', $message->reply) }}</textarea>
                        @error('reply')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i> Save Reply
                        </button>
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject ?? 'Your message' }}"
                           class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-1"></i> Send Email
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
