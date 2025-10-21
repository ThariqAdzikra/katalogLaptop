{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laptop Store') }} - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #021024;
            --primary-navy: #052659;
            --primary-blue: #5483B3;
            --primary-sky: #7DA0CA;
            --primary-light: #C1E8FF;
            --text-dark: #1a202c;
            --text-gray: #64748b;
            --border-light: #e2e8f0;
        }

        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/images/hero.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            z-index: 0;
        }

        .auth-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .auth-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 20%, rgba(193, 232, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(125, 160, 202, 0.15) 0%, transparent 50%);
        }

        .auth-illustration {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        .auth-right {
            width: 480px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 3rem 2rem;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo i {
            font-size: 3rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
        }

        .auth-logo h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .auth-logo p {
            font-size: 0.95rem;
            color: var(--text-gray);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(84, 131, 179, 0.1);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary-blue);
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background: var(--primary-blue);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-navy);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 38, 89, 0.2);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.25rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-light);
        }

        .divider span {
            padding: 0 1rem;
            color: var(--text-gray);
            font-size: 0.85rem;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .btn-social {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .btn-social:hover {
            background: #f8fafc;
            border-color: var(--primary-blue);
        }

        .btn-social.google { color: #EA4335; }
        .btn-social.apple { color: #000000; }
        .btn-social.github { color: #181717; }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-footer p {
            font-size: 0.9rem;
            color: var(--text-gray);
        }

        .auth-footer a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: var(--primary-navy);
        }

        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #ffffff;
            color: var(--primary-navy);
            transform: translateY(-2px);
        }

        .terms-text {
            font-size: 0.85rem;
            color: var(--text-gray);
            text-align: center;
            margin-top: 1rem;
        }

        .terms-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .terms-text a:hover {
            color: var(--primary-navy);
        }

        @media (max-width: 992px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .auth-right {
                padding: 2rem 1.5rem;
            }

            .back-home {
                top: 1rem;
                left: 1rem;
            }

            .auth-logo h4 {
                font-size: 1.3rem;
            }
        }

        ::selection {
            background: var(--primary-light);
            color: var(--primary-navy);
        }
    </style>
</head>
<body>
    <div class="back-home">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Back to Home
        </a>
    </div>

    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-illustration">
                <div style="text-align: center; color: #ffffff;">
                    <i class="bi bi-laptop" style="font-size: 8rem; margin-bottom: 2rem; display: block; opacity: 0.9;"></i>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Join Us Today!</h2>
                    <p style="font-size: 1.1rem; opacity: 0.9; max-width: 400px; margin: 0 auto;">
                        Create your account and start exploring our amazing collection of premium laptops.
                    </p>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <div class="auth-card">
                <div class="auth-logo">
                    <i class="bi bi-laptop"></i>
                    <h4>Create your account</h4>
                    <p>Sign up to get started with Laptop Store</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" 
                               type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="John Doe">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" 
                               type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder="your.email@example.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Create a strong password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="bi bi-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input id="password_confirmation" 
                                   type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Re-enter your password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="bi bi-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary">
                        Create Account
                    </button>

                    <div class="terms-text">
                        By creating an account, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </div>
                </form>

                <div class="divider">
                    <span>or sign up with</span>
                </div>

                <div class="social-login">
                    <button type="button" class="btn-social google">
                        <i class="bi bi-google"></i>
                    </button>
                    <button type="button" class="btn-social apple">
                        <i class="bi bi-apple"></i>
                    </button>
                    <button type="button" class="btn-social github">
                        <i class="bi bi-github"></i>
                    </button>
                </div>

                <div class="auth-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>