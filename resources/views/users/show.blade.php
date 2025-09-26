@extends('partials.Layouts.master')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User Details: {{ $user->name }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">User Information</h5>
                    <div class="btn-group">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                            <i class="ri-edit-line me-1"></i> Edit
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID</label>
                                <p class="form-control-plaintext">{{ $user->id }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <p class="form-control-plaintext">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p class="form-control-plaintext">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tier</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $user->tier == 'Tier 3' ? 'danger' : ($user->tier == 'Tier 2' ? 'warning' : ($user->tier == 'Tier 1' ? 'info' : 'secondary') ) }}">
                                        {{ $user->tier }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Role</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $user->role == 'Administrator' ? 'danger' : ($user->role == 'Management' ? 'warning' : 'primary') }}">
                                        {{ $user->role }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">
                                        {{ $user->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Start Work Date</label>
                                <p class="form-control-plaintext">{{ $user->start_work ? $user->start_work->format('Y-m-d') : 'Not set' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Birthday</label>
                                <p class="form-control-plaintext">{{ $user->birthday ? $user->birthday->format('Y-m-d') : 'Not set' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Created At</label>
                                <p class="form-control-plaintext">{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Updated At</label>
                                <p class="form-control-plaintext">{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($user->isAdministrator())
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            This user has Administrator privileges and can access all system features.
                        </div>
                    @elseif($user->isManagement())
                        <div class="alert alert-warning">
                            <i class="ri-user-settings-line me-2"></i>
                            This user has Management privileges and can manage users and system settings.
                        </div>
                    @endif

                    @if(!$user->isActive())
                        <div class="alert alert-danger">
                            <i class="ri-error-warning-line me-2"></i>
                            This user account is currently inactive.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



