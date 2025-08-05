<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Contractor Login - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --contractor-primary: #F3B374;
            --contractor-secondary: #FFF1D4;
            --contractor-dark: #233240;
            --contractor-light: #FFF1D4;
            --contractor-accent: #F3B374;
        }

        /* Contractor Theme Login Page */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--contractor-secondary) 0%, var(--contractor-light) 100%);
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease;
        }

        /* Subtle Animated Background Elements */
        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--contractor-primary) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: float 30s ease-in-out infinite;
            z-index: 1;
            opacity: 0.1;
        }

        .login-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 40%, var(--contractor-primary) 50%, transparent 60%);
            animation: shimmer 4s ease-in-out infinite;
            z-index: 2;
            opacity: 0.05;
        }

        /* Floating Orbs with Contractor Theme Colors */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            backdrop-filter: blur(10px);
            animation: float-orb 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 120px;
            height: 120px;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
            background: var(--contractor-primary);
            opacity: 0.1;
        }

        .orb-2 {
            width: 180px;
            height: 180px;
            top: 55%;
            right: 15%;
            animation-delay: 3s;
            background: var(--contractor-dark);
            opacity: 0.08;
        }

        .orb-3 {
            width: 90px;
            height: 90px;
            bottom: 20%;
            left: 25%;
            animation-delay: 6s;
            background: var(--contractor-accent);
            opacity: 0.12;
        }

        .login-card {
            background-color: white;
            border: 1px solid rgba(35, 50, 64, 0.1);
            border-radius: 16px;
            box-shadow: 
                0 20px 25px -5px rgba(35, 50, 64, 0.1),
                0 10px 10px -5px rgba(35, 50, 64, 0.04);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(243, 179, 116, 0.3);
        }

        .login-logo i {
            font-size: 1.8rem;
            color: white;
        }
        
        .login-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--contractor-dark);
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #6B7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Contractor Theme Form Styles */
        .form-label {
            color: var(--contractor-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control {
            background-color: white;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            color: var(--contractor-dark);
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--contractor-primary);
            box-shadow: 0 0 0 3px rgba(243, 179, 116, 0.1);
        }

        .form-control::placeholder {
            color: #9CA3AF;
        }

        /* Contractor Theme Button */
        .btn-contractor {
            background: linear-gradient(135deg, var(--contractor-primary), var(--contractor-accent));
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-contractor:hover {
            background: linear-gradient(135deg, #E5A066, #F3B374);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(243, 179, 116, 0.3);
        }

        /* Contractor Theme Checkbox */
        .form-check-input {
            border-radius: 4px;
            border: 2px solid #E5E7EB;
            background-color: white;
        }

        .form-check-input:checked {
            background-color: var(--contractor-primary);
            border-color: var(--contractor-primary);
        }

        .form-check-input:focus {
            border-color: var(--contractor-primary);
            box-shadow: 0 0 0 3px rgba(243, 179, 116, 0.1);
        }

        .form-check-label {
            color: var(--contractor-dark);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Contractor Theme Alert */
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #DC2626;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Footer text */
        .login-footer {
            color: #6B7280;
            font-size: 0.75rem;
        }

        /* Register link */
        .register-link {
            color: var(--contractor-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .register-link:hover {
            color: var(--contractor-dark);
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(180deg); }
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        @keyframes float-orb {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        /* Loading State */
        .btn-contractor.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                margin: 1rem;
                padding: 2rem;
                max-width: 100%;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .orb-1, .orb-2, .orb-3 {
                display: none;
            }
        }

        /* Entrance Animation */
        .login-card-animated {
            opacity: 0;
            transform: translateY(30px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Floating Orbs -->
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-person-badge"></i>
                </div>
                <h1 class="login-title">Contractor Login</h1>
                <p class="login-subtitle">Sign in to your contractor account</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('contractor.login') }}" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input 
                        type="tel" 
                        class="form-control @error('phone') is-invalid @enderror" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        autocomplete="tel" 
                        autofocus
                        placeholder="Enter your 10-digit phone number"
                        maxlength="10"
                        pattern="[0-9]{10}"
                    >
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-contractor w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Sign In
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="login-footer">
                    Don't have an account? 
                    <a href="{{ route('contractor.register') }}" class="register-link">Register here</a>
                </p>
                <small class="text-muted">
                    © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced Login Page Interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.querySelector('.btn-contractor');
            const phoneInput = document.getElementById('phone');
            
            // Phone number validation
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
            
            // Add loading state to button on form submit
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Signing In...';
            });
            
            // Add focus effects to form inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Parallax effect for floating orbs
            document.addEventListener('mousemove', function(e) {
                const orbs = document.querySelectorAll('.floating-orb');
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                orbs.forEach((orb, index) => {
                    const speed = (index + 1) * 0.5;
                    const x = (mouseX - 0.5) * speed * 20;
                    const y = (mouseY - 0.5) * speed * 20;
                    orb.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
            
            // Add entrance animation
            const loginCard = document.querySelector('.login-card');
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                loginCard.style.transition = 'all 0.6s ease';
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html> 