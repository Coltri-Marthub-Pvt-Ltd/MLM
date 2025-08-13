<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Login - <?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link href="<?php echo e(asset('css/admin.css')); ?>" rel="stylesheet">
    
    <style>
        /* Admin Theme Consistent Login Page */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: hsl(var(--muted));
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
            background: radial-gradient(circle, hsl(var(--primary) / 0.05) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: float 30s ease-in-out infinite;
            z-index: 1;
        }

        .login-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 40%, hsl(var(--primary) / 0.03) 50%, transparent 60%);
            animation: shimmer 4s ease-in-out infinite;
            z-index: 2;
        }

        /* Floating Orbs with Theme Colors */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: hsl(var(--primary) / 0.1);
            backdrop-filter: blur(10px);
            animation: float-orb 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 120px;
            height: 120px;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
            background: hsl(var(--primary) / 0.08);
        }

        .orb-2 {
            width: 180px;
            height: 180px;
            top: 55%;
            right: 15%;
            animation-delay: 3s;
            background: hsl(var(--primary) / 0.06);
        }

        .orb-3 {
            width: 90px;
            height: 90px;
            bottom: 20%;
            left: 25%;
            animation-delay: 6s;
            background: hsl(var(--primary) / 0.1);
        }

        .login-card {
            background-color: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
            background-color: hsl(var(--primary));
            border-radius: calc(var(--radius) * 1.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 15px -3px hsl(var(--primary) / 0.3);
        }

        .login-logo i {
            font-size: 1.8rem;
            color: hsl(var(--primary-foreground));
        }
        
        .login-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: hsl(var(--foreground));
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: hsl(var(--muted-foreground));
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Use Admin Theme Form Styles */
        .form-label {
            color: hsl(var(--foreground));
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control {
            background-color: hsl(var(--background));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            color: hsl(var(--foreground));
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 2px hsl(var(--ring));
        }

        .form-control::placeholder {
            color: hsl(var(--muted-foreground));
        }

        /* Use Admin Theme Button */
        .btn-primary {
            background-color: hsl(var(--primary));
            border-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            /* transition: all 0.2s ease; */
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background-color: hsl(var(--primary) / 0.9);
            border-color: hsl(var(--primary) / 0.9);
            color: hsl(var(--primary-foreground));
        }

        /* Use Admin Theme Checkbox */
        .form-check-input {
            border-radius: calc(var(--radius) - 2px);
            border: 1px solid hsl(var(--border));
            background-color: hsl(var(--background));
        }

        .form-check-input:checked {
            background-color: hsl(var(--primary));
            border-color: hsl(var(--primary));
        }

        .form-check-input:focus {
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 2px hsl(var(--ring));
        }

        .form-check-label {
            color: hsl(var(--foreground));
            font-size: 0.875rem;
        }

        /* Use Admin Theme Alert */
        .alert-danger {
            background-color: hsl(var(--destructive) / 0.1);
            border: 1px solid hsl(var(--destructive) / 0.2);
            color: hsl(var(--destructive));
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Footer text */
        .login-footer {
            color: hsl(var(--muted-foreground));
            font-size: 0.75rem;
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
        .btn-primary.loading {
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
<body class="admin-body">
    <div class="login-container">
        <!-- Floating Orbs -->
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your admin account</p>
            </div>

            <!-- Alerts -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="email" 
                        name="email" 
                        value="<?php echo e(old('email')); ?>" 
                        required 
                        autocomplete="email" 
                        autofocus
                        placeholder="Enter your email"
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            <?php echo e(old('remember') ? 'checked' : ''); ?>

                        >
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Sign In
                </button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">
                    © <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Laravel')); ?>. All rights reserved.
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced Login Page Interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.btn-primary');
            
            // Add loading state to button on form submit
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                // submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Signing In...';            });
            
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
</html> <?php /**PATH C:\laragon\www\MLM\resources\views/auth/login.blade.php ENDPATH**/ ?>