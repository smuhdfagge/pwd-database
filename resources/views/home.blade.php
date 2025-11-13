@extends('layouts.public')

@section('title', 'Home - V-PeSDI PLWDs Database')

@section('content')
<!-- Hero Section -->
<div class="bg-dark text-white py-5" style="background: linear-gradient(135deg, #212529 0%, #28a745 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold mb-4">Welcome to V-PeSDI PLWDs Database</h1>
                <p class="lead mb-4">
                    A comprehensive platform for registering, managing, and empowering Persons Living With Disabilities (PLWDs) 
                    in Nigeria. Join us in creating an inclusive society where everyone has equal opportunities.
                </p>
                <div class="d-flex gap-3">
                    @auth
                        @if(auth()->user()->role === 'plwd')
                            <a href="{{ route('opportunities.index') }}" class="btn btn-warning btn-lg px-5">
                                <i class="fas fa-briefcase"></i> View Opportunities
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-user-plus"></i> Register Now
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <i class="fas fa-users fa-10x text-white-50"></i>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">About V-PeSDI PLWDs Database</h2>
                <p class="text-muted">Building an inclusive database for persons with disabilities</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-bullseye fa-3x" style="color: #28a745;"></i>
                        </div>
                        <h4 class="card-title text-center">Our Mission</h4>
                        <p class="card-text">
                            To create a comprehensive database that captures information about Persons Living With Disabilities, 
                            facilitating better service delivery, empowerment programs, and policy formulation.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-eye fa-3x" style="color: #28a745;"></i>
                        </div>
                        <h4 class="card-title text-center">Our Vision</h4>
                        <p class="card-text">
                            An inclusive society where all Persons Living With Disabilities have equal access to opportunities, 
                            resources, and support systems that enable them to reach their full potential.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Opportunities Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="text-white">
                    <h2 class="fw-bold mb-3">
                        <i class="fas fa-briefcase"></i> Explore Job Opportunities
                    </h2>
                    <p class="lead mb-0">
                        Verified PLWDs can access exclusive employment opportunities from inclusive employers. 
                        Register and complete your profile to unlock these opportunities!
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end mt-3 mt-lg-0">
                @auth
                    @if(auth()->user()->role === 'plwd')
                        <a href="{{ route('opportunities.index') }}" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-briefcase"></i> View Opportunities
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                        <i class="fas fa-user-plus"></i> Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">Key Features</h2>
                <p class="text-muted">What makes our platform unique</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-user-circle fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Profile Management</h5>
                        <p class="card-text">Create and manage your personal profile with comprehensive information about your abilities and needs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Job Opportunities</h5>
                        <p class="card-text">Access exclusive employment opportunities and training programs designed for persons with disabilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-file-upload fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Document Upload</h5>
                        <p class="card-text">Securely upload and store important documents including ID cards, medical certificates, and more.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Verification System</h5>
                        <p class="card-text">Get your registration verified by administrators to access exclusive benefits and programs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-bar fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Data Analytics</h5>
                        <p class="card-text">Administrators can generate comprehensive reports and insights to drive policy decisions.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Secure & Private</h5>
                        <p class="card-text">Your data is protected with industry-standard security measures and privacy protocols.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Accessible Design</h5>
                        <p class="card-text">Built with accessibility in mind, ensuring everyone can use the platform effectively.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold">How It Works</h2>
                <p class="text-muted">Simple steps to get started</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <h2 class="mb-0">1</h2>
                </div>
                <h5>Register</h5>
                <p class="text-muted">Create your account with basic information</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <h2 class="mb-0">2</h2>
                </div>
                <h5>Complete Profile</h5>
                <p class="text-muted">Fill in your detailed profile information</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <h2 class="mb-0">3</h2>
                </div>
                <h5>Upload Documents</h5>
                <p class="text-muted">Submit required supporting documents</p>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <h2 class="mb-0">4</h2>
                </div>
                <h5>Get Verified</h5>
                <p class="text-muted">Wait for admin verification and approval</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-success text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Ready to Get Started?</h2>
        <p class="lead mb-4">Join thousands of PLWDs who have registered and are benefiting from our services.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
            <i class="fas fa-user-plus"></i> Register Now
        </a>
    </div>
</section>

<!-- Statistics Section (Optional - can be populated with real data) -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card border-success">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x mb-3" style="color: #28a745;"></i>
                        <h2 class="fw-bold">1000+</h2>
                        <p class="text-muted">Registered PLWDs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-success">
                    <div class="card-body">
                        <i class="fas fa-check-double fa-3x mb-3" style="color: #28a745;"></i>
                        <h2 class="fw-bold">850+</h2>
                        <p class="text-muted">Verified Profiles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-success">
                    <div class="card-body">
                        <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: #28a745;"></i>
                        <h2 class="fw-bold">36</h2>
                        <p class="text-muted">States Covered</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
