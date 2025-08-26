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
                                                        <li class="breadcrumb-item"><a href="{{ route('patients.create') }}">Add new parient</a></li>
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
                                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"><div class="dataTable-top"><div class="dataTable-dropdown"><label><select class="dataTable-selector"><option value="5">5</option><option value="10" selected="">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option></select> Per page</label></div><div class="dataTable-search"><input class="dataTable-input" placeholder="Search..." type="text"></div></div><div class="dataTable-container table-responsive">
                                            <table class="datatable-init table dataTable-table" data-nk-container="table-responsive">
                                            <thead class="table-light">
                                                <tr><th class="tb-col" data-sortable="" style="width: 36.425%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Patient Detais</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 19.3929%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Phone</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 15.0084%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Contact Person</span>
                                                    </a></th><th class="tb-col " data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Payment Method</span>
                                                    </a></th><th class="tb-col " data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Joined Date</span>
                                                    </a></th><th class="tb-col" data-sortable="" style="width: 16.0202%;"><a href="#" class="dataTable-sorter">
                                                        <span class="overline-title">Status</span>
                                                    </a></th><th class="tb-col tb-col-end" data-sortable="false" style="width: 13.1535%;">
                                                        <span class="overline-title">Action</span>
                                                    </th></tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($patients as $patient)
                                                <tr><td class="tb-col">
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
                                                                <span class="small text">{{ $patient->email ?? 'No e-mail' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">{{ $patient->phone ?? 'Not provided' }}</td>
                                                    <td class="tb-col">{{ $patient->emergency_contact_name ?? '' }} {{ $patient->emergency_contact_phone ?? 'None' }}</td>
                                                    <td class="tb-col">{{ $patient->pay_method ?? 'N/A' }}</td>
                                                    <td class="tb-col ">{{ $patient->created_at->format('Y/m/d') }}</td>
                                                    <td class="tb-col">
                                                        @if ($patient->status == 'Closed')
                                                            <span class="badge text-bg-success-soft">{{ $patient->status }}</span>
                                                        @else
                                                            <span class="badge text-bg-warning-soft">{{ $patient->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="tb-col tb-col-end">
                                                        @if(Auth::user()->role === 'receptionist')
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
                                                                                <button type="submit" class="dropdown-item">
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
                                                        <td colspan="7" class="text-center text-muted">No patients found.</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="dataTable-bottom">
                                            <div class="dataTable-info">Showing 1 to 10 of 24 entries</div>
                                            <nav class="dataTable-pagination">
                                                <ul class="dataTable-pagination-list"><li class="active"><a href="#" data-page="1">1</a></li><li class=""><a href="#" data-page="2">2</a></li><li class=""><a href="#" data-page="3">3</a></li><li class="pager"><a href="#" data-page="2"><em class="icon ni ni-chevron-right"></em></a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>

@endsection