
<style>
        .dashboard-card {
            text-align: center; /* Center all content */
        }
        .dashboard-card .card-icon {
            font-size: 3rem; /* Make icons very large */
            display: block; /* Make the icon a block element to center it */
            margin: 0 auto 1rem; /* Center the icon and add spacing below */
        }
        .card-link {
            text-decoration: none; /* Removes underline from the link */
            color: inherit;       /* Inherits text color */
        }
        .card-link:hover {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); /* Adds a subtle shadow on hover */
            transform: translateY(-2px); /* Lifts the card slightly on hover */
            transition: all 0.3s ease-in-out; /* Smooth transition */
        }
</style>


@extends('layouts.app')

@section('content')
    
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="row g-gs">
                                {{-- Card 1: Register New Patient --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('patients.index') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-user-add"></em></div>
                                            <h5 class="title mb-3">Patient Registration</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">Create a new patient record.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->
                                
                                {{-- Card 2: Manage Appointments --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('appointments.index') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-calendar"></em></div>
                                            <h5 class="title mb-3">Manage Appointments</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">View, create, and modify appointments.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->

                                {{-- Card 3: Manage Billing --}}
                                <div class="col-md-4">
                                    {{-- Use a link tag to make the entire card clickable --}}
                                    <a href="{{ route('billing.create') }}" class="card h-100 card-link dashboard-card">
                                        <div class="card-body">
                                            <div class="card-icon text-primary"><em class="icon ni ni-wallet"></em></div>
                                            <h5 class="title mb-3">Manage Billing</h5>
                                            <div class="d-flex align-items-center justify-content-center smaller flex-wrap">
                                                <span class="text-light">Handle patient billing and payments.</span>
                                            </div>
                                        </div><!-- .card-body -->
                                    </a><!-- .card -->
                                </div><!-- .col -->
                                
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div><!-- .row -->




                    <!-- PENDING PATIENTS -->
                    <div class="row g-gs mt-4">
                        <div class="col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h4 class="title">Pending Patients</h4>
                                        </div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <li>
                                                        <div class="dropdown-header pt-2 pb-0">
                                                            <h6 class="mb-0">Options</h6>
                                                        </div>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a href="#" class="dropdown-item">Sort A-Z</a></li>
                                                    <li><a href="#" class="dropdown-item">Sort Z-A</a></li>
                                                </ul>
                                            </div><!-- dropdown -->
                                        </div>
                                    </div><!-- .card-title-group -->
                                </div><!-- .card-body -->

                                <div class="table-responsive">
                                    <table class="table table-middle mb-0">
                                        <thead class="table-light table-head-md">
                                            <tr>
                                                <th class="tb-col">
                                                    <span class="overline-title">Name</span>
                                                </th>
                                                <th class="tb-col tb-col-end tb-col-sm">
                                                    <span class="overline-title">Phone</span>
                                                </th>
                                                <th class="tb-col tb-col-end tb-col-sm">
                                                    <span class="overline-title">DOB</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Status</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($patients as $patient)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md flex-shrink-0 media-middle media-circle text-bg-info-soft">
                                                                <span class="smaller">
                                                                    {{ strtoupper(substr($patient->first_name,0,1)) }}{{ strtoupper(substr($patient->last_name,0,1)) }}
                                                                </span>
                                                            </div>
                                                            <div class="media-text">
                                                                <span class="title">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                                                                <span class="text smaller">Created {{ $patient->created_at->format('M d, Y h:i A') }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col tb-col-end tb-col-sm">
                                                        <span class="small">{{ $patient->phone ?? 'N/A' }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end tb-col-sm">
                                                        <span class="small">
                                                            {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="badge bg-primary">{{ $patient->status }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No patients found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div><!-- .table-responsive -->

                                <div class="card-footer text-center">
                                    {{ $patients->links('pagination::bootstrap-5') }}
                                </div>
                            </div><!-- .card -->
                        </div>
                    </div>
                    <!-- END PENDING PATIENTS -->



                </div>
            </div>
        </div>
    </div>
@endsection
