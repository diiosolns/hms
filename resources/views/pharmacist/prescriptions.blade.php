@extends('layouts.app')

@section('content')
    
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block-head">
                                    <div class="nk-block-head-between flex-wrap gap g-2">
                                        <div class="nk-block-head-content">
                                            <h2 class="nk-block-title">Patients Prescriptions</h2>
                                                <nav>
                                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                                        @if(Auth::user()->role === 'receptionist')
                                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'nurse')
                                                        <li class="breadcrumb-item"><a href="{{ route('nurse.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'doctor')
                                                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'pharmacist')
                                                        <li class="breadcrumb-item"><a href="{{ route('pharmacist.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'lab_technician')
                                                        <li class="breadcrumb-item"><a href="{{ route('lab_technician.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'admin')
                                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                                        @elseif(Auth::user()->role === 'owner')
                                                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                                                        @endif

                                                        @if(Auth::user()->role === 'pharmacist')
                                                        <li class="breadcrumb-item"><a href="{{ route('pharmacist.prescriptions') }}">Prescriptions</a></li>
                                                        @endif
                                                        <li class="breadcrumb-item active" aria-current="page">Dispense Prescriptions</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            
                                        </div>
                                    </div><!-- .nk-block-head-between -->
                                </div><!-- .nk-block-head -->



                
                    <!-- PATIENTS PENDING PRESCRIPTIONS -->
                    <div class="row g-gs mt-4">
                        <div class="col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h4 class="title">Prescriptions</h4>
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
                                                    <span class="overline-title">Patient Name</span>
                                                </th>
                                                <th class="tb-col tb-col-end tb-col-sm">
                                                    <span class="overline-title">Phone</span>
                                                </th>
                                                <th class="tb-col tb-col-end tb-col-sm">
                                                    <span class="overline-title">Doctor</span>
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
                                                            {{ $patient->doctor->first_name ?? 'N/A' }} 
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
                                                    <td colspan="5" class="text-center text-muted">No pending found.</td>
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
                    <!-- END PATIENTS PENDING PRESCRIPTIONS -->




                </div>
            </div>
        </div>
    </div>
@endsection
