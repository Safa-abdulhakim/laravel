<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopLaravel') - Simple E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .cart-badge { position: absolute; top: -6px; right: -6px; font-size: .65rem; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; }
        .nav-cart-icon { position: relative; }
        .product-card { transition: transform .2s,box-shadow .2s; border: none; box-shadow: 0 2px 8px rgba(0,0,0,.07); }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
        .product-card img { height: 220px; object-fit: cover; }
        footer { background: #212529; color: #adb5bd; }
        footer a { color: #adb5bd; text-decoration: none; }
        footer a:hover { color: #fff; }
    </style>
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-shop-window me-2 text-primary"></i>ShopLaravel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Shop</a></li>
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link nav-cart-icon" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-5"></i>
                        @php $cartCount = \App\Http\Controllers\CartController::cartCount(); @endphp
                        @if($cartCount > 0)<span class="badge rounded-pill bg-danger cart-badge">{{ $cartCount }}</span>@endif
                    </a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link text-warning" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-lock me-1"></i>Admin</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('orders.my') }}"><i class="bi bi-box me-1"></i>My Orders</a></li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form method="POST" action="{{ route('logout') }}">@csrf<button class="dropdown-item text-danger" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
@if(session('success') || session('error') || session('warning'))
<div class="container mt-3">
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show d-flex align-items-center"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button></div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button></div>@endif
    @if(session('warning'))<div class="alert alert-warning alert-dismissible fade show d-flex align-items-center"><i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('warning') }}<button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button></div>@endif
</div>
@endif
<main>@yield('content')</main>
<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5 class="text-white mb-3"><i class="bi bi-shop-window me-2 text-primary"></i>ShopLaravel</h5><p class="small">Your trusted online store. Quality products, great prices.</p></div>
            <div class="col-md-2"><h6 class="text-white mb-3">Shop</h6><ul class="list-unstyled small"><li class="mb-2"><a href="{{ route('products.index') }}">All Products</a></li><li class="mb-2"><a href="{{ route('cart.index') }}">Cart</a></li></ul></div>
            <div class="col-md-2"><h6 class="text-white mb-3">Account</h6><ul class="list-unstyled small">@auth<li class="mb-2"><a href="{{ route('orders.my') }}">My Orders</a></li>@else<li class="mb-2"><a href="{{ route('login') }}">Login</a></li><li class="mb-2"><a href="{{ route('register') }}">Register</a></li>@endauth</ul></div>
            <div class="col-md-4"><h6 class="text-white mb-3">Contact</h6><p class="small mb-1"><i class="bi bi-envelope me-2"></i>support@shoplaravel.com</p><p class="small"><i class="bi bi-telephone me-2"></i>+1 (555) 000-1234</p></div>
        </div>
        <hr class="border-secondary my-4">
        <p class="text-center small mb-0">&copy; {{ date('Y') }} ShopLaravel. Built with Laravel &amp; Bootstrap 5.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
