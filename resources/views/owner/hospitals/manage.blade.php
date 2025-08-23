@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Hospitals & Branches</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('owner.hospitals.manage') }}">Hospitals Manage</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Hospitals & Branches</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                <li>
                                    <a href="#" class="btn btn-md d-md-none btn-primary" data-bs-toggle="modal" data-bs-target="#addHospitalModal">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-primary d-none d-md-inline-flex" data-bs-toggle="modal" data-bs-target="#addHospitalModal">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Hospital</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        @foreach ($hospitals as $hospital)
                        <div class="col-sm-12 col-xl-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="card-title-group align-items-start">
                                        <div class="card-title">
                                            <h4 class="title mb-1">{{ $hospital->name }}</h4>
                                            <p class="small text-muted">{{ $hospital->address }}</p>
                                        </div>
                                        <div class="card-tools">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <em class="icon ni ni-more-v"></em>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                                    <li>
                                                                        <div class="dropdown-header pt-2 pb-0">
                                                                            <h6 class="mb-0">Quick Actions</h6>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item">Update hospital</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item">View hospital</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item">Delete hospital</a>
                                                                    </li>
                                                                </ul>
                                                            </div><!-- dropdown -->
                                                        </div>

                                        </div><!-- .card-title-group -->

                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item">
                                            <strong>Contact:</strong> {{ $hospital->contact_number }}
                                        </li>
                                    </ul>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <h6 class="mb-0">Branches</h6>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addBranchModal" data-hospital-id="{{ $hospital->id }}">Add Branch</a>
                                    </div>
                                    <hr class="my-3">
                                    <div class="row g-2">
                                        @if ($hospital->branches->isEmpty())
                                            <p class="text-muted text-center mt-3">No branches found for this hospital.</p>
                                        @endif
                                        @foreach ($hospital->branches as $branch)
                                        <div class="col-12">
                                            <div class="card text-bg-light card-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="card-title-group align-items-start">
                                                            <div class="card-title">
                                                                <h4 class="title mb-1">{{ $branch->name }}</h4>
                                                            </div>
                                                            <div class="card-tools">
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <em class="icon ni ni-more-v"></em>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end" style="">
                                                                        <li>
                                                                            <div class="dropdown-header pt-2 pb-0">
                                                                                <h6 class="mb-0">Quick Actions</h6>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <hr class="dropdown-divider">
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="dropdown-item">Update branch</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="dropdown-item">View branch</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#" class="dropdown-item">Delete branch</a>
                                                                        </li>
                                                                    </ul>
                                                                </div><!-- dropdown -->
                                                            </div>
                                                        </div><!-- .card-title-group -->
                                                    </div>




                                                    <p class="smaller text-muted mb-0">{{ $branch->address }}</p>
                                                    <p class="smaller text-muted mb-0">Contact: {{ $branch->contact_number }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div><!-- .row -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>

<!-- ADD HOSPITAL MODAL -->
<div class="modal fade" id="addHospitalModal" tabindex="-1" aria-labelledby="addHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHospitalModalLabel">Add a Hospital</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('owner.hospitals.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($errors->has('hospital_name') || $errors->has('hospital_contact_number') || $errors->has('hospital_address'))
                        <div class="alert alert-danger">
                            Please correct the errors below.
                        </div>
                    @endif
                    <div class="row g-3 gx-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="hospitalName" class="form-label">Hospital Name</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start"><em class="icon ni ni-home"></em></div>
                                    <input type="text" class="form-control @error('hospital_name') is-invalid @enderror" id="hospitalName" name="name" placeholder="Enter hospital name" value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="hospitalPhone" class="form-label">Contact Number</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                    <input type="text" class="form-control @error('hospital_contact_number') is-invalid @enderror" id="hospitalPhone" name="contact_number" placeholder="Enter phone number" value="{{ old('contact_number') }}" required>
                                </div>
                                @error('contact_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="physicalAddress" class="form-label">Physical Address</label>
                                <div class="form-control-wrap">
                                    <textarea placeholder="Enter physical address" class="form-control @error('hospital_address') is-invalid @enderror" id="physicalAddress" name="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-md btn-primary">Save Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END ADD HOSPITAL MODAL -->

<!-- ADD BRANCH MODAL -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBranchModalLabel">Add a Branch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('owner.branches.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($errors->has('branch_name') || $errors->has('branch_contact_number') || $errors->has('branch_address'))
                        <div class="alert alert-danger">
                            Please correct the errors below.
                        </div>
                    @endif
                    <div class="row g-3 gx-gs">
                        <input type="hidden" name="hospital_id" id="branchHospitalId">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="branchName" class="form-label">Branch Name</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start"><em class="icon ni ni-plus-circle"></em></div>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="branchName" name="name" placeholder="Enter branch name" value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="branchPhone" class="form-label">Contact Number</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                    <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="branchPhone" name="contact_number" placeholder="Enter phone number" value="{{ old('contact_number') }}" required>
                                </div>
                                @error('contact_number')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="branchAddress" class="form-label">Branch Address</label>
                                <div class="form-control-wrap">
                                    <textarea placeholder="Enter branch address" class="form-control @error('address') is-invalid @enderror" id="branchAddress" name="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-md btn-primary">Save Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END ADD BRANCH MODAL -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addBranchModal = document.getElementById('addBranchModal');
    addBranchModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const hospitalId = button.getAttribute('data-hospital-id');
        const hospitalIdInput = addBranchModal.querySelector('#branchHospitalId');
        hospitalIdInput.value = hospitalId;
    });
});
</script>
@endsection
