@extends('layouts.dashboard')
@section('title', 'Edit Testimonial')
@section('page-title', 'Edit Testimonial')
@section('content')
<div class="max-w-2xl">
    <div class="admin-card p-6">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
            @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Name (EN) *</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Name (AR)</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $testimonial->name_ar) }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Position</label>
                    <input type="text" name="position" value="{{ old('position', $testimonial->position) }}" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Company</label>
                    <input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="form-input">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Content (EN) *</label>
                    <textarea name="content" rows="4" required class="form-input resize-none" placeholder="Testimonial text...">{{ old('content', $testimonial->content) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Content (AR)</label>
                    <textarea name="content_ar" rows="4" class="form-input resize-none" dir="rtl">{{ old('content_ar', $testimonial->content_ar) }}</textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.rating') }}</label>
                    <select name="rating" class="form-input">
                        @for($i=5;$i>=1;$i--)
                        <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Avatar</label>
                    @if($testimonial->avatar)
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ Storage::url($testimonial->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                        <span class="text-xs" style="color: var(--color-muted);">Current avatar</span>
                    </div>
                    @endif
                    <input type="file" name="avatar" accept="image/*" class="form-input">
                </div>
            </div>
            <div class="flex items-center gap-2 mb-6">
                <input type="checkbox" name="is_visible" id="visible" class="w-4 h-4"
                       {{ old('is_visible', $testimonial->is_visible) ? 'checked' : '' }}>
                <label for="visible" class="text-sm font-medium" style="color: var(--color-heading);">{{ __('dashboard.visibility') }}</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn-secondary">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
