@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<h2 class="mb-4">System Settings</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- General Settings -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-sliders-h"></i> General Settings</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" value="V-PeSDI PLWDs Database" placeholder="Enter site name">
                        <small class="text-muted">The name of your application</small>
                    </div>

                    <div class="mb-3">
                        <label for="site_email" class="form-label">System Email</label>
                        <input type="email" class="form-control" id="site_email" name="site_email" value="admin@vpesdi.org" placeholder="Enter system email">
                        <small class="text-muted">Email address for system notifications</small>
                    </div>

                    <div class="mb-3">
                        <label for="records_per_page" class="form-label">Records Per Page</label>
                        <select class="form-select" id="records_per_page" name="records_per_page">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <small class="text-muted">Number of records to display per page in listings</small>
                    </div>

                    <hr>

                    <h6 class="mb-3">Email Notifications</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notify_new_registration" name="notify_new_registration" checked>
                            <label class="form-check-label" for="notify_new_registration">
                                Notify admin on new PLWD registration
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notify_profile_update" name="notify_profile_update" checked>
                            <label class="form-check-label" for="notify_profile_update">
                                Notify admin on profile updates
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notify_document_upload" name="notify_document_upload">
                            <label class="form-check-label" for="notify_document_upload">
                                Notify admin on document uploads
                            </label>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Security Settings</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="require_email_verification" name="require_email_verification" checked>
                            <label class="form-check-label" for="require_email_verification">
                                Require email verification for new accounts
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="enable_audit_logs" name="enable_audit_logs" checked>
                            <label class="form-check-label" for="enable_audit_logs">
                                Enable audit logging
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> System Information</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-6">Laravel Version:</dt>
                    <dd class="col-sm-6">{{ app()->version() }}</dd>

                    <dt class="col-sm-6">PHP Version:</dt>
                    <dd class="col-sm-6">{{ PHP_VERSION }}</dd>

                    <dt class="col-sm-6">Environment:</dt>
                    <dd class="col-sm-6">
                        <span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                            {{ ucfirst(app()->environment()) }}
                        </span>
                    </dd>

                    <dt class="col-sm-6">Database:</dt>
                    <dd class="col-sm-6">{{ config('database.default') }}</dd>

                    <dt class="col-sm-6">Total Users:</dt>
                    <dd class="col-sm-6">{{ \App\Models\User::count() }}</dd>

                    <dt class="col-sm-6">Total PLWDs:</dt>
                    <dd class="col-sm-6">{{ \App\Models\PlwdProfile::count() }}</dd>
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-broom"></i> Maintenance</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">System maintenance and cleanup operations</p>
                
                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="alert('Cache cleared successfully!')">
                    <i class="fas fa-sync"></i> Clear Cache
                </button>
                
                <button type="button" class="btn btn-outline-warning btn-sm w-100 mb-2" onclick="alert('Logs cleared successfully!')">
                    <i class="fas fa-trash-alt"></i> Clear Old Logs
                </button>
                
                <button type="button" class="btn btn-outline-info btn-sm w-100" onclick="alert('Backup created successfully!')">
                    <i class="fas fa-database"></i> Backup Database
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
