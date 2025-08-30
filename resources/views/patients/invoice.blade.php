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
                                                                    <div class="h1 mb-0 text-danger">{{ number_format($totalPendingInvoices, 0) }}</div>
                                                                    <span class="change up ms-1 small">
                                                                        <em class="icon ni ni-arrow-down"></em>
                                                                    </span>
                                                                </div>
                                                                <div class="smaller">Total: {{ number_format($totalInvoices, 2) }} TZS</div>
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
                                                            <div class="smaller"><a href="">Laboratory</a></div>
                                                            <div class="smaller"><a href="">Pharmacy</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head-content -->

                            </div><!-- .nk-block-head-between -->

                            <div class="nk-block-head-between gap g-2 mt-4">
                                        <div class="gap-col">
                                            <ul class="nav nav-pills nav-pills-border gap g-3" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-1" type="button" aria-selected="true" role="tab"> Overview </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" type="button" aria-selected="false" tabindex="-1" role="tab"> Doctor </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" type="button" aria-selected="false" tabindex="-1" role="tab"> Laboratory </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" type="button" aria-selected="false" tabindex="-1" role="tab"> Pharmacy </button>
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
                                                        <a href="#" class="btn btn-soft btn-primary" data-bs-toggle="modal" data-bs-target="#labTestsModal">
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
                                <div class="tab-pane show active" id="tab-1" tabindex="0" role="tabpanel">
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
                                </div><!-- .tab-pane -->
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

@endsection
