@extends('layouts.app')
@section('title', 'About')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="fw-bold">About CareerMap</h1>
                <p class="lead text-muted">Empowering professionals to navigate their career journey with clarity and purpose.</p>
            </div>
            <div class="card p-5 mb-4">
                <h4 class="fw-bold mb-3">Our Mission</h4>
                <p class="text-muted">CareerMap was built to help aspiring professionals transform their career ambitions into actionable steps. We believe that every career journey becomes more achievable when it's broken down into clear, manageable milestones.</p>
                <p class="text-muted mb-0">Our platform provides structured roadmaps across various technical fields, allowing you to track your progress, access curated learning resources, and celebrate your achievements along the way.</p>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-map fs-1 text-primary mb-3"></i>
                        <h6 class="fw-semibold">Structured Paths</h6>
                        <p class="text-muted small mb-0">Curated roadmaps designed by industry professionals.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-graph-up fs-1 text-success mb-3"></i>
                        <h6 class="fw-semibold">Progress Tracking</h6>
                        <p class="text-muted small mb-0">Visualize your learning journey with real-time progress.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card p-4 h-100">
                        <i class="bi bi-trophy fs-1 text-warning mb-3"></i>
                        <h6 class="fw-semibold">Achievements</h6>
                        <p class="text-muted small mb-0">Earn badges as you reach important milestones.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
