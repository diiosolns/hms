@extends('layouts.app')

@section('content')
    {{-- Place the HTML code here --}}
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
                                    <div class="col-sm-12 col-xl-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class1="d-flex justify-content-between align-items-center">
                                                    <div class="row g-0 col-sep col-sep-md">
                                                        <div class="col-md-6">
                                                            <div class="card-title">
                                                                <h4 class="title mb-1">MATOGORO HOSPITAL</h4>
                                                                <p class="small">Best seller of the month</p>
                                                            </div>
                                                            <div class="my-3">
                                                                <div class="amount h2 fw-bold text-primary">$42.5k</div>
                                                                <div class="smaller">You have done 69.5% more sales today.</div>
                                                            </div>
                                                            <a href="#" class="btn btn-sm btn-primary">View Activities</a>
                                                        </div>
                                                        <div class="col-md-6">



                                                            <div class="row g-0 col-sep col-sep-md">

                                                                <div class="col-sm-12 col-xl-6 g-4">
                                                                    <a href="">
                                                                    <div class="card ">
                                                                        <div class="card-body">
                                                                            <div class="card-title">
                                                                                <h4 class="title">ABC Branch</h4>
                                                                            </div>
                                                                            <div class="d-flex justify-content-between align-items-end gap g-2">
                                                                                <div class="flex-grow-1">
                                                                                    <div class="smaller">
                                                                                        <strong class="text-base">48%</strong> new visitors <span class="d-block">this week.</span>
                                                                                    </div>
                                                                                    <div class="d-flex align-items-center mt-1">
                                                                                        <div class="amount h2 mb-0 fw-bold">16,328</div>
                                                                                        <div class="change up smaller ms-1">
                                                                                            <em class="icon ni ni-trend-up"></em> 48
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="nk-chart-ecommerce-visitor">
                                                                                    <canvas data-nk-chart="bar" id="visitorChart" width="0" height="235" style="display: block; box-sizing: border-box; height: 139.881px; width: 0px;"></canvas>
                                                                                </div> -->
                                                                            </div><!-- .row -->
                                                                        </div><!-- .card-body -->
                                                                    </div><!-- .card -->
                                                                    </a>
                                                                </div>


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
                                                                                    <div class="row g-3 gx-gs">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="hospital_id" class="form-label">Select Hospital</label>
                                                                                                <div class="form-control-wrap">
                                                                                                    <div class="form-control-icon start"><em class="icon ni ni-building"></em></div>
                                                                                                    <select class="form-control" id="hospital_id" name="hospital_id" required>
                                                                                                        <option value="" disabled selected>Select a hospital</option>
                                                                                                        {{-- This part needs to be dynamically populated with hospitals --}}
                                                                                                        @foreach ($hospitals as $hospital)
                                                                                                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="branchName" class="form-label">Branch Name</label>
                                                                                                <div class="form-control-wrap">
                                                                                                    <div class="form-control-icon start"><em class="icon ni ni-plus-circle"></em></div>
                                                                                                    <input type="text" class="form-control" id="branchName" name="name" placeholder="Enter branch name" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="branchPhone" class="form-label">Contact Number</label>
                                                                                                <div class="form-control-wrap">
                                                                                                    <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                                                                                    <input type="text" class="form-control" id="branchPhone" name="contact_number" placeholder="Enter phone number" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="branchAddress" class="form-label">Branch Address</label>
                                                                                                <div class="form-control-wrap">
                                                                                                    <textarea placeholder="Enter branch address" class="form-control" id="branchAddress" name="address" rows="3" required></textarea>
                                                                                                </div>
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


                                                                <div class="col-sm-12 col-xl-6 g-4 t-4">
                                                                    <a href="#" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#addBranchModal">Add a Branch</a>
                                                                </div>
                                                            </div>

                                                            



                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .card-body -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->




                                </div>
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
                    <div class="row g-3 gx-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="hospitalName" class="form-label">Hospital Name</label>
                                <div class="form-control-wrap">
                                    <div class="form-control-icon start"><em class="icon ni ni-home"></em></div>
                                    <input type="text" class="form-control" id="hospitalName" name="name" placeholder="Enter hospital name" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label for="hospitalPhone" class="form-label">Contact Number</label>
                                                                                                <div class="form-control-wrap">
                                                                                                    <div class="form-control-icon start"><em class="icon ni ni-call"></em></div>
                                                                                                    <input type="text" class="form-control" id="hospitalPhone" name="contact_number" placeholder="Enter phone number" required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="physicalAddress" class="form-label">Physical Address</label>
                                <div class="form-control-wrap">
                                    <textarea placeholder="Enter physical address" class="form-control" id="physicalAddress" name="address" rows="3" required></textarea>
                                </div>
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




@endsection




