@extends('layouts.app')

@section('content')
    {{-- Place the HTML code here --}}
   <div class="nk-content">
                    <div class="container">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                                            <div class="nk-block-head-content">
                                                <h2 class="nk-block-title">Patient Registration Form</h2>
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
                                                            <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Manage Patients</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">Add patient</li>
                                                        </ol>
                                                    </nav>
                                            </div>
                                            <div class="nk-block-head-content">
                                                <ul class="d-flex gap g-2">
                                                    <li class="d-none d-md-block">
                                                        <a href="{{ route('patients.index') }}" class="btn btn-soft btn-primary"><em class="icon ni ni-user"></em><span>View Patients</span></a>
                                                    </li>
                                                    <li class="d-md-none">
                                                        <a href="{{ route('patients.index') }}" class="btn btn-soft btn-primary btn-icon"><em class="icon ni ni-user"></em></a>
                                                    </li>
                                                </ul>
                                            </div><!-- .nk-block-head-content -->
                                        </div><!-- .nk-block-head-between -->
                                    </div><!-- .nk-block-head -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-gutter-md">
                                        <div class="card-body">
                                            <div class="bio-block">
                                                <h4 class="bio-block-title mb-4">Register a New Patient</h4>
                                                





                                                <form action="{{ route('patients.store') }}" method="POST">
                                                    @csrf

                                                    <div class="row g-3">
                                                        <!-- First Name -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="first_name" class="form-label">First Name <span style="color: red;">*</span></label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" 
                                                                           class="form-control @error('first_name') is-invalid @enderror" 
                                                                           id="first_name" 
                                                                           name="first_name" 
                                                                           value="{{ old('first_name') }}" 
                                                                           placeholder="First name">
                                                                    @error('first_name')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Last Name -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="last_name" class="form-label">Last Name <span style="color: red;">*</span> </label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" 
                                                                           class="form-control @error('last_name') is-invalid @enderror" 
                                                                           id="last_name" 
                                                                           name="last_name" 
                                                                           value="{{ old('last_name') }}" 
                                                                           placeholder="Last name">
                                                                    @error('last_name')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Phone -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="phone" class="form-label">Phone <span style="color: red;">*</span></label>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" 
                                                                           class="form-control @error('phone') is-invalid @enderror" 
                                                                           id="phone" 
                                                                           name="phone" 
                                                                           value="{{ old('phone') }}" 
                                                                           placeholder="Phone number">
                                                                    @error('phone')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Method -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="pay_method" class="form-label">How to Pay <span style="color: red;">*</span> </label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-control @error('pay_method') is-invalid @enderror" 
                                                                            id="pay_method" 
                                                                            name="pay_method">
                                                                        <option value="Cash">Choose how to pay</option>
                                                                        <option value="Cash" {{ old('pay_method') == 'Male' ? 'selected' : '' }}>Cash</option>
                                                                        <option value="Insurance" {{ old('pay_method') == 'Female' ? 'selected' : '' }}>Insurance</option>
                                                                    </select>
                                                                    @error('pay_method')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Gender -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="gender" class="form-label">Gender <span style="color: red;">*</span> </label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                                                            id="gender" 
                                                                            name="gender">
                                                                        <option value="">Select gender</option>
                                                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                                    </select>
                                                                    @error('gender')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Email -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="email" class="form-label">Email address</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="email" 
                                                                           class="form-control @error('email') is-invalid @enderror" 
                                                                           id="email" 
                                                                           name="email" 
                                                                           value="{{ old('email') }}" 
                                                                           placeholder="Email address">
                                                                    @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Date of Birth -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="date" 
                                                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                                           id="date_of_birth" 
                                                                           name="date_of_birth" 
                                                                           value="{{ old('date_of_birth') }}">
                                                                    @error('date_of_birth')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>                                               

                                                        <!-- Address -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="address" class="form-label">Address</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" 
                                                                           class="form-control @error('address') is-invalid @enderror" 
                                                                           id="address" 
                                                                           name="address" 
                                                                           value="{{ old('address') }}" 
                                                                           placeholder="e.g. California, United States">
                                                                    @error('address')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Emergency Contact Name -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" 
                                                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                                                           id="emergency_contact_name" 
                                                                           name="emergency_contact_name" 
                                                                           value="{{ old('emergency_contact_name') }}" 
                                                                           placeholder="Emergency contact name">
                                                                    @error('emergency_contact_name')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Emergency Contact Phone -->
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="tel" 
                                                                           class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                                                           id="emergency_contact_phone" 
                                                                           name="emergency_contact_phone" 
                                                                           value="{{ old('emergency_contact_phone') }}" 
                                                                           placeholder="Emergency contact phone">
                                                                    @error('emergency_contact_phone')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
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

                                                        <!-- Avoid Nurse Switch -->
                                                        <div class="col-lg-12 g-4">
                                                            <div class="form-check form-switch form-check-lg g-2">
                                                              <input class="form-check-input" type="checkbox" name="avoid_nurse" value="yes" id="flexSwitchDefault">
                                                              <label class="form-check-label" for="flexSwitchDefault">
                                                                Avoid Nurse
                                                                <small style="color: red;"> (Turn on this switch to send Partient details to Doctor direct. Nurse will be bypassed)</small>
                                                              </label>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden hospital & branch -->
                                                        <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                                        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                                        <input type="hidden" name="patient_id" value="{{ 'PNT' . now()->format('YmdHis') . rand(100,999) }}">
                                                        <input type="hidden" name="doctor_id" value="{{ Auth::id() }}">
                                                        
                                                        <!-- Submit -->
                                                        <div class="col-lg-12">
                                                            <button class="btn btn-primary" type="submit">Save Details</button>
                                                        </div>
                                                    </div>
                                                </form>








                                            </div><!-- .bio-block -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>

@endsection