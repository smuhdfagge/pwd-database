@extends('layouts.app')

@section('title', 'Account Verification Required')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-warning">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-4x text-warning"></i>
                    </div>
                    
                    <h3 class="mb-3">Account Verification Pending</h3>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Your account is currently under review
                    </div>
                    
                    <p class="text-muted mb-4">
                        Thank you for registering! Your profile is currently being reviewed by our admin team. 
                        Access to opportunities will be granted once your account has been verified.
                    </p>
                    
                    <div class="bg-light rounded p-4 mb-4">
                        <h5 class="mb-3"><i class="fas fa-list-check"></i> What happens next?</h5>
                        <ol class="text-start mb-0">
                            <li class="mb-2">Our admin team reviews your profile and documents</li>
                            <li class="mb-2">You'll receive an email notification once verified</li>
                            <li class="mb-2">After verification, you can access all opportunities</li>
                            <li>You'll be able to apply for jobs and training programs</li>
                        </ol>
                    </div>
                    
                    <div class="border-top pt-4 mt-4">
                        <p class="mb-3">
                            <strong>Need help or have questions?</strong>
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-envelope"></i> Contact our support team at:
                        </p>
                        <a href="mailto:{{ $supportEmail }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> {{ $supportEmail }}
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('plwd.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-lightbulb text-info"></i> While You Wait...</h6>
                    <ul class="mb-0 small">
                        <li>Ensure all your profile information is complete and accurate</li>
                        <li>Upload any required documents if you haven't already</li>
                        <li>Keep your contact information up to date</li>
                        <li>Check your email regularly for updates</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
