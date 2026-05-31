@extends('layouts.admin')
@section('title', 'Create Resource')
@section('page-title', 'Create Learning Resource')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.resources.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Skill <span class="text-danger">*</span></label>
                            <select name="skill_id" class="form-select" required>
                                <option value="">Select Skill</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ (old('skill_id', request('skill_id')) == $skill->id) ? 'selected' : '' }}>{{ $skill->stage->careerPath->title }} › {{ $skill->stage->title }} › {{ $skill->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                @foreach(['Article','Video','Course','Documentation'] as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Provider</label>
                            <input type="text" name="provider" class="form-control" value="{{ old('provider') }}" placeholder="e.g. YouTube, Udemy">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">URL <span class="text-danger">*</span></label>
                            <input type="url" name="url" class="form-control" value="{{ old('url') }}" required>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Create Resource</button>
                                <a href="{{ route('admin.resources.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
