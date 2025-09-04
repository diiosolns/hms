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
                                            <span class="badge bg-primary">Patient ID: {{ $patient->patient_id }}</span>
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
                                                </div>
                                            </div><!-- .nk-block-head-content -->

                            </div><!-- .nk-block-head-between -->

                            <div class="nk-block-head-between gap g-2 mt-4">
                                        <div class="gap-col">
                                            <ul class="nav nav-pills nav-pills-border gap g-3" role="tablist">
                                                <li class="nav-item" >
                                                    <button class="nav-link @if(Auth::user()->role === 'receptionist') active @endif " data-bs-toggle="tab" data-bs-target="#tab-1" type="button" aria-selected="true" role="tab"> Overview </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'doctor') active @endif " data-bs-toggle="pill" data-bs-target="#pills-doctor" type="button"> Doctor </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'lab_technician') active @endif " data-bs-toggle="pill" data-bs-target="#pills-lab" type="button"> Laboratory </button>
                                                </li>
                                                <li class="nav-item" >
                                                    <button  class="nav-link @if(Auth::user()->role === 'pharmacy') active @endif " data-bs-toggle="pill" data-bs-target="#pills-pharmacy" type="button"> Pharmacy </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="gap-col">
                                            <ul class="d-flex gap g-2">
                                                {{-- If user is receptionist, show Assign Doctor button --}}
                                                @if(Auth::user()->role === 'receptionist' || Auth::user()->role === 'admin' )
                                                    <li class="d-none d-md-block">
                                                        <a href="#" class="btn btn-soft btn-primary" data-bs-toggle="modal" data-bs-target="#assignDoctorModal">
                                                            <em class="icon ni ni-plus-medi"></em>
                                                            <span>Assign a Doctor</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#assignDoctorModal">
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
                                                        <a href="" class="btn btn-soft btn-primary">
                                                            <em class="icon ni ni-activity"></em>
                                                            <span>Lab Tests</span>
                                                        </a>
                                                    </li>

                                                    <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#labTestsModal">
                                                            <em class="icon ni ni-activity"></em>
                                                        </a>
                                                    </li>

                                                    <li class="d-none d-md-block">
                                                        <a href="#" class="btn btn-soft btn-success" data-bs-toggle="modal" data-bs-target="#prescriptionsModal">
                                                            <em class="icon ni ni-activity"></em>
                                                            <span>Presscriptions</span>
                                                        </a>
                                                    </li>
                                                    <li class="d-md-none">
                                                        <a href="#" class="btn btn-soft btn-success btn-icon" data-bs-toggle="modal" data-bs-target="#prescriptionsModal">
                                                            <em class="icon ni ni-activity"></em>
                                                        </a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->

                        </div><!-- .nk-block-head -->
                        
                        <div class="nk-block">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane @if(Auth::user()->role === 'receptionist') show active @endif " id="tab-1" tabindex="0" role="tabpanel">
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
                                                                <span class="title fw-medium w-40 d-inline-block">Doctor:</span>
                                                                <span class="text">{{ $patient->doctor?->first_name ?? 'Not assigned' }} {{ $patient->doctor?->last_name ?? '' }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <span class="title fw-medium w-40 d-inline-block">Status:</span>
                                                                <span class="badge bg-primary">{{ $patient->status }}</span>
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
                                <!-- END PATIENT INVOICES -->





                                </div><!-- .tab-pane -->





                                <!-- DOCTOR TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'doctor') show active @endif  " id="pills-doctor" role="doctor">
                                    
                                    <!-- Diagnosis Card  & Treatment Plan card-->
                                    <div class="card border-light mb-0">
                                      <div class="card-header">Diagnosis & Treatment Plan</div>
                                      <div class="card-body text-light">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h5 class="card-title">Chief Complaint</h5>
                                                <p class="card-text">
                                                    {{ $latestRecord->chief_complaint ?? 'No complain yet.' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h5 class="card-title">Diagnosis</h5>
                                                <p class="card-text">
                                                    {{ $latestRecord->diagnosis ?? 'No diagnosis yet.' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h5 class="card-title">Treatment Plan</h5>
                                                <p class="card-text">
                                                    {{ $latestRecord->treatment_plan ?? 'No plan yet.' }}
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h5 class="card-title">Remarks</h5>
                                                <p class="card-text">
                                                    {{ $latestRecord->notes ?? 'NIL' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <a href="#" class="btn btn-soft btn-primary" data-bs-toggle="modal" data-bs-target="#diagnosisModal">
                                                <em class="icon ni ni-edit"></em> <span>Add / Update</span>
                                            </a>
                                        </div>
                                      </div>
                                    </div>



                                    <div class="card h-100 mt-3">
                                            <div class="col-sep">
                                                <div class="card-body py-2">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h4 class="title mb-0">Diagnosis & Treatment Plan</h4>
                                                        </div>
                                                        <div class="card-tools">
                                                            <a href="#" class="btn btn-sm btn-soft btn-primary">Add / Update</a>
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
                                                                            <img src="{{ asset('images/users/def.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Chief Complaint</strong> </p>
                                                                        <span class="smaller time">{{ $latestRecord->status ?? 'Status' }}</span>
                                                                        <p class="small">{{ $latestRecord->chief_complaint ?? 'No complain yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nk-timeline-item">
                                                                <div class="nk-timeline-item-inner">
                                                                    <div class="nk-timeline-symbol">
                                                                        <div class="media media-md media-middle media-circle">
                                                                            <img src="{{ asset('images/users/def.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Diagnosis</strong></p>
                                                                        <span class="smaller time">{{ $latestRecord->status ?? 'Status' }}</span>
                                                                        <p class="small">{{ $latestRecord->diagnosis ?? 'No diagnosis yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nk-timeline-item">
                                                                <div class="nk-timeline-item-inner">
                                                                    <div class="nk-timeline-symbol">
                                                                        <div class="media media-md media-middle media-circle">
                                                                            <img src="{{ asset('images/users/def.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="nk-timeline-content">
                                                                        <p class="small"><strong>Treatment Plan</strong></p>
                                                                        <span class="smaller time">{{ $latestRecord->status ?? 'Status' }}</span>
                                                                        <p class="small">{{ $latestRecord->treatment_plan ?? 'No plan yet.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div><!-- .nk-timeline -->
                                                </div>
                                            </div>
                                        </div>



                                     
                                       

                                        <!-- Lab Tests Card -->
                                        <div class="col-md-4">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <h6 class="title">Lab Tests</h6>
                                                    <ul class="list-unstyled">
                                                        @forelse($patient->labRequestTests as $test)
                                                            <li>✅ {{ $test->labTest->name }} ({{ $test->status }})</li>
                                                        @empty
                                                            <li class="text-muted">No lab tests requested.</li>
                                                        @endforelse
                                                    </ul>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#labTestModal">
                                                        <em class="icon ni ni-plus"></em> Request Test
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Prescriptions Card -->
                                        <div class="col-md-4">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <h6 class="title">Prescriptions</h6>
                                                    <ul class="list-unstyled">
                                                        @forelse($patient->prescriptions as $prescription)
                                                            <li>💊 {{ $prescription->drug_name }} - {{ $prescription->dosage }}</li>
                                                        @empty
                                                            <li class="text-muted">No prescriptions yet.</li>
                                                        @endforelse
                                                    </ul>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#prescriptionModal">
                                                        <em class="icon ni ni-plus"></em> Add Prescription
                                                    </button>
                                                </div>
                                            </div>
                                        </div>




                                </div><!-- .doctor tab-pane -->




                                <!-- LABORATORY TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'lab_technician') show active @endif  " id="pills-lab" role="lab">
                                    <h1>Lab Test</h1>
                                </div><!-- .lab tab-pane -->






                                <!-- PHARMACY TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'pharmacy') show active @endif  " id="pills-pharmacy" role="pharmacy">
                                    <h1>Phar</h1>
                                </div><!-- .pharmacy tab-pane -->











                            </div><!-- .tab-content -->
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
                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button>
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
<div class="modal fade" id="diagnosisModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('doctor.medical-records.updateDiagnosis', $patient->id) }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Diagnosis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" name="diagnosis" rows="4">{{ $latestRecord->diagnosis ?? '' }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Lab Test Modal -->
<div class="modal fade" id="labTestModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('doctor.lab-tests.store', $patient->id) }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Lab Tests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <select name="lab_tests[]" class="form-select" multiple required>
                    @foreach($availableTests as $test)
                        <option value="{{ $test->id }}">{{ $test->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Hold CTRL (or CMD) to select multiple tests.</small>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Request</button>
            </div>
        </div>
    </form>
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
                                    <option value="{{ $item->id }}">{{ $item->drug_name }}</option>
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
                        <option value="{{ $item->id }}">{{ $item->drug_name }}</option>
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
