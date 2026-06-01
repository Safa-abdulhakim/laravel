@extends('layouts.app')
@section('title', __('app.contact'))
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-5">
                <h1 class="fw-bold">{{ __('app.contact_title') }}</h1>
                <p class="text-muted">{{ __('app.contact_subtitle') }}</p>
            </div>
            <div class="card p-4">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('app.your_name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.email') }}</label>
                        <input type="email" class="form-control" placeholder="{{ __('app.your_email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('app.message') }}</label>
                        <textarea class="form-control" rows="5" placeholder="{{ __('app.your_message') }}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('app.send_message') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
