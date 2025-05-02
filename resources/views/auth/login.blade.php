<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Arjuna Trans') }} - Login</title>
    <meta name="description" content="Login to your account">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/libs/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/owl.carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet">

    <style>
        :root {
            --primary-color: #FF6500;
            --primary-dark: #E05A00;
            --secondary-color: #2D3748;
            --accent-color: #4A5568;
            --light-color: #F7FAFC;
            --dark-color: #1A202C;
            --text-color: #2D3748;
            /* Atau pakai --accent-color jika lebih cocok */
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        .auth-container {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .auth-left-panel {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd' opacity='0.2'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .auth-right-panel {
            background-color: var(--light-color);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.03);
        }

        .auth-logo {
            margin-bottom: 2.5rem;
            transition: transform 0.3s ease;
        }

        .auth-logo:hover {
            transform: scale(1.05);
        }

        .auth-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .auth-subtitle {
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 0.35rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--accent-color);
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 101, 0, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .forgot-password {
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: none;
        }

        .remember-me {
            user-select: none;
        }

        .footer-text {
            font-size: 0.85rem;
            color: #858796;
        }

        /* Illustration styles */
        .auth-illustration {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        /* Responsive adjustments */
        @media (max-width: 1199.98px) {
            .auth-left-panel {
                display: none;
            }

            .auth-right-panel {
                width: 100%;
                max-width: 500px;
                margin: 0 auto;
                box-shadow: none;
            }
        }

        @media (max-width: 575.98px) {
            .auth-right-panel {
                padding: 1.5rem;
            }

            .auth-logo {
                margin-bottom: 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-content {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="row g-0 h-100">
            <!-- Left Panel (Illustration) -->
            <div class="col-lg-9 d-none d-lg-flex auth-left-panel">
                <div class="position-relative z-index-1 w-100 h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center px-4">
                        <img src="{{ asset('assets/images/arjuna-logo.png') }}" alt="Login Illustration" class="auth-illustration mb-4" style="max-height: 300px;">
                        <h2 class="text-white mb-3">Selamat Datang di Arjuna Trans</h2>
                        <p class="text-white-50">Sistem Manajemen Transportasi Terintegrasi</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Login Form) -->
            <div class="col-lg-3 auth-right-panel">
                <div class="auth-content">
                    <div class="text-center mb-4 mb-md-5">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <img src="{{ asset('assets/images/arjuna-logo.png') }}" alt="Arjuna Trans Logo" height="60">
                        </a>
                    </div>

                    <div class="mb-4">
                        <h1 class="auth-title text-center">Selamat Datang!</h1>
                        <p class="auth-subtitle text-center">Silahkan masuk untuk melanjutkan ke {{ config('app.name') }}</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Masukkan email Anda">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password">Lupa password?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                                <button class="btn btn-outline-secondary password-toggle" type="button" id="password-addon">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label remember-me" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="footer-text">©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> {{ config('app.name') }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Toggle password visibility with better UX
        document.getElementById('password-addon').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('mdi-eye-outline', 'mdi-eye-off-outline');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('mdi-eye-off-outline', 'mdi-eye-outline');
            }
        });

        // Add focus styles for better accessibility
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>

</html>
