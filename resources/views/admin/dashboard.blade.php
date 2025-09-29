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
                            {{-- Row for new cards --}}
                            <div class="row g-gs ">
                                {{-- Card for Total Users --}}
                                <div class="col-md-12">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-earnings">
                                                    <canvas data-nk-chart="line" id="employeesChart"></canvas>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Users</h5>
                                                    <div class="amount h1">{{ $totalUsers }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-user-list-fill"></em>
                                                        </div>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $receptionists }} Receptionists </span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $nurses }} Nurses </span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $doctors }} Doctors </span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $pharmacists }} Pharmacists </span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $lab_tchnicians }} Lab Technicians </span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->

                                {{-- Card for Total Patients --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-done js-pureknob" data-readonly="true" data-size="136" data-angle-offset="-.5" data-angle-start=".7" data-angle-end=".7" data-value="{{ $totalPatients > 0 ? round(100 * ($malePatients / $totalPatients), 2) : 0 }}" data-color-fg="#F24A8B" data-track-width="0.15">
                                                    <span class="knob-title small text-light">Male</span>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Patients</h5>
                                                    <div class="amount h1">{{ $totalPatients }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-user-fill"></em>
                                                        </div>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $malePatients }} Male</span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $femalePatients }} Female</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->

                                {{-- Card for Total Appointments --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.appointments.index') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-done js-pureknob" data-readonly="true" data-size="136" data-angle-offset="-.5" data-angle-start=".7" data-angle-end=".7" data-value="{{ $scheduledAppointments > 0 ? round(100 * ($maleAppointments / $scheduledAppointments), 2) : 0 }}" data-color-fg="#F24A8B" data-track-width="0.15">
                                                    <span class="knob-title small text-light">Male</span>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Appointments</h5>
                                                    <div class="amount h1">{{ $scheduledAppointments }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-user-fill"></em>
                                                        </div>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $maleAppointments }} Male</span>
                                                        <span class="text-light badge text-bg-primary-soft m-1">{{ $femaleAppointments }} Female</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->
                            </div><!-- .row -->



                            <div class="row g-gs mt-2">
                                {{-- Card for Total Hospitals --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between">
                                                <div class="nk-chart-project-active js-pureknob" data-readonly="true" data-size="110" data-angle-offset="0.4" data-angle-start="1" data-angle-end="1" data-value="{{ ($paidCashInvoices+$paidNonCashInvoices) > 0 ? round(100 * ($paidCashInvoices / ($paidCashInvoices+$paidNonCashInvoices)), 2) : 0 }}" data-track-width="0.15"></div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Total Ammount</h5>
                                                    <div class="amount h1 text-success">{{ number_format($paidCashInvoices + $paidNonCashInvoices, 0); }} <small> TZS</small></div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-hospital-fill"></em>
                                                        </div>
                                                        <span class="text-light badge text-bg-success-soft m-1">Cash: {{ number_format($paidCashInvoices, 0); }}/=</span>
                                                        <span class="text-light badge text-bg-success-soft m-1">Other: {{ number_format($paidNonCashInvoices, 0); }}/=</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->

                                {{-- Card for Total Pharmacy --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-done js-pureknob" data-readonly="true" data-size="136" data-angle-offset="-.5" data-angle-start=".7" data-angle-end=".7" data-value="{{ ($pendingCashInvoices+$pendingNonCashInvoices) > 0 ? round(100 * ($pendingCashInvoices / ($pendingCashInvoices+$pendingNonCashInvoices)), 2) : 0 }}" data-track-width="0.15">
                                                    <span class="knob-title small text-light">Cash</span>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Pendning Invoices</h5>
                                                    <div class="amount h1 text-danger">{{ number_format($pendingCashInvoices + $pendingNonCashInvoices, 0); }} <small> TZS</small></div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-hospital-fill"></em>
                                                        </div>
                                                        <span class="text-light badge text-bg-danger-soft m-1">Cash: {{ number_format($pendingCashInvoices, 0); }}</span>
                                                        <span class="text-light badge text-bg-danger-soft m-1">Other: {{ number_format($pendingNonCashInvoices, 0); }}</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->
                            </div><!-- .row -->

                            

                            <div class="row g-gs mt-2">
                                {{-- Card for Total Hospitals --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between">
                                                <div class="nk-chart-project-active js-pureknob" data-readonly="true" data-size="110" data-angle-offset="0.4" data-angle-start="1" data-angle-end="1" data-value="{{ $totalPatients > 0 ? round(100 * ($malePatients / $totalPatients), 2) : 0 }}" data-track-width="0.15"></div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Laboratory</h5>
                                                    <div class="amount h1">{{ $totalPatients }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-hospital-fill"></em>
                                                        </div>
                                                        <span class="text-light">Laboratory tests</span>
                                                    </div>
                                                </div>
                                            </div><!-- .row -->
                                        </div><!-- .card-body -->
                                    </div><!-- .card -->
                                    </a>
                                </div><!-- .col -->

                                {{-- Card for Total Pharmacy --}}
                                <div class="col-md-6">
                                    <a href="{{ route('admin.employees.manage') }}">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex flex-column flex-sm-row-reverse align-items-sm-center justify-content-sm-between gx-xl-5">
                                                <div class="nk-chart-project-earnings">
                                                    <canvas data-nk-chart="bar" id="branchesChart"></canvas>
                                                </div>
                                                <div class="card-title mb-0 mt-4 mt-sm-0">
                                                    <h5 class="title mb-3 mb-xl-5">Pharmacy</h5>
                                                    <div class="amount h1">{{ $totalPatients }}</div>
                                                    <div class="d-flex align-items-center smaller flex-wrap">
                                                        <div class="change up">
                                                            <em class="icon ni ni-plus-circle-fill"></em>
                                                        </div>
                                                        <span class="text-light">Pharmacy Catalogy</span>
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




                    



                        </div><!-- .col -->
                    </div><!-- .row -->

                    
                </div>
            </div>
        </div>
    </div> <!-- .nk-content -->

@endsection