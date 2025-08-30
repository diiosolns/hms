@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Appointment</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    @if(Auth::user()->role === 'receptionist')
                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'doctor')
                                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'admin')
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    @if(Auth::user()->role === 'receptionist')
                                        <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Manage Appointments</a></li>
                                    @elseif(Auth::user()->role === 'doctor')
                                        <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Manage Appointments</a></li>
                                    @elseif(Auth::user()->role === 'admin')
                                        <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Manage Appointments</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">Add Appointment</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.appointments.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-calendar"></em><span>View Appointments</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Register a New Appointment</h4>

                            <form action="{{ route('admin.appointments.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">

                                    <!-- Patient -->
                                    <div class="col-lg-6">
                                        <label for="patient_id" class="form-label">Patient <span class="text-danger">*</span></label>
                                        <select class="form-control @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
                                            <option value="">Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('patient_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Doctor -->
                                    <div class="col-lg-6">
                                        <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
                                        <select class="form-control @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor_id">
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->first_name }} {{ $doctor->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Service -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Service</label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('service_id') is-invalid @enderror" name="service_id" id="service_id" data-search="true" data-sort="false">
                                                    <option value="1">Select Service (Optional)</option>
                                                    @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('service_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Appointment Date -->
                                    <div class="col-lg-6">
                                        <label for="appointment_date" class="form-label">Appointment Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                            id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}">
                                        @error('appointment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Appointment Time -->
                                    <div class="col-lg-6">
                                        <label for="appointment_time" class="form-label">Appointment Time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" 
                                            id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}">
                                        @error('appointment_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Reason -->
                                    <div class="col-lg-12">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3">{{ old('reason') }}</textarea>
                                        @error('reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-6">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                                            <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Hidden hospital & branch -->
                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                    <div class="col-lg-12 mt-3">
                                        <button class="btn btn-primary" type="submit">Save Appointment</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
