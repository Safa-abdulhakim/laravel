@extends('layouts.dashboard')
@section('title', 'Edit Certificate')
@section('page-title', 'Edit Certificate')
@section('content')
<div class="max-w-xl">
    <div class="admin-card p-6">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
            @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Title (EN) *</label>
                    <input type="text" name="title" value="{{ old('title', $certificate->title) }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Title (AR)</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $certificate->title_ar) }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.issuer') }} (EN) *</label>
                    <input type="text" name="issuer" value="{{ old('issuer', $certificate->issuer) }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.issuer') }} (AR)</label>
                    <input type="text" name="issuer_ar" value="{{ old('issuer_ar', $certificate->issuer_ar) }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.issue_date') }} *</label>
                    <input type="date" name="issue_date" value="{{ old('issue_date', $certificate->issue_date->format('Y-m-d')) }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.expiry_date') }}</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $certificate->expiry_date ? $certificate->expiry_date->format('Y-m-d') : '') }}" class="form-input">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.credential_id') }}</label>
                <input type="text" name="credential_id" value="{{ old('credential_id', $certificate->credential_id) }}" class="form-input">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.credential_url') }}</label>
                <input type="url" name="credential_url" value="{{ old('credential_url', $certificate->credential_url) }}" class="form-input">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Certificate Image</label>
                @if($certificate->image)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ Storage::url($certificate->image) }}" class="w-20 h-20 rounded-xl object-cover"
                         style="border: 1px solid var(--color-border);">
                    <div>
                        <p class="text-xs mb-1" style="color: var(--color-muted);">Current certificate image</p>
                        <label class="flex items-center gap-2 text-xs cursor-pointer" style="color: var(--color-danger);">
                            <input type="checkbox" name="remove_image" value="1" class="w-3 h-3">
                            Remove current image
                        </label>
                    </div>
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-input">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.certificates.index') }}" class="btn-secondary">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
