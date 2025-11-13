@extends('layouts.app')

@section('title', 'Opportunities')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-briefcase"></i> Employment Opportunities</h2>
                    <p class="text-muted">Explore job opportunities and programs for persons with disabilities</p>
                </div>
                <a href="{{ route('plwd.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filters/Search Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('opportunities.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Job title or keyword..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       placeholder="State or city..." value="{{ request('location') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="type" class="form-label">Job Type</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="">All Types</option>
                                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Opportunities List -->
            @if(count($opportunities) > 0)
                @foreach($opportunities as $opportunity)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <div class="bg-light rounded p-3">
                                        <i class="fas fa-building fa-3x text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title">{{ $opportunity['title'] }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-building"></i> {{ $opportunity['company'] }}
                                    </p>
                                    <p class="mb-2">{{ $opportunity['description'] }}</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-map-marker-alt"></i> {{ $opportunity['location'] }}
                                        </span>
                                        <span class="badge bg-info">
                                            <i class="fas fa-clock"></i> {{ $opportunity['type'] }}
                                        </span>
                                        <span class="badge bg-success">
                                            <i class="fas fa-dollar-sign"></i> {{ $opportunity['salary'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <small class="text-muted d-block mb-2">Posted {{ $opportunity['posted_date'] }}</small>
                                    <a href="#" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-external-link-alt"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination would go here -->
                <div class="d-flex justify-content-center mt-4">
                    {{-- Pagination links will be added when implementing real data --}}
                </div>
            @else
                <!-- No Opportunities Found -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                        <h4>No Opportunities Available Yet</h4>
                        <p class="text-muted mb-4">
                            We're currently building our opportunities database. Check back soon for exciting job opportunities!
                        </p>
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Opportunities will be posted here by employers and organizations looking to hire persons with disabilities.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Information Section -->
            <div class="card mt-4 border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle text-primary"></i> About Opportunities</h5>
                    <p class="mb-2">
                        This platform connects verified persons with disabilities to inclusive employment opportunities and training programs.
                    </p>
                    <ul class="mb-0">
                        <li>All listed opportunities are from verified employers committed to inclusive hiring</li>
                        <li>Employers understand and accommodate diverse accessibility needs</li>
                        <li>New opportunities are added regularly - check back often</li>
                        <li>Contact support if you need assistance with applications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
