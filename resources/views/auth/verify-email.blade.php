<x-guest-layout>
    <div class="card auth-card border-0">
        <div class="row g-0">
            <!-- Left Column: Illustration & Info -->
            <div class="col-lg-5 auth-brand d-none d-lg-flex flex-column justify-content-center align-items-center p-5 text-center">
                <div class="mb-4">
                    <div class="verification-icon mb-4">
                        <i class="fas fa-envelope-open-text fa-5x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Email Verification</h3>
                    <p class="mb-0 opacity-75">Secure your account and unlock full access</p>
                </div>
                
                <div class="mt-5">
                    <h5 class="fw-semibold mb-4">Why verify your email?</h5>
                    <ul class="list-unstyled text-start">
                        <li class="benefit-item mb-3">
                            <i class="fas fa-shield-alt me-2"></i>
                            <strong>Account Security</strong><br>
                            <small class="ms-4 opacity-75">Protect your personal information</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-bell me-2"></i>
                            <strong>Stay Updated</strong><br>
                            <small class="ms-4 opacity-75">Receive important notifications</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-unlock-alt me-2"></i>
                            <strong>Full Access</strong><br>
                            <small class="ms-4 opacity-75">Access all profile features</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-user-check me-2"></i>
                            <strong>Verified Status</strong><br>
                            <small class="ms-4 opacity-75">Build trust and credibility</small>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Verification Content -->
            <div class="col-lg-7 bg-white p-5">
                <div class="text-center mb-5">
                    <div class="verify-icon-main mb-4">
                        <i class="fas fa-envelope-circle-check text-primary" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Verify Your Email Address</h2>
                    <p class="text-muted">We've sent a verification link to</p>
                    <p class="fw-semibold text-dark mb-0">{{ auth()->user()->email }}</p>
                </div>

                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Email Sent!</strong>
                        <p class="mb-0 mt-2">A new verification link has been sent to your email address. Please check your inbox and spam folder.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Instructions Card -->
                <div class="card bg-light border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Next Steps
                        </h5>
                        <ol class="mb-0 ps-3">
                            <li class="mb-2">Check your email inbox for a message from {{ config('app.name') }}</li>
                            <li class="mb-2">Click the verification link in the email</li>
                            <li class="mb-2">You'll be redirected back and can access your profile</li>
                        </ol>
                    </div>
                </div>

                <!-- Didn't Receive Email Section -->
                <div class="card border-warning mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-question-circle text-warning me-2"></i>
                            Didn't receive the email?
                        </h6>
                        <p class="card-text text-muted small mb-3">
                            Check your spam or junk folder. If you still can't find it, we can send you another verification link.
                        </p>
                        
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i>
                                Resend Verification Email
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="alert alert-info border-0 mb-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-lightbulb me-3 mt-1"></i>
                        <div>
                            <strong>Tip:</strong> Make sure to check your spam folder if you don't see the email in your inbox within a few minutes.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column gap-2">
                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Log Out
                        </button>
                    </form>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-4 pt-3 border-top">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Styling for This Page -->
    <style>
        .verification-icon {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .verify-icon-main {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .alert {
            border-radius: 10px;
        }
        
        .card {
            border-radius: 10px;
        }
        
        .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .benefit-item {
            transition: transform 0.2s;
        }
        
        .benefit-item:hover {
            transform: translateX(5px);
        }
    </style>
</x-guest-layout>
