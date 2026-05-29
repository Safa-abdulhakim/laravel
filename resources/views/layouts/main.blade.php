<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Prompt Organizer') - AI Prompts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #4f46e5;
            --secondary: #06b6d4;
            --dark: #0f172a;
            --darker: #020617;
            --card-bg: #1e293b;
            --border: #334155;
            --text-muted: #94a3b8;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: var(--dark); color: #e2e8f0; }

        .navbar-brand { font-weight: 800; font-size: 1.4rem; }
        .navbar-brand span { background: linear-gradient(135deg, #7c3aed, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .navbar { background: rgba(15,23,42,0.95) !important; backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); }
        .navbar .nav-link { color: #94a3b8 !important; font-weight: 500; transition: color 0.2s; }
        .navbar .nav-link:hover { color: #7c3aed !important; }

        .hero-section { background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%); padding: 80px 0; position: relative; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 60%); }
        .hero-title { font-size: 3.5rem; font-weight: 800; background: linear-gradient(135deg, #ffffff, #a78bfa, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1.1; }
        .hero-subtitle { font-size: 1.25rem; color: #94a3b8; }
        .btn-gradient { background: linear-gradient(135deg, #7c3aed, #4f46e5); border: none; color: white; font-weight: 600; padding: 12px 28px; border-radius: 10px; transition: all 0.3s; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(124,58,237,0.4); color: white; }
        .btn-outline-gradient { border: 2px solid #7c3aed; color: #a78bfa; background: transparent; font-weight: 600; padding: 12px 28px; border-radius: 10px; transition: all 0.3s; }
        .btn-outline-gradient:hover { background: rgba(124,58,237,0.1); color: #a78bfa; }

        .card-dark { background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px; transition: all 0.3s; }
        .card-dark:hover { border-color: #7c3aed; transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }

        .prompt-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px; transition: all 0.3s; overflow: hidden; }
        .prompt-card:hover { border-color: #7c3aed; transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .prompt-card .card-body { padding: 1.5rem; }
        .platform-badge { font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
        .platform-chatgpt { background: rgba(16,163,127,0.15); color: #10a37f; border: 1px solid rgba(16,163,127,0.3); }
        .platform-claude { background: rgba(212,137,76,0.15); color: #d4894c; border: 1px solid rgba(212,137,76,0.3); }
        .platform-gemini { background: rgba(66,133,244,0.15); color: #4285f4; border: 1px solid rgba(66,133,244,0.3); }
        .platform-midjourney { background: rgba(124,58,237,0.15); color: #a78bfa; border: 1px solid rgba(124,58,237,0.3); }
        .platform-other { background: rgba(148,163,184,0.15); color: #94a3b8; border: 1px solid rgba(148,163,184,0.3); }

        .tag-pill { background: rgba(124,58,237,0.15); color: #a78bfa; border: 1px solid rgba(124,58,237,0.3); font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; text-decoration: none; transition: all 0.2s; display: inline-block; margin: 2px; }
        .tag-pill:hover { background: rgba(124,58,237,0.3); color: #c4b5fd; }

        .stat-card { background: linear-gradient(135deg, var(--card-bg), rgba(124,58,237,0.1)); border: 1px solid var(--border); border-radius: 16px; padding: 1.5rem; text-align: center; }
        .stat-number { font-size: 2.5rem; font-weight: 800; background: linear-gradient(135deg, #7c3aed, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .search-bar { background: var(--card-bg); border: 2px solid var(--border); border-radius: 14px; padding: 12px 20px; color: #e2e8f0; font-size: 1rem; transition: border-color 0.3s; width: 100%; }
        .search-bar:focus { border-color: #7c3aed; outline: none; box-shadow: 0 0 0 4px rgba(124,58,237,0.1); background: var(--card-bg); color: #e2e8f0; }
        .search-bar::placeholder { color: #64748b; }

        .form-select-dark { background: var(--card-bg); border: 2px solid var(--border); color: #e2e8f0; border-radius: 10px; }
        .form-select-dark:focus { border-color: #7c3aed; box-shadow: 0 0 0 4px rgba(124,58,237,0.1); background: var(--card-bg); color: #e2e8f0; }
        .form-select-dark option { background: #1e293b; }

        footer { background: var(--darker); border-top: 1px solid var(--border); padding: 40px 0 20px; }

        .copy-btn { cursor: pointer; transition: all 0.2s; }
        .copy-btn:active { transform: scale(0.95); }

        .pagination .page-link { background: var(--card-bg); border-color: var(--border); color: #94a3b8; }
        .pagination .page-link:hover { background: rgba(124,58,237,0.2); border-color: #7c3aed; color: #a78bfa; }
        .pagination .active .page-link { background: #7c3aed; border-color: #7c3aed; color: white; }

        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10b981; border-radius: 10px; }
        .alert-danger { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; border-radius: 10px; }

        @media (max-width: 768px) { .hero-title { font-size: 2.2rem; } }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-charge-fill text-purple me-2" style="color:#7c3aed"></i>
                <span>AI Prompt Organizer</span>
            </a>
            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('prompts.index') }}">Prompts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-check me-1" style="color:#f59e0b"></i>Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="background:#1e293b;border-color:#334155;">
                                <li><a class="dropdown-item text-light" href="{{ route('dashboard') }}"><i class="bi bi-grid me-2" style="color:#7c3aed"></i>Dashboard</a></li>
                                <li><a class="dropdown-item text-light" href="{{ route('my-prompts.index') }}"><i class="bi bi-collection me-2" style="color:#7c3aed"></i>My Prompts</a></li>
                                <li><a class="dropdown-item text-light" href="{{ route('favorites.index') }}"><i class="bi bi-heart me-2" style="color:#ef4444"></i>Favorites</a></li>
                                <li><hr class="dropdown-divider border-secondary"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-light"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-gradient btn-sm" href="{{ route('register') }}">Get Started</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 76px;">
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-2"><span style="background:linear-gradient(135deg,#7c3aed,#06b6d4);-webkit-background-clip:text;-webkit-text-fill-color:transparent">AI Prompt Organizer</span></h5>
                    <p class="text-muted small">Organize, discover, and share AI prompts for ChatGPT, Claude, Gemini, Midjourney and more.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="fw-semibold mb-3 text-light">Explore</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('prompts.index') }}" class="text-muted text-decoration-none small">All Prompts</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-muted text-decoration-none small">Categories</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="fw-semibold mb-3 text-light">Account</h6>
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-muted text-decoration-none small">Dashboard</a></li>
                            <li><a href="{{ route('my-prompts.create') }}" class="text-muted text-decoration-none small">Add Prompt</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-muted text-decoration-none small">Login</a></li>
                            <li><a href="{{ route('register') }}" class="text-muted text-decoration-none small">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="fw-semibold mb-3 text-light">Platforms</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['ChatGPT','Claude','Gemini','Midjourney','Other'] as $p)
                            <a href="{{ route('prompts.index', ['platform' => $p]) }}" class="platform-badge platform-{{ strtolower($p) }}">{{ $p }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-2">
            <p class="text-center text-muted small mb-0">&copy; {{ date('Y') }} AI Prompt Organizer. Built with Laravel 11.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy to clipboard
        function copyPrompt(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check2 me-1"></i>Copied!';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-outline-secondary');
                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-secondary');
                }, 2000);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
