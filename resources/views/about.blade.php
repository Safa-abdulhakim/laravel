@extends('layouts.app')
@section('title', __('app.about'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="fw-bold">{{ __('app.about_title') }}</h1>
                <p class="lead text-muted">{{ __('app.about_subtitle') }}</p>
            </div>
            <div class="card p-5 mb-4">
                <h4 class="fw-bold mb-3">{{ __('app.our_mission') }}</h4>
                <p class="text-muted">{{ __('app.mission_text1') }}</p>
                <p class="text-muted mb-0">{{ __('app.mission_text2') }}</p>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-map fs-1 text-primary mb-3"></i>
                        <h6 class="fw-semibold">{{ __('app.structured_paths') }}</h6>
                        <p class="text-muted small mb-0">{{ __('app.structured_paths_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-graph-up fs-1 text-success mb-3"></i>
                        <h6 class="fw-semibold">{{ __('app.progress_tracking') }}</h6>
                        <p class="text-muted small mb-0">{{ __('app.progress_tracking_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-trophy fs-1 text-warning mb-3"></i>
                        <h6 class="fw-semibold">{{ __('app.achievements_feature') }}</h6>
                        <p class="text-muted small mb-0">{{ __('app.achievements_feature_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
