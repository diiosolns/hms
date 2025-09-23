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
                                            <h2 class="nk-block-title">Patient List</h2>
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

                                                        @if(Auth::user()->role === 'receptionist')
                                                        <li class="breadcrumb-item"><a href="{{ route('patients.create') }}">Add parient</a></li>
                                                        @endif
                                                        <li class="breadcrumb-item active" aria-current="page">Manage patients</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                @if(Auth::user()->role === 'receptionist')
                                                <li>
                                                    <a href="{{ route('patients.create') }}" class="btn btn-md d-md-none btn-primary" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('patients.create') }}" class="btn btn-primary d-none d-md-inline-flex" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add Patient</span>
                                                    </a>
                                                </li>

                                                @elseif(Auth::user()->role === 'doctor')

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
                                                        <span class="overline-title">Patient Detais</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Gender</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Phone No.</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">E-Mail</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Contact Person</span>
                                                    </th>
                                                    <th class="tb-col">
                                                        <span class="overline-title">Payment Method</span>
                                                    </th>
                                                    <th class="tb-col tb-col-md">
                                                        <span class="overline-title">Joining Date</span>
                                                    </th>
                                                    <th class="tb-col tb-col-md">
                                                        <span class="overline-title">Last Updated</span>
                                                    </th>
                                                    <th class="tb-col ">
                                                        <span class="overline-title">Doctor</span>
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
                                                @forelse ($patients as $patient)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                <span class="smaller">
                                                                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="{{ route('patients.show', $patient->id) }}" class="title">
                                                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                                                </a>
                                                                <span class="small text">{{ $patient->patient_id }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">{{ $patient->gender ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $patient->phone ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $patient->email ?? 'N/A' }}</td>
                                                    <td class="tb-col">{{ $patient->emergency_contact_name ?? '' }} {{ $patient->emergency_contact_phone ?? 'None' }}</td>
                                                    <td class="tb-col"> <span class="badge @if($patient->pay_method === 'Cash') text-bg-danger-soft @else text-bg-primary-soft @endif">{{ $patient->pay_method ?? 'N/A' }}</span></td>
                                                    <td class="tb-col">{{ $patient->created_at ? \Carbon\Carbon::parse($patient->created_at)->format('M d, Y') : 'N/A' }}</td>
                                                    <td class="tb-col">
                                                        <span class="small">{{ $patient->updated_at ? $patient->updated_at->format('M d, h:i A') : 'N/A' }}</span>
                                                    </td>
                                                    <td class="tb-col tb-col-md">{{ $patient->doctor->first_name . ' ' . $patient->doctor->last_name }}</td>
                                                    <td class="tb-col">
                                                        @if ($patient->status == 'Closed')
                                                            <span class="badge text-bg-success-soft">{{ $patient->status }}</span>
                                                        @else
                                                            <span class="badge text-bg-primary-soft">{{ $patient->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        @if(Auth::user()->role === 'receptionist' || Auth::user()->role === 'admin')
                                                        <div class="dropdown">
                                                            <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                <em class="icon ni ni-more-v"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                <div class="dropdown-content py-1">
                                                                    <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                        <li>
                                                                            <a href="{{ route('patients.edit', $patient->id) }}">
                                                                                <em class="icon ni ni-edit"></em><span>Edit</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item text-bg-danger-soft">
                                                                                    <em class="icon ni ni-trash"></em><span>Delete</span>
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('patients.show', $patient->id) }}">
                                                                                <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div><!-- dropdown -->
                                                        @elseif(Auth::user()->role === 'nurse')
                                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                                                View
                                                            </a>
                                                        @elseif(Auth::user()->role === 'doctor')
                                                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-outline-primary">
                                                                View
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="11" class="text-center text-bg-mute-soft">No pending patients found.</td>
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