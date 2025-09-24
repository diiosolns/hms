
<style>
    .dash:hover {
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
                        <div class="col-sm-4 col-xl-3">
                            <a href="{{ route('patients.index') }}" >
                            <div class="card h-100 overflow-hidden dash">
                                <div class="card-body pb-0">
                                    <div class="card-title-group">
                                        <div class="media-group">
                                            <div class="media media-sm media-middle media-circle text-bg-primary">
                                                <em class="icon ni ni-user-add"></em>
                                            </div>
                                            <div class="media-text">
                                                <h4>Patients</h4>
                                            </div>
                                        </div><!-- .media-group -->
                                        <div class="card-tools">
                                        </div>
                                    </div><!-- .card-title-group -->
                                    <div class="amount-wrap mt-3">
                                        <div class="amount h2 mb-2">{{ number_format($totalPatients) }}</div>
                                        <div class="d-flex flex-wrap align-items-center gap g-1">
                                            <div class="gap-col">
                                                <span class="badge text-bg-secondary-soft">
                                                    <em class="icon ni ni-users-fill"></em> Male {{ number_format($malePatients) }} </span>
                                            </div>
                                            <div class="gap-col">
                                                <span class="badge text-bg-secondary-soft">
                                                <em class="icon ni ni-users"></em> Female {{ number_format($femalePatients) }}</span>
                                            </div>
                                        </div>
                                    </div><!-- .amount-wrap -->
                                </div><!-- .card-body -->
                                <div class="mb-3">
                                </div>
                            </div><!-- .card -->
                            </a>
                        </div>

                        <div class="col-sm-4 col-xl-3">
                            <a href="{{ route('appointments.index') }}" >
                            <div class="card h-100 overflow-hidden dash">
                                <div class="card-body pb-0">
                                    <div class="card-title-group">
                                        <div class="media-group">
                                            <div class="media media-sm media-middle media-circle text-bg-primary">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <div class="media-text">
                                                <h4>Appointments</h4>
                                            </div>
                                        </div><!-- .media-group -->
                                        <div class="card-tools">
                                        </div>
                                    </div><!-- .card-title-group -->
                                    <div class="amount-wrap mt-3">
                                        <div class="amount h2 mb-2">{{ number_format($scheduledAppointments) }}</div>
                                        <div class="d-flex flex-wrap align-items-center gap g-1">
                                            <div class="gap-col">
                                                <span class="badge text-bg-secondary-soft">
                                                    <em class="icon ni ni-users-fill"></em> Male {{ number_format($maleAppointments) }} </span>
                                            </div>
                                            <div class="gap-col">
                                                <span class="badge text-bg-secondary-soft">
                                                <em class="icon ni ni-users"></em> Female {{ number_format($femaleAppointments) }}</span>
                                            </div>
                                        </div>
                                    </div><!-- .amount-wrap -->
                                </div><!-- .card-body -->
                                <div class="mb-3">
                                </div>
                            </div><!-- .card -->
                            </a>
                        </div>

                        <div class="col-sm-4 col-xl-3">
                            <a href="{{ route('receptionist.billing.index') }}" >
                            <div class="card h-100 overflow-hidden dash">
                                <div class="card-body pb-0">
                                    <div class="card-title-group">
                                        <div class="media-group">
                                            <div class="media media-sm media-middle media-circle text-bg-primary">
                                                <em class="icon ni ni-wallet"></em>
                                            </div>
                                            <div class="media-text">
                                                <h4>Billing</h4>
                                            </div>
                                        </div><!-- .media-group -->
                                        <div class="card-tools">
                                        </div>
                                    </div><!-- .card-title-group -->
                                    <div class="amount-wrap mt-3">
                                        <div class="amount h2 mb-2">{{ number_format($pendingInvoices) }} <small class="small txt-light">Pending Invoices</small> </div>
                                        <div class="d-flex flex-wrap align-items-center gap g-1">
                                            <div class="gap-col">
                                                <span class="badge text-bg-primary-soft">
                                                    <em class="icon ni ni-wallet-fill"></em> Cash {{ number_format($pendingCashInvoices) }} </span>
                                            </div>
                                            <div class="gap-col">
                                                <span class="badge text-bg-info-soft">
                                                <em class="icon ni ni-wallet"></em> Insurance {{ number_format($pendingInvoices - $pendingCashInvoices) }}</span>
                                            </div>
                                        </div>
                                    </div><!-- .amount-wrap -->
                                </div><!-- .card-body -->
                                <div class="mb-3">
                                </div>
                            </div><!-- .card -->
                            </a>
                        </div>
                    </div>




                    <!-- PATIENTS SENT BY DOCTOR -->
                    <div class="row g-gs mt-4">
                        <div class="col-xxl-12">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h4 class="title">Patients Sent by Doctor</h4>
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
                                                    <span class="overline-title">Pay Method</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Department</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Doctor</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($doctor_patients as $patient)
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
                                                        <span class="badge @if($patient->pay_method === 'Cash') text-bg-danger-soft @else text-bg-primary-soft @endif">{{ $patient->pay_method ?? 'Cash' }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="badge bg-primary">{{ $patient->status }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="small">{{ $patient->doctor ? $patient->doctor->first_name . ' ' . $patient->doctor->last_name : 'N/A' }}</span>
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
                    <!-- END PATIENTS SENT BY DOCTOR -->







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
                                                    <span class="overline-title">Pay Method</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Department</span>
                                                </th>
                                                <th class="tb-col tb-col-end">
                                                    <span class="overline-title">Doctor</span>
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
                                                        <span class="badge @if($patient->pay_method === 'Cash') text-bg-danger-soft @else text-bg-primary-soft @endif">{{ $patient->pay_method ?? 'Cash' }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="badge bg-primary">{{ $patient->status }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <span class="small">{{ $patient->doctor ? $patient->doctor->first_name . ' ' . $patient->doctor->last_name : 'N/A' }}</span>
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
