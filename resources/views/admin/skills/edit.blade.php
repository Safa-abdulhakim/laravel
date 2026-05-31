@extends('layouts.admin')
@section('title', 'Edit Skill')
@section('page-title', 'Edit Skill: ' . $skill->title)
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $skill->title) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $skill->description) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Difficulty</label>
                            <select name="difficulty" class="form-select" required>
                                @foreach(['Beginner','Intermediate','Advanced'] as $d)
                                    <option value="{{ $d }}" {{ old('difficulty', $skill->difficulty) == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Hours</label>
                            <input type="number" name="estimated_hours" class="form-control" value="{{ old('estimated_hours', $skill->estimated_hours) }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Order</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $skill->order) }}" min="0">
                        </div>
                        <div class="col-12 pt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Skill</button>
                                <a href="{{ route('admin.stages.show', $skill->stage_id) }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
