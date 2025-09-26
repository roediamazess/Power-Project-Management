@extends('partials.Layouts.master')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Users Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Users List</h5>
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add New User
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Tier</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Start Work</th>
                                    <th>Birthday</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->tier == 'Tier 3' ? 'danger' : ($user->tier == 'Tier 2' ? 'warning' : ($user->tier == 'Tier 1' ? 'info' : 'secondary') ) }}">
                                            {{ $user->tier }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'Administrator' ? 'danger' : ($user->role == 'Management' ? 'warning' : 'primary') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td>{{ $user->start_work ? $user->start_work->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $user->birthday ? $user->birthday->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



