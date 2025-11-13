<x-guest-layout>
    <div class="card auth-card border-0">
        <div class="row g-0">
            <!-- Left Column: Branding & Security Info -->
            <div class="col-lg-5 auth-brand d-none d-lg-flex flex-column justify-content-center p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-shield-alt fa-4x mb-3"></i>
                    <h3 class="fw-bold">Create New Password</h3>
                    <p class="mb-0">V-PeSDI PLWDs Database</p>
                </div>
                
                <div class="mt-4">
                    <h5 class="fw-semibold mb-4">Password Security Tips:</h5>
                    <ul class="list-unstyled">
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Length Matters</strong><br>
                            <small class="ms-4 opacity-75">Use at least 8 characters</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Mix It Up</strong><br>
                            <small class="ms-4 opacity-75">Combine letters, numbers, and symbols</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Be Unique</strong><br>
                            <small class="ms-4 opacity-75">Don't reuse passwords from other sites</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Avoid Obvious</strong><br>
                            <small class="ms-4 opacity-75">No birthdays, names, or common words</small>
                        </li>
                    </ul>
                    
                    <div class="alert alert-light mt-4" role="alert">
                        <i class="fas fa-lock me-2"></i>
                        <small>Your password is encrypted and secure</small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Reset Password Form -->
            <div class="col-lg-7 bg-white p-5">
                <div class="mb-4">
                    <h2 class="fw-bold mb-2">Reset Your Password</h2>
                    <p class="text-muted">Enter your email and choose a new secure password</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i> Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="your.email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i> New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Enter your new password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Minimum 8 characters, including uppercase, lowercase, and numbers
                        </small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-1"></i> Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Re-enter your new password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check-circle me-2"></i> Reset Password
                        </button>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-shield-alt me-2"></i>
                        <small><strong>Security Notice:</strong> After resetting your password, you'll be redirected to the login page to sign in with your new credentials.</small>
                    </div>
                </form>

                <!-- Back to Login Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
