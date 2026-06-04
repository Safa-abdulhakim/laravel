@extends('layouts.dashboard')
@section('title', 'Add Skill')
@section('page-title', 'Add New Skill')
@section('content')
<div class="max-w-xl">
    <div class="admin-card p-6">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
            @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('admin.skills.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Name (EN) *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Name (AR)</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar') }}" class="form-input" dir="rtl">
                </div>
            </div>
            <div class="mb-4" x-data="{ val: {{ old('percentage', 80) }} }">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.percentage') }} *</label>
                <input type="range" name="percentage" x-model="val" min="0" max="100" class="w-full">
                <div class="text-right text-sm font-bold mt-1" style="color: var(--color-accent);" x-text="val + '%'"></div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.category') }} *</label>
                <select name="category" class="form-input" required>
                    <option value="backend" {{ old('category') === 'backend' ? 'selected' : '' }}>Backend</option>
                    <option value="frontend" {{ old('category') === 'frontend' ? 'selected' : '' }}>Frontend</option>
                    <option value="tools" {{ old('category') === 'tools' ? 'selected' : '' }}>Tools</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.icon') }}</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" class="form-input" placeholder="fab fa-laravel">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.color') }}</label>
                    <input type="color" name="color" value="{{ old('color', '#4F46E5') }}" class="form-input h-10">
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">{{ __('dashboard.sort_order') }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.skills.index') }}" class="btn-secondary">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
