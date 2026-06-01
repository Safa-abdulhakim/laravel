@extends('layouts.portfolio')
@section('title', __('portfolio.contact_title'))

@section('content')
<div style="padding-top:76px;background:linear-gradient(135deg,#0f172a,#1e1b4b);">
    <div class="container py-5 text-center">
        <span class="section-badge" style="background:rgba(99,102,241,.15);color:#818cf8;">{{ __('portfolio.contact_badge') }}</span>
        <h1 class="section-title mt-2" style="color:#fff;">{{ __('portfolio.contact_title') }}</h1>
        <p class="text-white-50">{{ __('portfolio.contact_sub') }}</p>
    </div>
</div>

<section>
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-4">
                <div class="fade-up">
                    <h5 class="fw-bold mb-4">{{ __('portfolio.contact_lets_talk') }}</h5>
                    <p class="text-muted mb-4" style="line-height:1.8;">
                        {{ __('portfolio.contact_intro') }}
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f8fafc;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:44px;height:44px;background:#eef2ff;flex-shrink:0;">
                                <i class="bi bi-envelope text-primary fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-medium small">{{ __('portfolio.contact_email') }}</div>
                                <a href="mailto:john@example.com" class="text-muted small text-decoration-none">
                                    john@example.com
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f8fafc;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:44px;height:44px;background:#d1fae5;flex-shrink:0;">
                                <i class="bi bi-geo-alt text-success fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-medium small">{{ __('portfolio.contact_location') }}</div>
                                <div class="text-muted small">{{ __('portfolio.contact_location_val') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#f8fafc;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:44px;height:44px;background:#fef3c7;flex-shrink:0;">
                                <i class="bi bi-clock text-warning fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-medium small">{{ __('portfolio.contact_response') }}</div>
                                <div class="text-muted small">{{ __('portfolio.contact_response_val') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="fw-medium mb-2 small text-muted text-uppercase" style="letter-spacing:.06em;">
                            {{ __('portfolio.contact_follow') }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-dark rounded-circle"
                               style="width:38px;height:38px;padding:0;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="#" class="btn btn-sm rounded-circle text-white"
                               style="width:38px;height:38px;padding:0;background:#0a66c2;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-sm rounded-circle text-white"
                               style="width:38px;height:38px;padding:0;background:#1da1f2;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 fade-up">
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="contact-form-wrap">
                    <h5 class="fw-bold mb-4">{{ __('portfolio.contact_form_title') }}</h5>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">
                                    {{ __('portfolio.contact_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="{{ __('portfolio.contact_name_ph') }}">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium small">
                                    {{ __('portfolio.contact_email') }} <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="{{ __('portfolio.contact_email_ph') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium small">{{ __('portfolio.contact_subject') }}</label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                   class="form-control"
                                   placeholder="{{ __('portfolio.contact_subject_ph') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium small">
                                {{ __('portfolio.contact_message') }} <span class="text-danger">*</span>
                            </label>
                            <textarea name="message" rows="6"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="{{ __('portfolio.contact_message_ph') }}">{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">
                            <i class="bi bi-send me-2"></i>{{ __('portfolio.contact_send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
