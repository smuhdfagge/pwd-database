<x-guest-layout>
    <div class="card auth-card border-0">
        <div class="row g-0">
            <!-- Left Column: Branding & Benefits -->
            <div class="col-lg-5 auth-brand d-none d-lg-flex flex-column justify-content-center p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/vpesdilogo.jpg') }}" alt="V-PeSDI Logo" class="img-fluid mb-3 mx-auto d-block" style="max-width: 150px;">
                    <h3 class="fw-bold">V-PeSDI PLWDs Database</h3>
                    <p class="mb-0">Empowering Persons Living With Disabilities</p>
                </div>
                
                <div class="mt-4">
                    <h5 class="fw-semibold mb-4">Why Register?</h5>
                    <ul class="list-unstyled">
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Easy Profile Management</strong><br>
                            <small class="ms-4 opacity-75">Update your information anytime, anywhere</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Secure Document Storage</strong><br>
                            <small class="ms-4 opacity-75">Upload and manage your documents safely</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Verification & Support</strong><br>
                            <small class="ms-4 opacity-75">Get verified by admins and access resources</small>
                        </li>
                        <li class="benefit-item mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Community Connection</strong><br>
                            <small class="ms-4 opacity-75">Connect with support programs and opportunities</small>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Registration Form -->
            <div class="col-lg-7 bg-white p-5">
                <div class="mb-4">
                    <h2 class="fw-bold mb-2">Create Account</h2>
                    <p class="text-muted">Join our community and start your journey</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-1"></i> Full Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                               autocomplete="username"
                               placeholder="your.email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Fields (side by side on larger screens) -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Minimum 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">At least 8 characters</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i> Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Re-enter password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Privacy Consent -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input @error('privacy_consent') is-invalid @enderror" 
                                   id="privacy_consent" 
                                   name="privacy_consent" 
                                   value="1"
                                   {{ old('privacy_consent') ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label" for="privacy_consent">
                                I agree to the 
                                <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-primary">
                                    Privacy and Data Management Policy
                                </a>
                                <span class="text-danger">*</span>
                            </label>
                            @error('privacy_consent')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Create Account
                        </button>
                    </div>

                    <!-- Already Registered Link -->
                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                                Sign in here
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

    <!-- Privacy and Data Management Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="privacyModalLabel">
                        <i class="fas fa-shield-alt me-2"></i> Privacy and Data Management Policy
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <h6 class="fw-bold mb-3">1. Introduction</h6>
                        <p>
                            Welcome to the V-PeSDI (Vocational and Persons with Special Disabilities Initiative) PLWDs Database. 
                            We are committed to protecting your privacy and managing your personal data responsibly. 
                            This policy explains how we collect, use, store, and protect your information.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">2. Data We Collect</h6>
                        <p>We collect the following types of information:</p>
                        <ul>
                            <li><strong>Personal Information:</strong> Name, email address, date of birth, phone number, and address</li>
                            <li><strong>Disability Information:</strong> Type of disability, medical reports, and related documentation</li>
                            <li><strong>Educational Background:</strong> Education level and certifications</li>
                            <li><strong>Skills and Abilities:</strong> Professional skills and competencies</li>
                            <li><strong>Documents:</strong> ID cards, medical certificates, and other supporting documents</li>
                            <li><strong>Location Data:</strong> State, LGA, and geographical coordinates (if provided)</li>
                        </ul>

                        <h6 class="fw-bold mb-3 mt-4">3. How We Use Your Data</h6>
                        <p>Your information is used for the following purposes:</p>
                        <ul>
                            <li>Creating and maintaining your profile in our database</li>
                            <li>Verifying your identity and eligibility for services</li>
                            <li>Connecting you with employment opportunities and training programs</li>
                            <li>Generating statistical reports for policy formulation and advocacy</li>
                            <li>Providing support services and resources tailored to your needs</li>
                            <li>Communicating important updates and opportunities</li>
                        </ul>

                        <h6 class="fw-bold mb-3 mt-4">4. Data Protection and Security</h6>
                        <p>We implement robust security measures to protect your data:</p>
                        <ul>
                            <li>Secure encrypted storage of all personal information</li>
                            <li>Access controls limiting who can view your data</li>
                            <li>Regular security audits and updates</li>
                            <li>Secure transmission of data using SSL/TLS encryption</li>
                            <li>Compliance with data protection regulations</li>
                        </ul>

                        <h6 class="fw-bold mb-3 mt-4">5. Data Sharing</h6>
                        <p>Your data may be shared only in the following circumstances:</p>
                        <ul>
                            <li><strong>With Your Consent:</strong> When you explicitly authorize data sharing</li>
                            <li><strong>Service Providers:</strong> Verified organizations offering employment or training opportunities</li>
                            <li><strong>Government Agencies:</strong> For policy planning and implementation of disability support programs</li>
                            <li><strong>Anonymous Statistics:</strong> Aggregated, non-identifiable data for research and reports</li>
                        </ul>
                        <p class="text-muted small">
                            <i class="fas fa-info-circle"></i> We will never sell your personal data to third parties.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">6. Your Rights</h6>
                        <p>You have the following rights regarding your data:</p>
                        <ul>
                            <li><strong>Access:</strong> Request a copy of your personal data</li>
                            <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                            <li><strong>Deletion:</strong> Request deletion of your account and data</li>
                            <li><strong>Withdrawal:</strong> Withdraw consent at any time</li>
                            <li><strong>Portability:</strong> Request your data in a portable format</li>
                            <li><strong>Objection:</strong> Object to certain data processing activities</li>
                        </ul>

                        <h6 class="fw-bold mb-3 mt-4">7. Data Retention</h6>
                        <p>
                            We retain your personal data for as long as your account is active or as needed to provide you services. 
                            If you request account deletion, we will remove your personal data within 30 days, except where 
                            retention is required by law or for legitimate business purposes.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">8. Cookies and Tracking</h6>
                        <p>
                            Our platform uses essential cookies to maintain your session and enhance user experience. 
                            We do not use third-party tracking cookies for advertising purposes.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">9. Children's Privacy</h6>
                        <p>
                            Our services are intended for individuals 18 years and older. If you are under 18, 
                            please have a parent or guardian assist you with registration.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">10. Changes to This Policy</h6>
                        <p>
                            We may update this privacy policy from time to time. We will notify you of any significant 
                            changes via email or through a notice on our platform.
                        </p>

                        <h6 class="fw-bold mb-3 mt-4">11. Contact Us</h6>
                        <p>
                            If you have questions about this privacy policy or wish to exercise your data rights, 
                            please contact us at:
                        </p>
                        <div class="alert alert-info">
                            <i class="fas fa-envelope"></i> Email: <strong>privacy@vpesdi.org</strong><br>
                            <i class="fas fa-phone"></i> Phone: <strong>+234-XXX-XXX-XXXX</strong>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> By registering and accepting this policy, you confirm that you understand 
                            and agree to the collection, use, and sharing of your data as described above.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="acceptPrivacyPolicy()">
                        <i class="fas fa-check me-1"></i> I Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function acceptPrivacyPolicy() {
            // Check the privacy consent checkbox
            document.getElementById('privacy_consent').checked = true;
            
            // Close the modal
            var privacyModal = bootstrap.Modal.getInstance(document.getElementById('privacyModal'));
            privacyModal.hide();
            
            // Optional: Show a success message
            // You can add a small notification here if desired
        }
    </script>
</x-guest-layout>
