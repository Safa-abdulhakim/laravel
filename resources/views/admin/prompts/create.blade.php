@extends('layouts.dashboard')
@section('title', __('new_prompt_title'))
@section('page-title', __('new_prompt_title'))
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-dark p-4">
            <h5 class="fw-bold text-white mb-4">
                <i class="bi bi-plus-circle me-2" style="color:#7c3aed"></i>{{ __('new_prompt_title') }}
                <span class="badge ms-2" style="background:rgba(124,58,237,0.2);color:#a78bfa;font-size:0.75rem;border-radius:8px;">{{ __('admin_badge') }}</span>
            </h5>
            <form method="POST" action="{{ route('admin.prompts.store') }}">
                @csrf
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">{{ __('title_label') }} <span style="color:#ef4444">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="form-control form-control-dark @error('title') is-invalid @enderror"
                            placeholder="{{ __('title_placeholder') }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('content_label') }} <span style="color:#ef4444">*</span></label>
                        <textarea name="prompt_content" rows="8"
                            class="form-control form-control-dark @error('prompt_content') is-invalid @enderror"
                            placeholder="Write your prompt here...&#10;&#10;Use [BRACKETS] for variables.">{{ old('prompt_content') }}</textarea>
                        @error('prompt_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('platform_label') }} <span style="color:#ef4444">*</span></label>
                        <select name="platform" class="form-select form-select-dark @error('platform') is-invalid @enderror">
                            @foreach($platforms as $p)
                                <option value="{{ $p }}" {{ old('platform') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('category_label') }}</label>
                        <select name="category_id" class="form-select form-select-dark">
                            <option value="">{{ __('no_category') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('status') }} <span style="color:#ef4444">*</span></label>
                        <select name="status" class="form-select form-select-dark @error('status') is-invalid @enderror">
                            <option value="public"  {{ old('status','public')  == 'public'  ? 'selected' : '' }}>{{ __('status_public') }}</option>
                            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>{{ __('status_private') }}</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('tags_label') }}</label>
                        <div class="d-flex flex-wrap gap-3 p-3" style="background:#0f172a;border:2px solid #334155;border-radius:10px;">
                            @foreach($tags as $tag)
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                        style="accent-color:#7c3aed">
                                    <span style="font-size:0.85rem;color:#94a3b8">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="d-flex align-items-center gap-2" style="cursor:pointer">
                            <input type="checkbox" name="favorite" value="1"
                                {{ old('favorite') ? 'checked' : '' }}
                                style="accent-color:#ef4444;width:18px;height:18px;">
                            <span class="text-muted"><i class="bi bi-heart me-1" style="color:#ef4444"></i>{{ __('mark_favorite') }}</span>
                        </label>
                    </div>
                    <div class="col-12 d-flex gap-3 pt-2">
                        <button type="submit" class="btn btn-gradient px-4">
                            <i class="bi bi-check2 me-2"></i>{{ __('create_prompt_btn') }}
                        </button>
                        <a href="{{ route('admin.prompts.index') }}" class="btn"
                            style="background:rgba(148,163,184,0.1);color:#94a3b8;border:1px solid #334155;border-radius:10px;padding:10px 20px;">{{ __('cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
