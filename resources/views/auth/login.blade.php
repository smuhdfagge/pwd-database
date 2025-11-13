<x-guest-layout>
    <div class="card auth-card border-0">
        <div class="row g-0">
            <!-- Left Column: Branding & Welcome Message -->
            <div class="col-lg-5 auth-brand d-none d-lg-flex flex-column justify-content-center p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-users fa-4x mb-3"></i>
                    <h3 class="fw-bold">Welcome Back!</h3>
                    <p class="mb-0">V-PeSDI PLWDs Database</p>
                </div>
                
                <div class="mt-4">
                    <h5 class="fw-semibold mb-4">Sign in to access:</h5>
                    <ul class="list-unstyled">
                        <li class="benefit-item mb-3">
                            <i class="fas fa-user-circle me-2"></i>
                            <strong>Your Profile</strong><br>
                            <small class="ms-4 opacity-75">View and manage your personal information</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-file-alt me-2"></i>
                            <strong>Documents</strong><br>
                            <small class="ms-4 opacity-75">Upload and manage your documents securely</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Verification Status</strong><br>
                            <small class="ms-4 opacity-75">Track your registration verification</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-hands-helping me-2"></i>
                            <strong>Support & Resources</strong><br>
                            <small class="ms-4 opacity-75">Access programs and opportunities</small>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Login Form -->
            <div class="col-lg-7 bg-white p-5">
                <div class="mb-4">
                    <h2 class="fw-bold mb-2">Sign In</h2>
                    <p class="text-muted">Enter your credentials to access your account</p>
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
                        <strong>Login failed!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
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
                               autocomplete="username"
                               placeholder="your.email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i> Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">
                                Register here
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Back to Home Link -->
                <div class="text-center mt-4 pt-3 border-top">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
