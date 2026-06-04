@extends('layouts.dashboard')
@section('title', __('dashboard.manage_settings'))
@section('page-title', __('dashboard.manage_settings'))
@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl" style="background: rgba(16, 185, 129, 0.1); color: var(--color-success);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1);">
        @foreach($errors->all() as $e)<p class="text-sm" style="color: var(--color-danger);">• {{ $e }}</p>@endforeach
    </div>
    @endif

    {{-- Personal Info --}}
    <div class="admin-card p-6 mb-6">
        <h2 class="font-bold text-lg mb-6 pb-3 border-b" style="color: var(--color-heading); border-color: var(--color-border);">
            <i class="fas fa-user me-2" style="color: var(--color-accent);"></i>{{ __('dashboard.personal_info') }}
        </h2>

        {{-- Avatar --}}
        <div class="flex items-center gap-6 mb-6">
            <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0" style="border: 2px solid var(--color-border);">
                @if($settings->get('avatar'))
                <img src="{{ Storage::url($settings->get('avatar')) }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-white text-2xl font-bold"
                     style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                    {{ strtoupper(substr($settings->get('full_name', 'A'), 0, 1)) }}
                </div>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Profile Photo</label>
                <input type="file" name="avatar" accept="image/*" class="form-input">
                <p class="text-xs mt-1" style="color: var(--color-muted);">JPG, PNG. Max 2MB.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Full Name (EN)</label>
                <input type="text" name="full_name" value="{{ $settings->get('full_name') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Full Name (AR)</label>
                <input type="text" name="full_name_ar" value="{{ $settings->get('full_name_ar') }}" class="form-input" dir="rtl">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Job Title (EN)</label>
                <input type="text" name="job_title" value="{{ $settings->get('job_title') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Job Title (AR)</label>
                <input type="text" name="job_title_ar" value="{{ $settings->get('job_title_ar') }}" class="form-input" dir="rtl">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Bio (EN)</label>
                <textarea name="bio" rows="4" class="form-input resize-none">{{ $settings->get('bio') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Bio (AR)</label>
                <textarea name="bio_ar" rows="4" class="form-input resize-none" dir="rtl">{{ $settings->get('bio_ar') }}</textarea>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Email</label>
                <input type="email" name="email" value="{{ $settings->get('email') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Phone</label>
                <input type="text" name="phone" value="{{ $settings->get('phone') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Years Experience</label>
                <input type="number" name="years_experience" value="{{ $settings->get('years_experience') }}" class="form-input">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Location (EN)</label>
                <input type="text" name="location" value="{{ $settings->get('location') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Location (AR)</label>
                <input type="text" name="location_ar" value="{{ $settings->get('location_ar') }}" class="form-input" dir="rtl">
            </div>
        </div>
    </div>

    {{-- Social Links --}}
    <div class="admin-card p-6 mb-6">
        <h2 class="font-bold text-lg mb-6 pb-3 border-b" style="color: var(--color-heading); border-color: var(--color-border);">
            <i class="fas fa-share-alt me-2" style="color: var(--color-secondary);"></i>{{ __('dashboard.social_links') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                    <i class="fab fa-github me-1"></i>GitHub URL
                </label>
                <input type="url" name="github_url" value="{{ $settings->get('github_url') }}" class="form-input" placeholder="https://github.com/username">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                    <i class="fab fa-linkedin me-1"></i>LinkedIn URL
                </label>
                <input type="url" name="linkedin_url" value="{{ $settings->get('linkedin_url') }}" class="form-input" placeholder="https://linkedin.com/in/username">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">
                    <i class="fab fa-twitter me-1"></i>Twitter URL
                </label>
                <input type="url" name="twitter_url" value="{{ $settings->get('twitter_url') }}" class="form-input" placeholder="https://twitter.com/username">
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary">
        <i class="fas fa-save"></i> {{ __('dashboard.save_settings') }}
    </button>
</form>
@endsection
