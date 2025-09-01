@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Users List</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.employees.manage') }}">User Manage</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li>
                                        <a href="#" class="btn btn-primary d-none d-md-inline-flex" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add User</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-block-head-between -->
                    </div><!-- .nk-block-head -->

                    <div class="nk-block">
                        <div class="card">
                            <div class="dataTable-container table-responsive">
                                <table class="datatable-init table dataTable-table" data-nk-container="table-responsive">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="tb-col"><span class="overline-title">Users</span></th>
                                            <th class="tb-col"><span class="overline-title">Role</span></th>
                                            <th class="tb-col"><span class="overline-title">Hospital</span></th>
                                            <th class="tb-col"><span class="overline-title">Branch</span></th>
                                            <th class="tb-col tb-col-xxl"><span class="overline-title">Joined Date</span></th>
                                            <th class="tb-col"><span class="overline-title">Status</span></th>
                                            <th class="tb-col tb-col-end"><span class="overline-title">Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employees as $user)
                                            <tr>
                                                <td class="tb-col">
                                                    <div class="media-group">
                                                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="media media-md media-middle media-circle" >
                                                            <div class="media media-md media-middle media-circle" >
                                                                    <img src="{{ asset('images/users/def.jpg') }}" alt="user" onerror="this.src='https://placehold.co/100x100/E9ECEF/000000?text=A'">
                                                            </div>
                                                        </a>
                                                        <div class="media-text">
                                                            <a href="{{ route('profile', ['id' => $user->id]) }}" class="title">{{ $user->name }}</a>
                                                            <span class="small text">{{ $user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="tb-col">{{ ucfirst($user->role) }}</td>
                                                <td class="tb-col">
                                                    @if ($user->hospital)
                                                        {{ $user->hospital->name }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="tb-col">
                                                    @if ($user->branch)
                                                        {{ $user->branch->name }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="tb-col tb-col-xxl">{{ $user->created_at->format('Y/m/d') }}</td>
                                                <td class="tb-col">
                                                    <span class="badge text-bg-success-soft">Active</span>
                                                </td>
                                                <td class="tb-col tb-col-end">
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-v"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                            <div class="dropdown-content py-1">
                                                                <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                    <li>
                                                                        <a href="#" class="edit-user" data-bs-toggle="modal" data-bs-target="#addUserModal"
                                                                            data-id="{{ $user->id }}"
                                                                            data-name="{{ $user->name }}"
                                                                            data-email="{{ $user->email }}"
                                                                            data-role="{{ $user->role }}"
                                                                            data-hospital_id="{{ $user->hospital_id }}"
                                                                            data-branch_id="{{ $user->branch_id }}">
                                                                            <em class="icon ni ni-edit"></em><span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="edit-user" >
                                                                            <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.employees.destroy', $user->id) }}" method="POST" style="display: none;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                                            <em class="icon ni ni-trash"></em><span>Delete</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No users found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                    @if ($employees->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $employees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User / Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="user-form" action="{{ route('admin.employees.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <div class="row g-3">
                            <div class="col-md-6 mb-0">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="xyz@example.com" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="07XX XXX XXX" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select user role</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="pharmacist">Pharmacist</option>
                                    <option value="lab_technician">Lab Technician</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="room" class="form-label">Room</label>
                                <input type="text" class="form-control" id="room" name="room" placeholder="Eg. R001" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                                <!-- <small class="form-text text-muted">Leave blank to keep current password when editing.</small> -->
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="modal-submit-btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Use a document ready function to ensure the DOM is fully loaded
        $(document).ready(function() {
            // Function to reset the modal form for adding a new user
            $('#addUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                
                // If the "Add User" button is clicked, reset the form.
                if (button.hasClass('btn-primary')) {
                    modal.find('.modal-title').text('Add User');
                    modal.find('#user-form').attr('action', '{{ route('admin.employees.store') }}');
                    modal.find('#form-method').val('POST');
                    modal.find('#first_name').val('');
                    modal.find('#last_name').val('');
                    modal.find('#email').val('');
                    modal.find('#phone').val('');
                    modal.find('#password').prop('required', true).closest('.mb-3').show();
                    modal.find('#modal_hospital_id').val('');
                    modal.find('#modal_branch_id').val('');
                    modal.find('#role').val('doctor');
                    modal.find('#modal-submit-btn').text('Add User');
                }
            });

            // Handle edit button click to populate the modal
            $('.edit-user').on('click', function() {
                var userId = $(this).data('id');
                var userFirstName = $(this).data('first_name');
                var userLastName = $(this).data('last_name');
                var userEmail = $(this).data('email');
                var userPhone = $(this).data('phone');
                var userRole = $(this).data('role');
                var userHospitalId = $(this).data('hospital_id');
                var userBranchId = $(this).data('branch_id');

                var modal = $('#addUserModal');

                // Set modal title and form action for editing
                modal.find('.modal-title').text('Edit User');
                modal.find('#user-form').attr('action', '{{ url('users') }}/' + userId);
                modal.find('#form-method').val('PUT'); // Use PUT for update
                modal.find('#modal-submit-btn').text('Update User');

                // Populate form fields with user data
                modal.find('#first_name').val(userFirstName);
                modal.find('#last_name').val(userLastName);
                modal.find('#email').val(userEmail);
                modal.find('#phone').val(userPhone);
                modal.find('#role').val(userRole);
                modal.find('#modal_hospital_id').val(userHospitalId);
                modal.find('#modal_branch_id').val(userBranchId);

                // Make password field optional for editing
                modal.find('#password').val('').prop('required', false);
            });
        });
    </script>
@endpush
