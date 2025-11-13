@extends('layouts.app')

@section('title', $opportunity->title . ' - Opportunities')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('opportunities.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Opportunities
                </a>
            </div>

            <!-- Main Opportunity Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ $opportunity->title }}</h2>
                            
                            @if($opportunity->organization)
                                <p class="text-muted mb-3">
                                    <i class="fas fa-building fa-lg"></i> 
                                    <strong>{{ $opportunity->organization }}</strong>
                                </p>
                            @endif

                            <div class="d-flex gap-2 flex-wrap mb-4">
                                @if($opportunity->location)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-map-marker-alt"></i> {{ $opportunity->location }}
                                    </span>
                                @endif
                                <span class="badge bg-info">
                                    <i class="fas fa-tag"></i> {{ ucfirst($opportunity->type) }}
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-eye"></i> {{ $opportunity->views }} views
                                </span>
                                @if($opportunity->deadline)
                                    <span class="badge {{ $opportunity->isExpired() ? 'bg-danger' : 'bg-warning' }}">
                                        <i class="fas fa-calendar"></i> 
                                        Deadline: {{ $opportunity->deadline->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <h5 class="mb-3">Description</h5>
                            <div class="opportunity-description" style="white-space: pre-wrap;">
                                {{ $opportunity->description }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="fas fa-info-circle"></i> Opportunity Details
                                    </h5>

                                    @if($opportunity->deadline)
                                        <div class="mb-3">
                                            <strong><i class="fas fa-calendar-alt text-primary"></i> Deadline:</strong><br>
                                            <span class="{{ $opportunity->isExpired() ? 'text-danger' : '' }}">
                                                {{ $opportunity->deadline->format('F d, Y') }}
                                                @if($opportunity->isExpired())
                                                    (Expired)
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    @if($opportunity->location)
                                        <div class="mb-3">
                                            <strong><i class="fas fa-map-marker-alt text-primary"></i> Location:</strong><br>
                                            {{ $opportunity->location }}
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong><i class="fas fa-tag text-primary"></i> Type:</strong><br>
                                        {{ ucfirst($opportunity->type) }}
                                    </div>

                                    <div class="mb-3">
                                        <strong><i class="fas fa-clock text-primary"></i> Posted:</strong><br>
                                        {{ $opportunity->created_at->format('M d, Y') }}<br>
                                        <small class="text-muted">({{ $opportunity->created_at->diffForHumans() }})</small>
                                    </div>

                                    <hr>

                                    <h6 class="mb-3"><i class="fas fa-phone"></i> Contact Information</h6>

                                    @if($opportunity->contact_email)
                                        <div class="mb-2">
                                            <strong>Email:</strong><br>
                                            <a href="mailto:{{ $opportunity->contact_email }}">
                                                {{ $opportunity->contact_email }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($opportunity->contact_phone)
                                        <div class="mb-2">
                                            <strong>Phone:</strong><br>
                                            <a href="tel:{{ $opportunity->contact_phone }}">
                                                {{ $opportunity->contact_phone }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($opportunity->website_url)
                                        <div class="mb-2">
                                            <strong>Website:</strong><br>
                                            <a href="{{ $opportunity->website_url }}" target="_blank" rel="noopener noreferrer">
                                                Visit Website <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    @endif

                                    @if(!$opportunity->contact_email && !$opportunity->contact_phone && !$opportunity->website_url)
                                        <p class="text-muted mb-0">
                                            Contact information will be provided upon application.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if($opportunity->website_url || $opportunity->contact_email)
                                <div class="mt-3">
                                    @if($opportunity->website_url)
                                        <a href="{{ $opportunity->website_url }}" 
                                           class="btn btn-primary w-100 mb-2" 
                                           target="_blank" 
                                           rel="noopener noreferrer">
                                            <i class="fas fa-external-link-alt"></i> Apply Now
                                        </a>
                                    @endif
                                    @if($opportunity->contact_email)
                                        <a href="mailto:{{ $opportunity->contact_email }}?subject=Application for {{ $opportunity->title }}" 
                                           class="btn btn-outline-primary w-100">
                                            <i class="fas fa-envelope"></i> Send Email
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-exclamation-circle text-primary"></i> Important Information
                    </h6>
                    <ul class="mb-0">
                        <li>Always verify the authenticity of opportunities before sharing personal information</li>
                        <li>This platform does not charge fees for accessing opportunities</li>
                        <li>Report suspicious opportunities to our support team</li>
                        <li>Keep your profile updated to receive relevant opportunities</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .opportunity-description {
        line-height: 1.8;
    }
    .opportunity-description h1,
    .opportunity-description h2,
    .opportunity-description h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .opportunity-description ul,
    .opportunity-description ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .opportunity-description p {
        margin-bottom: 1rem;
    }
</style>
@endsection
