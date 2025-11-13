<x-guest-layout>
    <div class="card auth-card border-0">
        <div class="row g-0">
            <!-- Left Column: Branding & Help Info -->
            <div class="col-lg-5 auth-brand d-none d-lg-flex flex-column justify-content-center p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-key fa-4x mb-3"></i>
                    <h3 class="fw-bold">Reset Password</h3>
                    <p class="mb-0">V-PeSDI PLWDs Database</p>
                </div>
                
                <div class="mt-4">
                    <h5 class="fw-semibold mb-4">How it works:</h5>
                    <ul class="list-unstyled">
                        <li class="benefit-item mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <strong>Step 1</strong><br>
                            <small class="ms-4 opacity-75">Enter your registered email address</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-paper-plane me-2"></i>
                            <strong>Step 2</strong><br>
                            <small class="ms-4 opacity-75">We'll send you a password reset link</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-link me-2"></i>
                            <strong>Step 3</strong><br>
                            <small class="ms-4 opacity-75">Click the link in your email</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-lock me-2"></i>
                            <strong>Step 4</strong><br>
                            <small class="ms-4 opacity-75">Create a new secure password</small>
                        </li>
                    </ul>
                    
                    <div class="alert alert-light mt-4" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>The reset link expires in 60 minutes</small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Password Reset Form -->
            <div class="col-lg-7 bg-white p-5">
                <div class="mb-4">
                    <h2 class="fw-bold mb-2">Forgot Password?</h2>
                    <p class="text-muted">No problem! Enter your email address and we'll send you a password reset link.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i> Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="your.email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Enter the email address you used to register
                        </small>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                        </button>
                    </div>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Remember your password? 
                            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                                Back to login
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Additional Help -->
                <div class="mt-4 pt-3 border-top">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-question-circle me-2"></i>
                        <strong>Need help?</strong><br>
                        <small>If you don't receive the email within a few minutes, please check your spam folder.</small>
                    </div>
                </div>

                <!-- Back to Home Link -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
