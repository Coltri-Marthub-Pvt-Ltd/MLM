<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Contractor Registration - {{ config('app.name', 'Laravel') }}</title>

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

        /* Contractor Theme Registration Page */
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--contractor-secondary) 0%, var(--contractor-light) 100%);
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease;
            padding: 2rem 0;
        }

        /* Subtle Animated Background Elements */
        .register-container::before {
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

        .register-container::after {
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

        .register-card {
            background-color: white;
            border: 1px solid rgba(35, 50, 64, 0.1);
            border-radius: 16px;
            box-shadow: 
                0 20px 25px -5px rgba(35, 50, 64, 0.1),
                0 10px 10px -5px rgba(35, 50, 64, 0.04);
            width: 100%;
            max-width: 600px;
            padding: 2.5rem;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .register-logo {
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

        .register-logo i {
            font-size: 1.8rem;
            color: white;
        }
        
        .register-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--contractor-dark);
            margin-bottom: 0.5rem;
        }
        
        .register-subtitle {
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

        /* File upload styling */
        .form-control[type="file"] {
            padding: 0.5rem;
            border: 2px dashed #E5E7EB;
            background-color: #F9FAFB;
            transition: all 0.2s ease;
        }

        .form-control[type="file"]:focus {
            border-color: var(--contractor-primary);
            background-color: white;
        }

        .form-control[type="file"]:hover {
            border-color: var(--contractor-primary);
            background-color: rgba(243, 179, 116, 0.05);
        }

        .form-text {
            color: #6B7280;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid {
            border-color: #DC2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .invalid-feedback {
            color: #DC2626;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.25rem;
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
        .register-footer {
            color: #6B7280;
            font-size: 0.75rem;
        }

        /* Login link */
        .login-link {
            color: var(--contractor-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .login-link:hover {
            color: var(--contractor-dark);
        }

        /* Age requirement notice */
        .age-notice {
            background-color: rgba(243, 179, 116, 0.1);
            border: 1px solid rgba(243, 179, 116, 0.2);
            color: var(--contractor-dark);
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
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
            .register-card {
                margin: 1rem;
                padding: 2rem;
                max-width: 100%;
            }
            
            .register-title {
                font-size: 1.5rem;
            }
            
            .orb-1, .orb-2, .orb-3 {
                display: none;
            }
        }

        /* Entrance Animation */
        .register-card-animated {
            opacity: 0;
            transform: translateY(30px);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Floating Orbs -->
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        
        <div class="register-card">
            <div class="register-header">
                <div class="register-logo">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h1 class="register-title">Contractor Registration</h1>
                <p class="register-subtitle">Create your contractor account</p>
            </div>

            <!-- Age Requirement Notice -->
            <div class="age-notice">
                <i class="bi bi-info-circle me-2"></i>
                You must be at least 18 years old to register as a contractor.
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('contractor.register') }}" id="registerForm" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name *</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            autocomplete="name" 
                            autofocus
                            placeholder="Enter your full name"
                            minlength="2"
                            maxlength="255"
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            autocomplete="email"
                            placeholder="Enter your email address"
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input 
                            type="tel" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            autocomplete="tel"
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

                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                        <input 
                            type="date" 
                            class="form-control @error('date_of_birth') is-invalid @enderror" 
                            id="date_of_birth" 
                            name="date_of_birth" 
                            value="{{ old('date_of_birth') }}" 
                            max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                        >
                        @error('date_of_birth')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Document Information -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="aadhar_card" class="form-label">Aadhar Card Number *</label>
                        <input 
                            type="text" 
                            class="form-control @error('aadhar_card') is-invalid @enderror" 
                            id="aadhar_card" 
                            name="aadhar_card" 
                            value="{{ old('aadhar_card') }}" 
                            placeholder="Enter your 12-digit Aadhar number"
                            maxlength="12"
                            pattern="[0-9]{12}"
                        >
                        @error('aadhar_card')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pan_card" class="form-label">PAN Card Number *</label>
                        <input 
                            type="text" 
                            class="form-control @error('pan_card') is-invalid @enderror" 
                            id="pan_card" 
                            name="pan_card" 
                            value="{{ old('pan_card') }}" 
                            placeholder="Enter your PAN number (e.g., ABCDE1234F)"
                            maxlength="10"
                            pattern="[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}"
                            style="text-transform: uppercase;"
                        >
                        @error('pan_card')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Document Photos -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="aadhar_photo" class="form-label">Aadhar Card Photo *</label>
                        <input 
                            type="file" 
                            class="form-control @error('aadhar_photo') is-invalid @enderror" 
                            id="aadhar_photo" 
                            name="aadhar_photo" 
                            accept="image/jpeg,image/png,image/jpg"
                        >
                        <small class="form-text text-muted">Upload a clear photo of your Aadhar card (JPEG, PNG, JPG, max 2MB)</small>
                        @error('aadhar_photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="pan_photo" class="form-label">PAN Card Photo *</label>
                        <input 
                            type="file" 
                            class="form-control @error('pan_photo') is-invalid @enderror" 
                            id="pan_photo" 
                            name="pan_photo" 
                            accept="image/jpeg,image/png,image/jpg"
                        >
                        <small class="form-text text-muted">Upload a clear photo of your PAN card (JPEG, PNG, JPG, max 2MB)</small>
                        @error('pan_photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Referenced By -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="referenced_by" class="form-label">Referenced By (Phone Number of Referrer) *</label>
                        <input 
                            type="text" 
                            class="form-control @error('referenced_by') is-invalid @enderror" 
                            id="referenced_by" 
                            name="referenced_by" 
                            value="{{ old('referenced_by') }}" 
                            placeholder="Enter 10-digit phone number of referrer"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            required
                        >
                     
                        <small class="form-text text-muted">Enter the phone number of contractor who referred you <span style="color: blue;"> if don't Have: {{ \App\Models\Contractor::where('id', 1)->value('phone')?? '' }} </span></small>
                        @error('referenced_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address *</label>
                        <textarea 
                            class="form-control @error('address') is-invalid @enderror" 
                            id="address" 
                            name="address" 
                            rows="3" 
                            placeholder="Enter your complete address"
                            maxlength="1000"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            autocomplete="new-password"
                            placeholder="Enter your password (min 8 characters)"
                            minlength="8"
                        >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input 
                            type="password" 
                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                            minlength="8"
                        >
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-contractor w-100">
                    <i class="bi bi-person-plus me-2"></i>
                    Create Account
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="register-footer">
                    Already have an account? 
                    <a href="{{ route('contractor.login') }}" class="login-link">Sign in here</a>
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
        // Enhanced Registration Page Interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const submitBtn = document.querySelector('.btn-contractor');
            const phoneInput = document.getElementById('phone');
            const aadharInput = document.getElementById('aadhar_card');
            const aadharPhotoInput = document.getElementById('aadhar_photo');
            const panCardInput = document.getElementById('pan_card');
            const panPhotoInput = document.getElementById('pan_photo');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const dateOfBirthInput = document.getElementById('date_of_birth');
            
            // Phone number validation
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
            
            // Aadhar card validation
            aadharInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 12) {
                    this.value = this.value.slice(0, 12);
                }
            });
            
            // PAN card validation
            panCardInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                this.value = this.value.replace(/[^A-Z0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });
            
            // File validation
            aadharPhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Aadhar card photo must not exceed 2MB');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Aadhar card photo must be a JPEG, PNG, or JPG file');
                        this.value = '';
                        return;
                    }
                }
            });
            
            panPhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (2MB = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('PAN card photo must not exceed 2MB');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('PAN card photo must be a JPEG, PNG, or JPG file');
                        this.value = '';
                        return;
                    }
                }
            });
            
            // Password confirmation validation
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.setCustomValidity('Passwords do not match');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            passwordInput.addEventListener('input', function() {
                if (confirmPasswordInput.value && this.value !== confirmPasswordInput.value) {
                    confirmPasswordInput.setCustomValidity('Passwords do not match');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            });
            
            // Age validation
            dateOfBirthInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                const age = today.getFullYear() - selectedDate.getFullYear();
                const monthDiff = today.getMonth() - selectedDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
                    age--;
                }
                
                if (age < 18) {
                    this.setCustomValidity('You must be at least 18 years old to register');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            // Add loading state to button on form submit
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i>Creating Account...';
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
            const registerCard = document.querySelector('.register-card');
            registerCard.style.opacity = '0';
            registerCard.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                registerCard.style.transition = 'all 0.6s ease';
                registerCard.style.opacity = '1';
                registerCard.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html> 