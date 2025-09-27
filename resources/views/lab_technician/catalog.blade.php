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
                                            <h2 class="nk-block-title">Laboratory Tests Catalog</h2>
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

                                                        @if(Auth::user()->role === 'admin')
                                                        <li class="breadcrumb-item"><a href="{{ route('admin.lab.create') }}">Add new test</a></li>
                                                        @endif
                                                        <li class="breadcrumb-item active" aria-current="page">Manage Lab Tests</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                @if(Auth::user()->role === 'admin')
                                                <li>
                                                    <a href="{{ route('admin.lab.create') }}" class="btn btn-md d-md-none btn-primary" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.lab.create') }}" class="btn btn-primary d-none d-md-inline-flex" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add Lab Test</span>
                                                    </a>
                                                </li>

                                                @elseif(Auth::user()->role === 'receptionist')

                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-between -->
                                </div><!-- .nk-block-head -->












                                <div class="nk-block">
                                    <div class="card">
                                        <table class="datatable-init table" data-nk-container="table-responsive">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Lab Test</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Category</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Sample Type</span>
                                                    </th>
                                                    <th class="tb-col tb-col-xl">
                                                        <span class="overline-title">Normal Range</span>
                                                    </th>
                                                    <th class="tb-col tb-col-md">
                                                        <span class="overline-title">Unit</span>
                                                    </th>
                                                    <th class="tb-col ">
                                                        <span class="overline-title">Price (TZS)</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Status</span>
                                                    </th>
                                                    <th class="tb-col tb-col-end" data-sortable="false">
                                                        <span class="overline-title">Action</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($labTests as $lab)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                <span class="smaller">
                                                                    {{ strtoupper(substr($lab->code, 0, 2) ) }}
                                                                </span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="{{ route('admin.lab.show', $lab->id) }}" class="title">
                                                                    {{ $lab->name }}
                                                                </a>
                                                                <span class="small text">{{ $lab->code }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">{{ $lab->category }}</td>
                                                    <td class="tb-col">{{ $lab->sample_type }}</td>
                                                    <td class="tb-col tb-col-xl">{{ $lab->normal_range }}</td>
                                                    <td class="tb-col tb-col-md">{{ $lab->unit }}</td>
                                                    <td class="tb-col ">{{ $lab->price }}</td>
                                                    <td class="tb-col">
                                                        @if ($lab->status === 'Active')
                                                            <span class="badge text-bg-success-soft">{{ $lab->status }}</span>
                                                        @else
                                                            <span class="badge text-bg-danger-soft">{{ $lab->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        <a href="{{ route('lab_technician.catalog.show', $lab->id) }}" class="btn btn-sm btn-outline-primary">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No services found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->

                            </div>
                        </div>
                    </div>
                </div>

@endsection