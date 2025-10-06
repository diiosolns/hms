@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Insurance Company</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('insurance_companies.index') }}">Manage Insurance Companies</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Edit Company
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('insurance_companies.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em>
                                <span>View Companies</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Update Insurance Company Details</h4>

                            <form action="{{ route('insurance_companies.update', $insuranceCompany->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    {{-- Company Name --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $insuranceCompany->name) }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Contact Person --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="contact_person" class="form-label">Contact Person</label>
                                            <input type="text"
                                                class="form-control @error('contact_person') is-invalid @enderror"
                                                id="contact_person"
                                                name="contact_person"
                                                value="{{ old('contact_person', $insuranceCompany->contact_person) }}">
                                            @error('contact_person')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="phone"
                                                name="phone"
                                                value="{{ old('phone', $insuranceCompany->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="email"
                                                name="email"
                                                value="{{ old('email', $insuranceCompany->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address"
                                                      name="address"
                                                      rows="3">{{ old('address', $insuranceCompany->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    id="status"
                                                    name="status"
                                                    required>
                                                <option value="active" {{ old('status', $insuranceCompany->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $insuranceCompany->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Hospital & Branch --}}
                                    @if(Auth::user()->role === 'owner')
                                        <div class="col-md-6">
                                            <label for="hospital_id" class="form-label">Hospital</label>
                                            <select class="form-select @error('hospital_id') is-invalid @enderror"
                                                    id="hospital_id"
                                                    name="hospital_id"
                                                    required>
                                                <option value="">Select Hospital</option>
                                                @foreach ($hospitals as $hospital)
                                                    <option value="{{ $hospital->id }}" 
                                                        {{ old('hospital_id', $insuranceCompany->hospital_id) == $hospital->id ? 'selected' : '' }}>
                                                        {{ $hospital->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('hospital_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="branch_id" class="form-label">Branch</label>
                                            <select class="form-select @error('branch_id') is-invalid @enderror"
                                                    id="branch_id"
                                                    name="branch_id"
                                                    required>
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}"
                                                        {{ old('branch_id', $insuranceCompany->branch_id) == $branch->id ? 'selected' : '' }}>
                                                        {{ $branch->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @else
                                        <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                    @endif

                                    {{-- Submit --}}
                                    <div class="col-12 mt-4">
                                        <button class="btn btn-primary" type="submit">Update Insurance Company</button>
                                    </div>
                                </div>
                            </form>

                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div> <!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
