@extends('layouts.dashboard')
@section('title', __('dashboard.manage_cv'))
@section('page-title', __('dashboard.manage_cv'))
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Upload New CV --}}
    <div class="admin-card p-6">
        <h2 class="font-bold mb-4" style="color: var(--color-heading);">{{ __('dashboard.upload_cv') }}</h2>
        <form method="POST" action="{{ route('admin.cv.store') }}" enctype="multipart/form-data">
            @csrf
            @if($errors->any())
            <div class="mb-4 p-3 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
                @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
            </div>
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">PDF File *</label>
                <input type="file" name="cv_file" accept=".pdf" required class="form-input">
                <p class="text-xs mt-1" style="color: var(--color-muted);">Max size: 5MB. PDF format only.</p>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
                <i class="fas fa-upload"></i> Upload CV
            </button>
        </form>
    </div>

    {{-- Current CV --}}
    <div class="admin-card p-6">
        <h2 class="font-bold mb-4" style="color: var(--color-heading);">{{ __('dashboard.current_cv') }}</h2>
        @if($activeCv)
        <div class="p-4 rounded-xl mb-4" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(239, 68, 68, 0.1);">
                    <i class="fas fa-file-pdf" style="color: var(--color-danger);"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium truncate" style="color: var(--color-heading);">{{ $activeCv->file_name }}</div>
                    <div class="text-xs" style="color: var(--color-muted);">Uploaded {{ $activeCv->created_at->diffForHumans() }}</div>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs font-bold" style="background: rgba(16, 185, 129, 0.2); color: var(--color-success);">Active</span>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('cv.download') }}" class="btn-primary flex-1 justify-center">
                <i class="fas fa-download"></i> Download
            </a>
            <form method="POST" action="{{ route('admin.cv.destroy', $activeCv) }}"
                  x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
            </form>
        </div>
        @else
        <div class="text-center py-8" style="color: var(--color-muted);">
            <i class="fas fa-file-pdf text-4xl mb-3 block opacity-20"></i>
            <p>No CV uploaded yet.</p>
        </div>
        @endif
    </div>
</div>

{{-- All CVs history --}}
@if($cvs->total() > 1)
<div class="admin-card mt-6 overflow-hidden">
    <div class="p-4 border-b font-bold" style="border-color: var(--color-border); color: var(--color-heading);">CV History</div>
    <table>
        <thead>
            <tr>
                <th>File Name</th>
                <th>Uploaded</th>
                <th>Status</th>
                <th>{{ __('dashboard.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cvs as $cv)
            <tr>
                <td style="color: var(--color-body);">{{ $cv->file_name }}</td>
                <td class="text-sm" style="color: var(--color-muted);">{{ $cv->created_at->format('M d, Y') }}</td>
                <td>
                    @if($cv->is_active)
                    <span class="px-2 py-0.5 rounded-full text-xs font-bold" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">Active</span>
                    @else
                    <span class="px-2 py-0.5 rounded-full text-xs" style="background: var(--color-border); color: var(--color-muted);">Inactive</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.cv.destroy', $cv) }}"
                          x-data="{}" @submit.prevent="if(confirm('{{ __('dashboard.confirm_delete') }}')) $el.submit()">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs px-3 py-1.5 rounded-lg" style="background: rgba(239, 68, 68, 0.1); color: var(--color-danger);"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
