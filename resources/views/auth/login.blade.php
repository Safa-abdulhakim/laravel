<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,.4);
        }
        .form-control {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            border-radius: 10px;
            padding: .75rem 1rem;
        }
        .form-control:focus {
            background: rgba(255,255,255,.1);
            border-color: #6366f1;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,.2);
        }
        .form-control::placeholder { color: rgba(255,255,255,.3); }
        .form-label { color: rgba(255,255,255,.7); font-weight: 500; font-size: .875rem; }
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; border-radius: 10px;
            color: #fff; font-weight: 600;
            padding: .8rem; width: 100%;
            transition: all .3s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,102,241,.4); color: #fff; }
        .input-group-text {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.4);
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <div class="mb-3">
            <span style="font-size:1.8rem;font-weight:800;color:#fff;">
                <span style="color:#6366f1">&lt;</span>Portfolio<span style="color:#6366f1">/&gt;</span>
            </span>
        </div>
        <h5 class="text-white fw-bold mb-1">Admin Login</h5>
        <p class="text-white-50 small">Sign in to manage your portfolio</p>
    </div>

    @if(session('status'))
        <div class="alert alert-info mb-3 py-2 small">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3 py-2 small">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                       placeholder="admin@portfolio.com" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                <input type="password" name="password"
                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                       placeholder="Your password" required>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label text-white-50 small" for="remember">Remember me</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small"
                   style="color:#818cf8;">Forgot password?</a>
            @endif
        </div>
        <button type="submit" class="btn btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-white-50 small text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Back to Portfolio
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
