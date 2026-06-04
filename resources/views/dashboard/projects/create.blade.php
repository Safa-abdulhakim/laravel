@extends('layouts.dashboard')
@section('title', 'Add Project')
@section('page-title', 'Add New Project')
@section('content')
<div class="max-w-4xl">
    <div class="admin-card p-6">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
            <ul class="text-sm space-y-1" style="color: var(--color-danger);">
                @foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Title (EN) *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="form-input" placeholder="Project title">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Title (AR)</label>
                    <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-input" dir="rtl" placeholder="اسم المشروع">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Description (EN)</label>
                    <textarea name="description" rows="4" class="form-input resize-none" placeholder="Short description...">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Description (AR)</label>
                    <textarea name="description_ar" rows="4" class="form-input resize-none" dir="rtl" placeholder="وصف مختصر...">{{ old('description_ar') }}</textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Overview (EN)</label>
                    <textarea name="overview" rows="4" class="form-input resize-none" placeholder="Detailed overview...">{{ old('overview') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Overview (AR)</label>
                    <textarea name="overview_ar" rows="4" class="form-input resize-none" dir="rtl">{{ old('overview_ar') }}</textarea>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Features (EN)</label>
                    <textarea name="features" rows="4" class="form-input resize-none" placeholder="- Feature 1&#10;- Feature 2">{{ old('features') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Challenges (EN)</label>
                    <textarea name="challenges" rows="4" class="form-input resize-none" placeholder="Challenges faced...">{{ old('challenges') }}</textarea>
                </div>
            </div>
            <div class="mb-6" x-data="{ techs: {{ json_encode(old('technologies', [])) }}, newTech: '' }">
                <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Technologies</label>
                <div class="flex gap-2 mb-2">
                    <input type="text" x-model="newTech" @keydown.enter.prevent="if(newTech.trim()){techs.push(newTech.trim());newTech=''}"
                           class="form-input flex-1" placeholder="Type tech and press Enter...">
                    <button type="button" @click="if(newTech.trim()){techs.push(newTech.trim());newTech=''}" class="btn-primary px-4">Add</button>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(tech, i) in techs" :key="i">
                        <div class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-sm"
                             style="background: rgba(79, 70, 229, 0.1); color: var(--color-accent);">
                            <span x-text="tech"></span>
                            <input type="hidden" :name="'technologies['+i+']'" :value="tech">
                            <button type="button" @click="techs.splice(i, 1)" class="ms-1 opacity-60 hover:opacity-100">×</button>
                        </div>
                    </template>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Category *</label>
                    <select name="category" class="form-input" required>
                        <option value="web" {{ old('category') === 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ old('category') === 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="api" {{ old('category') === 'api' ? 'selected' : '' }}>API</option>
                        <option value="desktop" {{ old('category') === 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">GitHub Link</label>
                    <input type="url" name="github_link" value="{{ old('github_link') }}" class="form-input" placeholder="https://github.com/...">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Demo Link</label>
                    <input type="url" name="demo_link" value="{{ old('demo_link') }}" class="form-input" placeholder="https://...">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*" class="form-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-heading);">Gallery Images</label>
                    <input type="file" name="gallery[]" accept="image/*" multiple class="form-input">
                </div>
            </div>
            <div class="flex items-center gap-3 mb-6">
                <input type="checkbox" name="featured" id="featured" value="1" class="w-4 h-4" {{ old('featured') ? 'checked' : '' }}>
                <label for="featured" class="text-sm font-medium" style="color: var(--color-heading);">{{ __('dashboard.featured') }}</label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> {{ __('dashboard.save') }}</button>
                <a href="{{ route('admin.projects.index') }}" class="btn-secondary">{{ __('dashboard.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
