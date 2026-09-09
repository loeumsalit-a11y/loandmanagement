<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Build Bright University</title>
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
        .register-card {
            max-width: 450px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #198754, #157347);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .register-header img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="register-card card shadow-lg">
        <div class="register-header">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo" onerror="this.style.display='none'">
            <h4 class="mb-0">Build Bright University</h4>
            <small class="opacity-75">បង្កើតគណនីថ្មី</small>
        </div>
        <div class="card-body p-4">
            <h5 class="text-center mb-3"><i class="bi bi-person-plus me-2"></i>Register</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" placeholder="Your full name" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" placeholder="you@example.com" required>
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

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Register
                    </button>
                </div>

                <div class="text-center">
                    <span class="text-muted">មានគណនីរួចហើយ?</span>
                    <a href="{{ route('login') }}" class="fw-semibold">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
