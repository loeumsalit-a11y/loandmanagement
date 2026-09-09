<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Build Bright University</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f1c2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .login-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-card card shadow-lg">
        <div class="login-header">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo" onerror="this.style.display='none'">
            <h4 class="mb-0">Build Bright University</h4>
            <small class="opacity-75">Mini Loan Management System</small>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-3"><i class="bi bi-box-arrow-in-right me-2"></i>Login</h5>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </div>

                <div class="text-center">
                    <span class="text-muted">មិនទាន់មានគណនី?</span>
                    <a href="{{ route('register') }}" class="fw-semibold">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
