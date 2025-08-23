@extends('layouts.app')

@section('content')
    {{-- Place the HTML code here --}}
    <!-- content -->
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="row g-gs">
                        <div class="col-xxl-7">
                            <div class="row g-gs">
                                {{-- Card for Total Hospitals --}}
                                <div class="col-md-6">
                                    <a href="{{ route('owner.hospitals.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between">
                                                <div class="nk-chart-project-active js-pureknob" data-readonly="true" data-size="110" data-angle-offset="0.4" data-angle-start="1" data-angle-end="1" data-value="73" data-track-width="0.15"></div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Hospitals &  Branches</h5>
                                                    <div class="amount h1">{{ $totalHospitals }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-hospital-fill"></em>
                                                        </div>
                                                        <span class="text-light">Hospitals under management</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->

                                {{-- Card for Total Branches --}}
                                <div class="col-md-6">
                                    <a href="{{ route('owner.hospitals.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-earnings">
                                                    <canvas data-nk-chart="bar" id="branchesChart"></canvas>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Branches</h5>
                                                    <div class="amount h1">{{ $totalBranches }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-plus-circle-fill"></em>
                                                        </div>
                                                        <span class="text-light">Branches under management</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div><!-- .row -->

                    {{-- Row for new cards --}}
                    <div class="row g-gs mt-2">
                        {{-- Card for Total Employees --}}
                        <div class="col-md-6">
                            <a href="{{ route('owner.employees.manage') }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                        <div class="nk-chart-project-earnings">
                                            <canvas data-nk-chart="line" id="employeesChart"></canvas>
                                        </div>
                                        <div class="card-title mb-0 mt-4 mt-sm-0">
                                            <h5 class="title mb-3 mb-xl-5">Employees</h5>
                                            <div class="amount h1">{{ $totalEmployees }}</div>
                                            <div class="d-flex align-items-center smaller flex-wrap">
                                                <div class="change up">
                                                    <em class="icon ni ni-user-list-fill"></em>
                                                </div>
                                                <span class="text-light">Staff members across all branches</span>
                                            </div>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .card-body -->
                            </div><!-- .card -->
                            </a>
                        </div><!-- .col -->

                        {{-- Card for Total Patients --}}
                        <div class="col-md-6">
                            <a href="{{ route('owner.employees.manage') }}">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                        <div class="nk-chart-project-done js-pureknob" data-readonly="true" data-size="136" data-angle-offset="-.5" data-angle-start=".7" data-angle-end=".7" data-value="65" data-color-fg="#F24A8B" data-track-width="0.15">
                                            <span class="knob-title small text-light">Patients</span>
                                        </div>
                                        <div class="card-title mb-0 mt-4 mt-sm-0">
                                            <h5 class="title mb-3 mb-xl-5">Patients</h5>
                                            <div class="amount h1">{{ $totalPatients }}</div>
                                            <div class="d-flex align-items-center smaller flex-wrap">
                                                <div class="change up">
                                                    <em class="icon ni ni-user-fill"></em>
                                                </div>
                                                <span class="text-light">Patients in the system</span>
                                            </div>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .card-body -->
                            </div><!-- .card -->
                            </a>
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div>
            </div>
        </div>
    </div> <!-- .nk-content -->

@endsection