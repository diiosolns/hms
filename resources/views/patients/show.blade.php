@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    {{-- Check if the patient object exists --}}
                    @if ($patient)
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <!-- <div class="media media-huge media-circle">
                                            {{-- Placeholder avatar --}}
                                            <img src="{{ asset('images/users/def.jpg') }}" class="img-thumbnail" alt="{{ $patient->first_name }}">
                                        </div> -->
                                        <div class="media media-huge media-middle media-circle text-bg-primary-soft">
                                           <span class="huge">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            {{-- Full name --}}
                                            <h3 class="title mb-1">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                                            {{-- Patient ID --}}
                                            <span class="badge text-bg-primary-soft">ID: {{ $patient->patient_id }}</span>
                                            <ul class="nk-list-option pt-1">
                                                {{-- Show branch if exists --}}
                                                @if ($patient->branch)
                                                    <li><em class="icon ni ni-building"></em>
                                                        <span class="small">{{ $patient->branch->name }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                                <div class="d-flex gap g-3">
                                                    <div class="gap-col">
                                                        <a href="#">
                                                            <div class="box-dotted py-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="h1 mb-0 text-danger">{{ number_format($totalPendingInvoices, 0) }} <span class="small">TZS</span> </div>
                                                                    <span class="change up ms-1 small">
                                                                        <em class="icon ni ni-arrow-down"></em>
                                                                    </span>
                                                                </div>
                                                                <div class="smaller">Total: {{ number_format($totalInvoices, 0) }} TZS</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    @if(Auth::user()->role === 'receptionist')
                                                    <div class="gap-col">
                                                        <div class="box-dotted bg-info-soft py-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="h4 mb-0">Direct</div>
                                                                <span class="change up ms-1 small">
                                                                    <em class="icon ni ni-arrow-up"></em>
                                                                </span>
                                                            </div>
                                                            <div class="smaller mt-3 mb-3"><a href="{{ route('patients.direct.lab', $patient->id) }}">Laboratory</a></div>
                                                            <div class="smaller "><a href="{{ route('patients.direct.pharmacy', $patient->id) }}">Pharmacy</a></div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div><!-- .nk-block-head-content -->

                            </div><!-- .nk-block-head-between -->







                            {{-- Display Success or Error Messages --}}
                            @if (session('success'))
                                <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Display Validation Errors --}}
                            @if ($errors->any())
                                <div class="mt-3 alert alert-danger alert-dismissible fade show">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            







                            <div class="nk-block-head-between gap g-2 mt-4">
                                        <div class="gap-col">
                                            <ul class="nav nav-pills nav-pills-border gap g-3" role="tablist">
                                                <li class="nav-item" >
                                                    <button class="nav-link @if(in_array(Auth::user()->role, ['receptionist', 'nurse', 'owner', 'admin'])) active @endif " data-bs-toggle="tab" data-bs-target="#tab-1" type="button" aria-selected="true" role="tab"> Overview </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'doctor') active @endif " data-bs-toggle="pill" data-bs-target="#pills-doctor" type="button"> Doctor </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'lab_technician') active @endif " data-bs-toggle="pill" data-bs-target="#pills-lab" type="button"> Laboratory </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'pharmacist') active @endif " data-bs-toggle="pill" data-bs-target="#pills-pharmacy" type="button"> Pharmacy </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="gap-col">
                                            <ul class="d-flex gap g-2">
                                                {{-- If user is receptionist, show Assign Doctor button --}}
                                                @if(Auth::user()->role === 'receptionist' || Auth::user()->role === 'admin' )
                                                    <li class="d-none d-md-block">
                                                        <a href="{{ route('patients.direct.reception', $patient->id) }}" class="btn btn-soft btn-primary" data-bs-toggle="modal" data-bs-target="#assignDoctorModal">
                                                            <em class="icon ni ni-plus-medi"></em>
                                                            <span>Assign a Doctor</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-md-none">
                                                        <a href="{{ route('patients.direct.reception', $patient->id) }}" class="btn btn-soft btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#assignDoctorModal">
                                                            <em class="icon ni ni-plus-medi"></em>
                                                        </a>
                                                    </li>
                                                {{-- If user is nurse, show Vital buttons --}}
                                                @elseif(Auth::user()->role === 'nurse')
                                                    <li class="d-none d-md-block">
                                                        <a href="#" class="btn btn-soft btn-success" data-bs-toggle="modal" data-bs-target="#updateNurseTriageModal">
                                                            <em class="icon ni ni-activity"></em>
                                                            <span>Update Vitals</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#updateNurseTriageModal">
                                                            <em class="icon ni ni-activity"></em>
                                                        </a>
                                                    </li>

                                                {{-- If user is doctor, show Vital buttons --}}
                                                @elseif(Auth::user()->role === 'doctor')
                                                    <li class="d-none d-md-block">
                                                        <a href="{{ route('doctor.patients.direct.reception', $patient->id) }}" class="btn btn-outline-danger">
                                                            <em class="icon ni ni-arrow-left"></em>
                                                            <span>Back Reception</span>
                                                        </a>
                                                    </li>

                                                    <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-primary btn-icon">
                                                            <em class="icon ni ni-activity"></em>
                                                        </a>
                                                    </li>

                                                    <!-- <li class="d-none d-md-block">
                                                        <a href="#" class="btn btn-soft btn-success" data-bs-toggle="modal" data-bs-target="#prescriptionsModal">
                                                            <em class="icon ni ni-activity"></em>
                                                            <span>Presscriptions</span>
                                                        </a>
                                                    </li> -->
                                                    <!-- <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#prescriptionsModal">
                                                            <em class="icon ni ni-activity"></em>
                                                        </a>
                                                    </li> -->
                                                @endif

                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->

                        </div><!-- .nk-block-head -->
                        
                        <div class="nk-block">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane @if(in_array(Auth::user()->role, ['receptionist', 'nurse', 'owner', 'admin'])) show active @endif " id="tab-1" tabindex="0" role="tabpanel">
                                    <div class="card card-gutter-md">
                                        <div class="card-row card-row-lg col-sep col-sep-lg">
                                            <div class="card-aside">
                                                <div class="card-body">
                                                    <div class="bio-block">
                                                        <h4 class="bio-block-title">Patient Details</h4>
                                                        <ul class="list-group list-group-borderless small">
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Patient ID:</span>
                                                                <span class="text">{{ $patient->patient_id }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Payment Method:</span>
                                                                <span class="badge @if($patient->pay_method === 'Cash') text-bg-danger-soft @else text-bg-primary-soft @endif ">{{ $patient->pay_method }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Doctor:</span>
                                                                <span class="text">{{ $patient->doctor?->first_name ?? 'Not assigned' }} {{ $patient->doctor?->last_name ?? '' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Department:</span>
                                                                <span class="badge @if($patient->status === 'Closed') bg-success @elseif($patient->status === 'Cancelled') bg-danger @elseif($patient->status === 'Discharged') bg-warning @else bg-primary @endif ">{{ $patient->status }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Room:</span>
                                                                <span class="text">{{ $patient->doctor?->room ?? 'N/A' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Date of Birth:</span>
                                                                <span class="text">
                                                                    {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'N/A' }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Gender:</span>
                                                                <span class="text">{{ $patient->gender ?? 'N/A' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Phone:</span>
                                                                <span class="text">{{ $patient->phone ?? 'Not provided' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Email:</span>
                                                                <span class="text">{{ $patient->email ?? 'Not provided' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Address:</span>
                                                                <span class="text">{{ $patient->address ?? 'Not provided' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Emergency Contact:</span>
                                                                <span class="text">
                                                                    {{ $patient->emergency_contact_name ?? 'N/A' }} 
                                                                    ({{ $patient->emergency_contact_phone ?? 'N/A' }})
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Registered On:</span>
                                                                <span class="text">{{ $patient->created_at ? $patient->created_at->format('M d, Y') : 'N/A' }}</span>
                                                            </li>
                                                        </ul>
                                                    </div><!-- .bio-block -->
                                                </div><!-- .card-body -->
                                            </div>
                                            <div class="card-content  flex-grow-0  h-100 col-sep" style="width: 100% !important;" >
                                                            <div class="card-body flex-grow-0 py-2">
                                                                <div class="card-title-group">
                                                                    <div class="card-title">
                                                                        <h4 class="bio-block-title">Nurse Vitals</h4>
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
                                                                                <li>
                                                                                    <hr class="dropdown-divider">
                                                                                </li>
                                                                                <li>
                                                                                    <a href="#" class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#updateNurseTriageModal" >Update Tests</a>
                                                                                </li>
                                                                                
                                                                            </ul>
                                                                        </div><!-- dropdown -->
                                                                    </div>
                                                                </div><!-- .card-title-group -->
                                                            </div><!-- .card-body -->
                                                            <div class="table-responsive">
                                                                <table class="table table-middle mb-0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">BT</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Body Temperature</a>
                                                                                        <span class="text smaller">Body Temperature</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->body_temperature ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">BP</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Blood Pressure</a>
                                                                                        <span class="text smaller">Systolic/ Diastolic</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->blood_pressure_systolic ?? 'NIL' }} / {{ optional($patient->nurseTriageAssessments->last())->blood_pressure_diastolic ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">HR</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Heart Rate</a>
                                                                                        <span class="text smaller">Heart Bit</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->heart_rate ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">RR</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Respiratory Rate</a>
                                                                                        <span class="text smaller">Lungs test</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->respiratory_rate ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">Kg</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Weight (Kg)</a>
                                                                                        <span class="text smaller">Kilograms</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->weight_kg ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">Cm</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Height (Cm)</a>
                                                                                        <span class="text smaller">Centimeter</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->height_cm ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">CC</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">chief_complaint</a>
                                                                                        <span class="text smaller">Patient condition</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                <span class="small">{{ optional($patient->nurseTriageAssessments->last())->chief_complaint ?? 'NIL' }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tb-col">
                                                                                <div class="media-group">
                                                                                    <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                                        <span class="smaller">NB</span>
                                                                                    </div>
                                                                                    <div class="media-text">
                                                                                        <a href="#" class="title">Nurse Remarks</a>
                                                                                        <span class="text smaller">{{ optional($patient->nurseTriageAssessments->last())->notes ?? 'NIL' }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="tb-col tb-col-end">
                                                                                
                                                                            </td>
                                                                        </tr>





                                                                    </tbody>
                                                                </table>
                                                            </div>
                                            </div><!-- .card-content -->
                                        </div><!-- .card-row -->
                                    </div><!-- .card -->






                                    <!-- PATIENT INVOICES  -->
                                    @if(in_array(Auth::user()->role, ['receptionist', 'pharmacist', 'owner', 'admin']))
                                    <div class="card h-100 mt-4">
                                        <div class="card-body flex-grow-0 py-2">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h4 class="title">Invoices</h4>
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
                                                            <span class="overline-title">Invoice No.</span>
                                                        </th>
                                                        <th class="tb-col tb-col-end tb-col-sm">
                                                            <span class="overline-title">Invoice Date</span>
                                                        </th>
                                                        <th class="tb-col tb-col-end tb-col-sm">
                                                            <span class="overline-title">Amount (TZS)</span>
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
                                                    @forelse($patient->invoices as $inv)
                                                        <tr>
                                                            <td class="tb-col ">
                                                                <span class="small">{{ $inv->invoice_number ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">
                                                                    {{ $inv->invoice_date ? \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') : 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td class="tb-col tb-col-end tb-col-sm">
                                                                <span class="small">{{ number_format($inv->total_amount, 0) }}</span>
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                @if ($inv->status == 'Paid')
                                                                    <span class="badge text-bg-success-soft">{{ $inv->status }}</span>
                                                                @else
                                                                    <span class="badge text-bg-warning-soft">{{ $inv->status }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="tb-col tb-col-end">
                                                                <a href="{{ route('invoices.show', $inv->id) }}" class="btn btn-sm btn-outline-primary">
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">No invoice found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div><!-- .table-responsive -->
                                        <div class="card-footer text-center text-primary">
                                            Make sure all bills are cleared before going to next step.
                                        </div>
                                    </div><!-- .card -->
                                    @endif
                                    <!-- END PATIENT INVOICES -->



                                </div><!-- .tab-pane -->





                                <!-- DOCTOR TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'doctor') show active @endif  " id="pills-doctor" role="doctor">
                                    
                                    <!-- Diagnosis Card  & Treatment Plan card-->
                                    <div class="card h-100 mt-3">
                                            <div class="col-sep">
                                                <div class="card-body py-2">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h4 class="title mb-0">Diagnosis & Treatment Plan</h4>
                                                        </div>
                                                        <div class="card-tools">
                                                            <a href="#" class="btn btn-sm btn-soft btn-primary"  data-bs-toggle="modal" data-bs-target="#diagnosisModal">
                                                                <em class="icon ni ni-edit"></em> <span>Add / Update</span>
                                                            </a>
                                                        </div>
                                                    </div><!-- .card-title-group -->
                                                </div><!-- .card-body -->
                                                <div class="card-body">
                                                    <div class="nk-timeline nk-timeline-center">
                                                        <ul class="nk-timeline-list">
                                                            <li class="nk-timeline-item">
                                                                <div class="nk-timeline-item-inner">
                                                                    <div class="nk-timeline-symbol">
                                                                        <div class="media media-md media-middle media-circle">
                                                                            <img src="{{ asset('images/app/diagnosis.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Chief Complaint</strong> </p>
                                                                        <span class="smaller time">Dr. {{ $patient->doctor->first_name ?? 'Status' }}</span>
                                                                        <p class="small">{{ $patient->medicalRecords[0]->chief_complaint ?? 'No complain yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nk-timeline-item">
                                                                <div class="nk-timeline-item-inner">
                                                                    <div class="nk-timeline-symbol">
                                                                        <div class="media media-md media-middle media-circle">
                                                                            <img src="{{ asset('images/app/diagnosis.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Diagnosis</strong></p>
                                                                        <span class="smaller time">Dr. {{ $patient->doctor->first_name ?? 'Status' }}</span>
                                                                        <p class="small">{{ $patient->medicalRecords[0]->diagnosis ?? 'No diagnosis yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nk-timeline-item">
                                                                <div class="nk-timeline-item-inner">
                                                                    <div class="nk-timeline-symbol">
                                                                        <div class="media media-md media-middle media-circle">
                                                                            <img src="{{ asset('images/app/diagnosis.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Treatment Plan</strong></p>
                                                                        <span class="smaller time">Dr. {{ $patient->doctor->first_name ?? 'Status' }}</span>
                                                                        <p class="small">{{ $patient->medicalRecords[0]->treatment_plan ?? 'No plan yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div><!-- .nk-timeline -->
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Lab Tests Card -->
                                        <div class="card border-light mb-3 mt-3">
                                          <div class="card-body py-2">
                                              <div class="card-title-group">
                                                  <div class="card-title">
                                                      <h4 class="title mb-0">Lab Tests</h4>
                                                  </div>
                                                  <div class="card-tools">
                                                      <a href="#" class="btn btn-sm btn-soft btn-primary"  data-bs-toggle="modal" data-bs-target="#labTestModal">
                                                          <em class="icon ni ni-edit"></em> <span>Request Test</span>
                                                      </a>
                                                  </div>
                                              </div><!-- .card-title-group -->
                                          </div><!-- .card-body -->
                                          <div class="card-body text-light">
                                            <div class="table-responsive">
                                                <table class="table table-middle mb-0">
                                                    <thead class="table-light table-head-md">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">S/N</span></th>
                                                            <th class="tb-col"><span class="overline-title">Lab Test</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Code</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Normal Rabge</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Sample</span></th>
                                                            <th class="tb-col tb-col-end"><span class="overline-title">Actions</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($patient->labRequestTests as $key => $test)
                                                            <tr>
                                                                <td class="tb-col">
                                                                    <span class="small">{{ $key + 1 }}</span>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <em class="icon ni {{ $test->status === 'Completed' ? 'ni-check-fill-c text-success' : 'ni-alert-fill text-warning' }}"></em>
                                                                    <span class="small"> {{ $test->labTest->name }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $test->labTest->code }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $test->labTest->normal_range }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $test->labTest->sample_type }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end">
                                                                    {{-- Remove Item --}}
                                                                    @if ($test->status !== 'Completed' && in_array(Auth::user()->role, [ 'admin', 'doctor']))
                                                                        <form action="{{ route('prescriptions.removeItem', [$patient->id, $test->id] ) }}" 
                                                                              method="POST" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                                                        </form>
                                                                    @elseif ($test->status === 'Completed')
                                                                        <span class="badge bg-success">Completed</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">No lab tests requested.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                            </div>
                                        </div>

                                        <!-- Prescriptions Card -->
                                        <div class="card border-light mb-3 mt-3">
                                          <div class="card-body py-2">
                                              <div class="card-title-group">
                                                  <div class="card-title">
                                                      <h4 class="title mb-0">Prescriptions</h4>
                                                  </div>
                                                  <div class="card-tools">
                                                      <a href="#" class="btn btn-sm btn-soft btn-primary"  data-bs-toggle="modal" data-bs-target="#prescriptionModal">
                                                          <em class="icon ni ni-edit"></em> <span>Add prescriptions</span>
                                                      </a>
                                                  </div>
                                              </div><!-- .card-title-group -->
                                          </div><!-- .card-body -->
                                          <div class="card-body text-light">
                                            <div class="table-responsive">
                                                <table class="table table-middle mb-0">
                                                    <thead class="table-light table-head-md">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">S/N</span></th>
                                                            <th class="tb-col"><span class="overline-title">Drug Name</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Dosage</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Frequency</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Duration</span></th>
                                                            <th class="tb-col tb-col-end"><span class="overline-title">Actions</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($patient->prescriptions as $key => $prescription)
                                                            <tr>
                                                                <td class="tb-col">
                                                                    <span class="small">{{ $key + 1 }}</span>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <span class="small">💊 {{ $prescription->drug_name }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->dosage }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->frequency }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->duration }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end">
                                                                    {{-- Remove Item --}}
                                                                    @if ($prescription->status !== 'Closed' && in_array(Auth::user()->role, [ 'admin', 'doctor']))
                                                                        <form action="{{ route('doctor.prescriptions.removeItem', [$patient->id, $prescription->id] ) }}" 
                                                                              method="POST" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                                                        </form>
                                                                    @elseif ($prescription->status === 'Closed')
                                                                        <span class="badge bg-success">Closed</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">No prescriptions yet.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                
                                            </div>
                                        </div>

                                        




                                </div><!-- .doctor tab-pane -->















                                <!-- LABORATORY TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'lab_technician') show active @endif  " id="pills-lab" role="lab">
                                    @forelse($patient->labRequestTests as $key => $test)
                                        <div class="card h-100 mt-3">
                                                <div class="col-sep">
                                                    <div class="card-body py-2">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h4 class="title mb-0">{{ $test->labTest->name }}</h4>
                                                            </div>
                                                            <div class="card-tools">
                                                                @if ($test->status !== 'Completed' && in_array(Auth::user()->role, [ 'admin', 'lab_technician']))
                                                                <a href="{{ route('lab_technician.labtests.requests' ) }}" class="btn btn-sm btn-soft btn-primary" >
                                                                    <em class="icon ni ni-edit"></em> <span>Update Results</span>
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div><!-- .card-title-group -->
                                                    </div><!-- .card-body -->
                                                    <div class="card-body">
                                                        <div class="nk-timeline nk-timeline-center">
                                                            <ul class="nk-timeline-list">
                                                                <li class="nk-timeline-item">
                                                                    <div class="nk-timeline-item-inner">
                                                                        <div class="nk-timeline-symbol">
                                                                            <div class="media media-md media-middle media-circle">
                                                                                <img src="{{ asset('images/app/lab.jpg') }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="nk-timeline-content">
                                                                            <p class="small"><strong>Test Results</strong> </p>
                                                                            <span class="smaller time">Unit: {{ $test->unit ?? 'None' }} | {{ $test->reference_range ?? '' }}</span>
                                                                            <p class="small">{{ $test->result ?? 'No results yet.' }}</p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="nk-timeline-item">
                                                                    <div class="nk-timeline-item-inner">
                                                                        <div class="nk-timeline-symbol">
                                                                            <div class="media media-md media-middle media-circle">
                                                                                <img src="{{ asset('images/app/lab4.jpg') }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="nk-timeline-content">
                                                                            <p class="small"><strong>Attachment</strong></p>
                                                                            <!-- <span class="smaller time">pdf/ Image file </span> -->
                                                                            @if($test->attachment)
                                                                                <a href="{{ asset('storage/' . $test->attachment) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                    <em class="icon ni ni-eye"></em> Preview
                                                                                </a>

                                                                                <a href="{{ asset('storage/' . $test->attachment) }}" download class="btn btn-sm btn-secondary">
                                                                                    <em class="icon ni ni-download"></em> Download
                                                                                </a>
                                                                            @else
                                                                                <p class="small">No attachment yet.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div><!-- .nk-timeline -->
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                          <div>
                                              <p>No lab tests requested.</p>
                                          </div>
                                        @endforelse

                                </div><!-- .lab tab-pane -->






                                <!-- PHARMACY TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'pharmacist') show active @endif  " id="pills-pharmacy" role="pharmacy">
                                    <!-- Prescriptions Card -->
                                        <div class="card border-light mb-3 mt-3">
                                          <div class="card-body py-2">
                                              <div class="card-title-group">
                                                  <div class="card-title">
                                                      <h4 class="title mb-0">Prescriptions</h4>
                                                  </div>
                                                  <div class="card-tools">
                                                  </div>
                                              </div><!-- .card-title-group -->
                                          </div><!-- .card-body -->
                                          <div class="card-body text-light">
                                            <div class="table-responsive">
                                                <table class="table table-middle mb-0">
                                                    <thead class="table-light table-head-md">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">S/N</span></th>
                                                            <th class="tb-col"><span class="overline-title">Drug Name</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Dosage</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Frequency</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Duration</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Qnty</span></th>
                                                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Dispensed Qnty</span></th>
                                                            <th class="tb-col tb-col-end"><span class="overline-title">Actions</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($patient->prescriptions as $key => $prescription)
                                                            <tr>
                                                                <td class="tb-col">
                                                                    <span class="small">{{ $key + 1 }}</span>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <span class="small">💊 {{ $prescription->drug_name }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->dosage }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->frequency }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->duration }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->quantity }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end tb-col-sm">
                                                                    <span class="small">{{ $prescription->dispensed_qty }}</span>
                                                                </td>
                                                                <td class="tb-col tb-col-end">
                                                                    {{-- Remove Item --}}
                                                                    @if ($prescription->status !== 'Dispensed' && in_array(Auth::user()->role, [ 'admin', 'pharmacist']))
                                                                        <button type="submit" class="btn btn-sm btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#dispenseModal{{ $prescription->id }}" >Dispense</button>
                                                                    @elseif ($prescription->status === 'Dispensed')
                                                                        <span class="badge bg-success">Dispensed</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <!-- Dispense Prescriptions Modal -->
                                                            <div class="modal fade" id="dispenseModal{{ $prescription->id }}" tabindex="-1" aria-labelledby="dispenseModalLabel{{ $prescription->id }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="updateNurseTriageModalLabel">💊 {{ $prescription->drug_name }}</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <form action="{{ route('pharmacist.medical-records.updateDispense', $prescription->id) }}" method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="row g-3 gx-gs">
                                                                                    <div class="col-md-12">   
                                                                                        <div class="form-group">
                                                                                            <label for="dispensed_qty" class="form-label">Dispensed Quantity</label>
                                                                                            <div class="form-control-wrap">
                                                                                                <!-- <div class="form-control-hint"><span>The quantity exactly given to patient</span></div> -->
                                                                                                <input type="number" name="dispensed_qty" class="form-control" id="dispensed_qty" placeholder="Enter quantity give to patient">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="status" value="Closed">
                                                                                <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                                                                                <button type="submit" class="btn btn-md btn-primary">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Dispense Prescriptions Modal -->
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">No prescriptions yet.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                            <div class="card-footer">   
                                            </div>
                                        </div>
                                    
                                </div><!-- .pharmacy tab-pane -->




                            </div><!-- .tab-content -->




                            <!-- OUTSIDE TABS -->
                            <!-- REPORTS BUTTON GROUP     -->
                                    @if(in_array(Auth::user()->role, ['receptionist', 'owner', 'admin']))
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="card-title mb-2">
                                                <h4 class="bio-block-title">Download Partient Reports</h4>
                                            </div>
                                            <div class="list-group-dotted " style="padding-left: 20px !important;">
                                                <div class="row mt-2">
                                                    <div class="mb-2 col-md-9">
                                                        View and download detailed billing summaries for this patient, including charges, payments, and outstanding balances.
                                                    </div>
                                                    <div class="mb-2 col-md-3 text-light">
                                                        <a href="{{ route('reports.patient.billing', $patient->id) }}" class="btn btn-outline-primary">
                                                            Billing Report
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-group-dotted " style="padding-left: 20px !important;">
                                                <div class="row mt-2">
                                                    <div class="mb-2 col-md-9">
                                                        Download detailed records of this patient treatments, diagnoses, and prescribed medications.
                                                    </div>
                                                    <div class="mb-2 col-md-3 text-light">
                                                        <a href="{{ route('reports.patient.treatments', $patient->id) }}" class="btn btn-outline-primary">
                                                            Treatment Report
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                    <!-- END CLOSE BUTTON GROUP -->

                                    <!-- CLOSE BUTTON GROUP     -->
                                    @if(in_array(Auth::user()->role, ['receptionist', 'pharmacist', 'owner', 'admin']))
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="card-title mb-2">
                                                <h4 class="bio-block-title">Finalize Patient Record</h4>
                                            </div>
                                            <div class="list-group-dotted " style="padding-left: 20px !important;">
                                                <div class="row mt-2">
                                                    <div class="mb-2 col-md-9">
                                                        Closing this file will mark the patient’s case as completed. Ensure that all necessary information and actions have been taken before closing.
                                                    </div>
                                                    <div class="mb-2 col-md-3 text-light">
                                                        <form id="closeForm" action="{{ route('patients.updateStatus', $patient->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Closed">
                                                        </form>
                                                        <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirmAction('closeForm', 'Are you sure you want to close this patient record?')">
                                                            Close Treatment File
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-group-dotted " style="padding-left: 20px !important;">
                                                <div class="row mt-2">
                                                    <div class="mb-2 col-md-9">
                                                        Discharging this patient will finalize their treatment records. No further updates or edits will be allowed after discharge. Please confirm that all medical notes, prescriptions, and tests have been completed before proceeding.
                                                    </div>
                                                    <div class="mb-2 col-md-3 text-light">
                                                        <form id="dischargeForm" action="{{ route('patients.updateStatus', $patient->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Discharged">
                                                        </form>
                                                        <button type="button" class="btn btn-outline-primary"
                                                                onclick="confirmAction('dischargeForm', 'Are you sure you want to discharge this patient?')">
                                                            Discharge Partient
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-group-dotted " style="padding-left: 20px !important;">
                                                <div class="row mt-2">
                                                    <div class="mb-2 col-md-9">
                                                        Cancelling this file will stop all ongoing processes for this patient. Please confirm that this action is intended, as it cannot be reversed.
                                                    </div>
                                                    <div class="mb-2 col-md-3 text-light">
                                                        <form id="cancelForm" action="{{ route('patients.updateStatus', $patient->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="Cancelled">
                                                        </form>
                                                        <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirmAction('cancelForm', 'Are you sure you want to cancel this patient?')">
                                                            Cancel Treatment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function confirmAction(formId, message) {
                                            if (confirm(message)) {
                                                document.getElementById(formId).submit();
                                            }
                                        }
                                    </script>
                                    @endif
                                    <!-- END CLOSE BUTTON GROUP -->
                            <!-- END OUTSIDE TABS -->



                        </div><!-- .nk-block -->
                    @else
                        {{-- Show a message if the patient is not found --}}
                        <div class="alert alert-danger" role="alert">
                            Patient not found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>











                    














<!-- UPDATE NURSE TRIAGE ASSESSMENT MODAL -->
<div class="modal fade" id="updateNurseTriageModal" tabindex="-1" aria-labelledby="updateNurseTriageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNurseTriageModalLabel">Update Nurse Triage Assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('nurse-triage-assessments.update', optional($patient->nurseTriageAssessments->last())->id ?? 0) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="appointment_id" value="{{ optional($patient->appointments->last())->id ?? '' }}">
                    <input type="hidden" name="nurse_id" value="{{ Auth::id() }}">

                    <div class="row g-3 gx-gs">
                        <div class="col-md-3">
                            <label class="form-label">Body Temperature (°C)</label>
                            <input type="number" step="0.1" name="body_temperature" class="form-control"
                                   value="{{ old('body_temperature', $assessment->body_temperature ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Blood Pressure (Systolic)</label>
                            <input type="number" name="blood_pressure_systolic" class="form-control"
                                   value="{{ old('blood_pressure_systolic', $assessment->blood_pressure_systolic ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Blood Pressure (Diastolic)</label>
                            <input type="number" name="blood_pressure_diastolic" class="form-control"
                                   value="{{ old('blood_pressure_diastolic', $assessment->blood_pressure_diastolic ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Heart Rate (bpm)</label>
                            <input type="number" name="heart_rate" class="form-control"
                                   value="{{ old('heart_rate', $assessment->heart_rate ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Respiratory Rate (breaths/min)</label>
                            <input type="number" name="respiratory_rate" class="form-control"
                                   value="{{ old('respiratory_rate', $assessment->respiratory_rate ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight_kg" class="form-control"
                                   value="{{ old('weight_kg', $assessment->weight_kg ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" name="height_cm" class="form-control"
                                   value="{{ old('height_cm', $assessment->height_cm ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Chief Complaint</label>
                            <textarea name="chief_complaint" class="form-control" rows="2">{{ old('chief_complaint', $assessment->chief_complaint ?? '') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $assessment->notes ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="status" value="Updated">
                    <!-- <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-md btn-primary">Update Vitals</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END UPDATE NURSE TRIAGE ASSESSMENT MODAL -->



<!-- ASSIGN A DOCTOR MODAL -->
<div class="modal fade" id="assignDoctorModal" tabindex="-1" aria-labelledby="assignDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNurseTriageModalLabel">Assign a Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- BRANCH DOCTORS WITH PENDING PATIENTS -->
                <table class="table table-middle mb-0">
                    <thead class="table-light table-head-md">
                        <tr>
                            <th class="tb-col"><span class="overline-title">Doctor</span></th>
                            <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Room</span></th>
                            <th class="tb-col tb-col-end"><span class="overline-title">Pending Patients</span></th>
                            <th class="tb-col tb-col-end"><span class="overline-title">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                        <tr>
                            <td class="tb-col">
                                <div class="media-group">
                                    <div class="media media-md flex-shrink-0 media-middle media-circle text-bg-info-soft">
                                        <span class="smaller">
                                            {{ strtoupper(substr($doctor->first_name,0,1)) }}{{ strtoupper(substr($doctor->last_name,0,1)) }}
                                        </span>
                                    </div>
                                    <div class="media-text">
                                        <span class="title">{{ $doctor->first_name }} {{ $doctor->last_name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tb-col tb-col-end tb-col-sm">
                                <span class="small">{{ $doctor->room ?? 'N/A' }}</span>
                            </td>
                            <td class="tb-col tb-col-end">
                                <span class="badge bg-warning">{{ $doctor->patients()->whereNotIn('status', ['Closed', 'Cancelled'])->count() }}</span>
                            </td>
                            <td>
                                <form action="{{ route('patients.assign', $doctor->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        Assign
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No doctors found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- END BRANCH DOCTORS -->
            </div>
            <div class="modal-footer text-center">
                {{ $doctors->links('pagination::bootstrap-5') }}
            </div>
            
        </div>
    </div>
</div>
<!-- END ASSIGN A DOCTOR MODAL -->


<!-- Diagnosis Modal -->
<div class="modal fade" id="diagnosisModal" tabindex="-1" aria-labelledby="diagnosisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNurseTriageModalLabel">Update Diagnosis &Treatment Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('doctor.medical-records.updateDiagnosis', $patient->id) }}" method="POST">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="appointment_id" value="{{ optional($patient->appointments->last())->id ?? '' }}">
                    <input type="hidden" name="nurse_id" value="{{ Auth::id() }}">
                    
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="chief_complaint" class="form-label">Chief Complaint</label>
                                <div class="form-control-wrap">
                                    <textarea name="chief_complaint" placeholder="Enter chief complaint" class="form-control" id="chief_complaint" rows="3">{{ $patient->medicalRecords[0]->chief_complaint ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <div class="form-control-wrap">
                                    <textarea name="diagnosis" placeholder="Enter diagnosis" class="form-control" id="diagnosis" rows="3">{{ $patient->medicalRecords[0]->diagnosis ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="treatment_plan" class="form-label">Treatment Plan</label>
                                <div class="form-control-wrap">
                                    <textarea name="treatment_plan" placeholder="Enter treatment plan" class="form-control" id="treatment_plan" rows="3">{{ $patient->medicalRecords[0]->treatment_plan ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="notes" class="form-label">Remarks</label>
                                <div class="form-control-wrap">
                                    <textarea name="notes" placeholder="Enter treatment plan" class="form-control" id="notes" rows="3">{{ $patient->medicalRecords[0]->notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="status" value="Pending">
                    <!-- <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-md btn-primary">Save Details</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Lab Test Modal -->
<div class="modal fade" id="labTestModal" tabindex="-1" aria-labelledby="labTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNurseTriageModalLabel">Request Lab Tests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('doctor.lab-tests.store', $patient->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                    <input type="hidden" name="hospital_id" value="{{ $patient->hospital_id }}">
                    <input type="hidden" name="branch_id" value="{{ $patient->branch_id }}">
                    <input type="hidden" name="appointment_id" value="{{ optional($patient->appointments->last())->id ?? '' }}">
                    <input type="hidden" name="nurse_id" value="{{ Auth::id() }}">
                    
                    <div class="row g-3 gx-gs">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label for="lab_tests" class="form-label">Choose Lab Tests to Request</label>
                                <div class="form-control-wrap">
                                    <select name="lab_tests[]" class="form-select" id="labTests" multiple aria-label="Choose lab tests">
                                        @foreach($availableTests as $test)
                                            <option value="{{ $test->id }}">{{ $test->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <small class="text-primary">Hold CTRL (or CMD) to select multiple tests.</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="status" value="Pending">
                    <!-- <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-md btn-primary">Request</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Prescription Modal -->
<div class="modal fade" id="prescriptionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('doctor.prescriptions.store', $patient->id) }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="prescription-list">
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <select name="prescriptions[0][pharmacy_items_id]" class="form-select" required>
                                @foreach($pharmacyItems as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="prescriptions[0][dosage]" class="form-control" placeholder="Dosage" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="prescriptions[0][frequency]" class="form-control" placeholder="Frequency">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="prescriptions[0][duration]" class="form-control" placeholder="Duration">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="prescriptions[0][quantity]" class="form-control" placeholder="Qty" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addPrescriptionRow()">+ Add More</button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Prescriptions</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
let prescriptionIndex = 1;
function addPrescriptionRow() {
    let container = document.getElementById('prescription-list');
    let row = `
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <select name="prescriptions[${prescriptionIndex}][pharmacy_items_id]" class="form-select" required>
                    @foreach($pharmacyItems as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][dosage]" class="form-control" placeholder="Dosage" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][frequency]" class="form-control" placeholder="Frequency">
            </div>
            <div class="col-md-2">
                <input type="text" name="prescriptions[${prescriptionIndex}][duration]" class="form-control" placeholder="Duration">
            </div>
            <div class="col-md-2">
                <input type="number" name="prescriptions[${prescriptionIndex}][quantity]" class="form-control" placeholder="Qty" required>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', row);
    prescriptionIndex++;
}
</script>







@endsection
