@extends('partials.layouts.master')

@section('title', 'Users Management | Power Project Management')

@section('title-sub', 'Users')
@section('pagetitle', 'Users Management')

@section('content')
    <!-- Begin page -->
    <div id="layout-wrapper">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">
                            <h6 class="card-title mb-0 fw-semibold">
                                Users <span class="badge bg-secondary-subtle text-secondary ms-1">{{ isset($users) ? count($users) : 0 }}</span>
                            </h6>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal"
                                    data-bs-target="#createUserModal">
                                    <i class="bi bi-plus-lg me-1"></i>Add New User
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-box table-responsive">
                            <table class="table text-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Tier</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Start Work</th>
                                        <th scope="col">Birthday</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user['id'] ?? 'N/A' }}</th>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="assets/images/avatar/avatar-{{ (($user['id'] ?? 1) % 10) + 1 }}.jpg" alt="Avatar Image"
                                                class="avatar-md rounded-pill">
                                            <div>
                                                <h6 class="mb-0 fw-medium fs-13">{{ $user['name'] ?? 'N/A' }}</h6>
                                            </div>
                                        </td>
                                        <td><i class="bi bi-envelope me-2 text-muted"></i>{{ $user['email'] ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $tierColors = [
                                                    'New Born' => 'secondary',
                                                    'Tier 1' => 'primary',
                                                    'Tier 2' => 'warning',
                                                    'Tier 3' => 'danger'
                                                ];
                                                $tier = $user['tier'] ?? 'New Born';
                                                $color = $tierColors[$tier] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }}">{{ $tier }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $roleColors = [
                                                    'Administrator' => 'danger',
                                                    'Management' => 'warning',
                                                    'Admin Officer' => 'info',
                                                    'User' => 'primary',
                                                    'Client' => 'success'
                                                ];
                                                $role = $user['role'] ?? 'User';
                                                $color = $roleColors[$role] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }}">{{ $role }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $status = $user['status'] ?? 'Active';
                                            @endphp
                                            <span class="badge bg-{{ $status === 'Active' ? 'success' : 'danger' }}-subtle text-{{ $status === 'Active' ? 'success' : 'danger' }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(isset($user['start_work']) && $user['start_work'])
                                                {{ \Carbon\Carbon::parse($user['start_work'])->format('d M Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($user['birthday']) && $user['birthday'])
                                                {{ \Carbon\Carbon::parse($user['birthday'])->format('d M Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <div class="hstack gap-2">
                                                <button type="button" class="btn btn-light-success icon-btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-white"
                                                    data-bs-placement="top" data-bs-title="View Details"
                                                    onclick="viewUser({{ $user['id'] ?? 0 }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-light-primary icon-btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-white"
                                                    data-bs-placement="top" data-bs-title="Edit User"
                                                    onclick="editUser({{ $user['id'] ?? 0 }})">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-people fs-1 text-muted mb-3"></i>
                                                <h6 class="text-muted">No users found</h6>
                                                <p class="text-muted mb-0">Start by adding your first user</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        @if(isset($users) && count($users) > 0)
                        <div class="d-flex flex-wrap gap-3 align-items-center m-5">
                            <div class="fw-medium"> 
                                Showing {{ count($users) }} Users
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- User Create Modal -->
        <div class="modal fade" id="createUserModal" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ri-close-large-line fw-semibold"></i>
                        </button>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password"
                                        placeholder="Enter password (min 8 characters)" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tier" class="form-label">Tier <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tier') is-invalid @enderror" id="tier" name="tier" required>
                                        <option value="">Select Tier</option>
                                        <option value="New Born" {{ old('tier') == 'New Born' ? 'selected' : '' }}>New Born</option>
                                        <option value="Tier 1" {{ old('tier') == 'Tier 1' ? 'selected' : '' }}>Tier 1</option>
                                        <option value="Tier 2" {{ old('tier') == 'Tier 2' ? 'selected' : '' }}>Tier 2</option>
                                        <option value="Tier 3" {{ old('tier') == 'Tier 3' ? 'selected' : '' }}>Tier 3</option>
                                    </select>
                                    @error('tier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        <option value="Management" {{ old('role') == 'Management' ? 'selected' : '' }}>Management</option>
                                        <option value="Admin Officer" {{ old('role') == 'Admin Officer' ? 'selected' : '' }}>Admin Officer</option>
                                        <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                                        <option value="Client" {{ old('role') == 'Client' ? 'selected' : '' }}>Client</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="start_work" class="form-label">Start Work Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_work') is-invalid @enderror" 
                                        id="start_work" name="start_work" value="{{ old('start_work') }}" required>
                                    @error('start_work')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                                        id="birthday" name="birthday" value="{{ old('birthday') }}" required>
                                    @error('birthday')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Edit Modal -->
        <div class="modal fade" id="editUserModal" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ri-close-large-line fw-semibold"></i>
                        </button>
                    </div>
                    <form id="editUserForm" action="#" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_tier" class="form-label">Tier <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_tier" name="tier" required>
                                        <option value="New Born">New Born</option>
                                        <option value="Tier 1">Tier 1</option>
                                        <option value="Tier 2">Tier 2</option>
                                        <option value="Tier 3">Tier 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_role" name="role" required>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Management">Management</option>
                                        <option value="Admin Officer">Admin Officer</option>
                                        <option value="User">User</option>
                                        <option value="Client">Client</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_start_work" class="form-label">Start Work Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="edit_start_work" name="start_work" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_birthday" class="form-label">Birthday <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="edit_birthday" name="birthday" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        window.usersList = @json($users ?? []);

        // View User Function
        function viewUser(userId) {
            alert('View user: ' + userId);
        }

        // Edit User Function
        function editUser(userId) {
            var user = (window.usersList || []).find(function(u){ return Number(u.id) === Number(userId); });
            if (!user) { return; }

            // Fill form fields
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_tier').value = user.tier || 'New Born';
            document.getElementById('edit_role').value = user.role || 'User';
            document.getElementById('edit_status').value = user.status || 'Active';
            if (user.start_work) {
                try { document.getElementById('edit_start_work').value = new Date(user.start_work).toISOString().slice(0,10); } catch(e) { document.getElementById('edit_start_work').value = ''; }
            } else { document.getElementById('edit_start_work').value = ''; }
            if (user.birthday) {
                try { document.getElementById('edit_birthday').value = new Date(user.birthday).toISOString().slice(0,10); } catch(e) { document.getElementById('edit_birthday').value = ''; }
            } else { document.getElementById('edit_birthday').value = ''; }

            // Set action to resource route /users/{id}
            var form = document.getElementById('editUserForm');
            form.action = '/users/' + userId;

            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }
    </script>
@endsection
