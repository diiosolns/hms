@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Appointment</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Manage Appointments</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Appointment</li>
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
                            <h4 class="mb-4">Update Appointment Details</h4>

                            <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <!-- Patient -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Patient <span class="text-danger">*</span></label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id" data-search="true" data-sort="true">
                                                    <option value="">Select Patient</option>
                                                    @foreach($patients as $patient)
                                                        <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('patient_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Doctor -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Doctor <span class="text-danger">*</span></label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor_id" data-search="true" data-sort="true">
                                                    <option value="">Select Doctor</option>
                                                    @foreach($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}> {{ $doctor->first_name }} {{ $doctor->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Appointment Date -->
                                    <div class="col-lg-6">
                                        <label for="appointment_date" class="form-label">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                               id="appointment_date" name="appointment_date" 
                                               value="{{ old('appointment_date', $appointment->appointment_date) }}">
                                        @error('appointment_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Appointment Time -->
                                    <div class="col-lg-6">
                                        <label for="appointment_time" class="form-label">Time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" 
                                               id="appointment_time" name="appointment_time" 
                                               value="{{ old('appointment_time', $appointment->appointment_time) }}">
                                        @error('appointment_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Reason -->
                                    <div class="col-lg-12">
                                        <label for="reason" class="form-label">Reason</label>
                                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                                  id="reason" name="reason" rows="3">{{ old('reason', $appointment->reason) }}</textarea>
                                        @error('reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <div class="form-control-wrap">
                                                <select class="js-select @error('status') is-invalid @enderror" name="status" id="status" data-search="true" data-sort="false">
                                                    <option value="Scheduled" {{ old('status', $appointment->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                    <option value="Completed" {{ old('status', $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="Cancelled" {{ old('status', $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <button class="btn btn-primary" type="submit">Update Appointment</button>
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
