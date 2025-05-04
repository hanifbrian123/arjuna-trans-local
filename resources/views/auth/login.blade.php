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
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            margin: 0;
            background-color: #fff;
            color: var(--text-color);
        }

        .auth-container {
            height: 100%;
            display: flex;
            flex-direction: row;
        }

        .auth-left-panel {
            background-image: url("{{ asset('assets/images/auth-cover.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-right-panel {
            background-color: #fff;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-logo {
            margin-bottom: 1.5rem;
            max-width: 80px;
        }

        .auth-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .auth-subtitle {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .form-control {
            border-radius: 0.35rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 101, 0, 0.1);
        }

        .btn-primary {
            background-color: #4361ee;
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.3s;
            border-radius: 0.35rem;
        }

        .btn-primary:hover {
            background-color: #3a56d4;
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .password-toggle {
            cursor: pointer;
            transition: color 0.3s;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
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

        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .input-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #333;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .auth-left-panel {
                display: none;
            }

            .auth-right-panel {
                width: 100%;
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
        <!-- Left Panel (Background Image) -->
        <div class="col-lg-8 auth-left-panel">
            <!-- Background image is set via CSS -->
        </div>

        <!-- Right Panel (Login Form) -->
        <div class="col-lg-4 auth-right-panel">
            <div class="auth-content">
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="d-inline-block">
                        <img src="{{ asset('assets/images/arjuna-logo.png') }}" alt="Arjuna Trans Logo" class="auth-logo">
                    </a>
                </div>

                <div class="mb-4">
                    <h4 class="auth-title">Selamat Datang</h4>
                    <p class="auth-subtitle">Silahkan masuk untuk melanjutkan ke {{ config('app.name') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="input-label">Username</label>
                        <div class="input-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="Enter username">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="input-label">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password" placeholder="Enter password">
                            <span class="password-toggle" id="password-addon">
                                <i class="mdi mdi-eye-outline"></i>
                            </span>
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
                            Remember me
                        </label>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            Log in
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="footer-text">© {{ date('Y') }} {{ config('app.name') }} - Design & Develop by CV. Netlab</p>
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
