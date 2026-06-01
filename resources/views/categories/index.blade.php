@extends('layouts.main')
@section('title', __('nav_categories'))
@section('content')

<div class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-white mb-2">{{ __('categories_page_title') }}</h1>
            <p class="text-muted">{{ __('categories_page_subtitle') }}</p>
        </div>
        <div class="row g-4">
            @php
            $icons = ['Writing'=>'pencil-square','Coding'=>'code-slash','Marketing'=>'megaphone','Design'=>'palette','Education'=>'book-half'];
            $gradients = [
                'Writing' => 'linear-gradient(135deg,rgba(16,185,129,0.15),rgba(16,185,129,0.05))',
                'Coding' => 'linear-gradient(135deg,rgba(66,133,244,0.15),rgba(66,133,244,0.05))',
                'Marketing' => 'linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05))',
                'Design' => 'linear-gradient(135deg,rgba(236,72,153,0.15),rgba(236,72,153,0.05))',
                'Education' => 'linear-gradient(135deg,rgba(6,182,212,0.15),rgba(6,182,212,0.05))',
            ];
            $colors = ['Writing'=>'#10b981','Coding'=>'#4285f4','Marketing'=>'#f59e0b','Design'=>'#ec4899','Education'=>'#06b6d4'];
            @endphp
            @foreach($categories as $category)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card-dark p-4" style="background:{{ $gradients[$category->name] ?? 'var(--card-bg)' }}">
                        @php $icon = $icons[$category->name] ?? 'lightning'; $color = $colors[$category->name] ?? '#7c3aed'; @endphp
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;background:rgba(0,0,0,0.2)">
                                <i class="bi bi-{{ $icon }} fs-4" style="color:{{ $color }}"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-white mb-0">{{ $category->name }}</h5>
                                <small style="color:{{ $color }}">{{ __('prompts_in_category', ['count' => $category->prompts_count]) }}</small>
                            </div>
                        </div>
                        @if($category->description)
                            <p class="text-muted small mb-0">{{ $category->description }}</p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
