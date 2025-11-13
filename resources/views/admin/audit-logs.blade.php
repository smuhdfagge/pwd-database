@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<h2 class="mb-4">Audit Logs</h2>

<div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Administrative Activity Log</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Admin</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->admin->name }}</td>
                                        <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                                        <td>{{ $log->description ?? '-' }}</td>
                                        <td>{{ $log->ip_address }}</td>
                                        <td>{{ $log->created_at->format('d M Y, H:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No audit logs found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
