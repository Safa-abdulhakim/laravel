@extends('layouts.dashboard')
@section('title', 'Add Experience')
@section('page-title', 'Add Experience')
@section('content')
<div class="max-w-2xl">
    <div class="admin-card p-6">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
            @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.company') }} (EN) *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.company') }} (AR)</label>
                    <input type="text" name="company_name_ar" value="{{ old('company_name_ar') }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.position') }} (EN) *</label>
                    <input type="text" name="position" value="{{ old('position') }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.position') }} (AR)</label>
                    <input type="text" name="position_ar" value="{{ old('position_ar') }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.start_date') }} *</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.end_date') }}</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input">
                </div>
            </div>
            <div class="flex items-center gap-2 mb-4">
                <input type="checkbox" name="is_current" id="is_current" class="w-4 h-4" {{ old('is_current') ? 'checked' : '' }}>
                <label for="is_current" class="text-sm font-medium" style="color: var(--color-heading);">{{ __('dashboard.current_job') }}</label>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" class="form-input">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.description') }} (EN)</label>
                    <textarea name="description" rows="4" class="form-input resize-none">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.description') }} (AR)</label>
                    <textarea name="description_ar" rows="4" class="form-input resize-none" dir="rtl">{{ old('description_ar') }}</textarea>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.experiences.index') }}" class="btn-secondary">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
