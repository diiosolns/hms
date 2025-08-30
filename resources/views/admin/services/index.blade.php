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
                                            <h2 class="nk-block-title">Services List</h2>
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
                                                        <li class="breadcrumb-item"><a href="{{ route('admin.services.create') }}">Add new service</a></li>
                                                        @endif
                                                        <li class="breadcrumb-item active" aria-current="page">Manage services</li>
                                                    </ol>
                                                </nav>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="d-flex">
                                                @if(Auth::user()->role === 'admin')
                                                <li>
                                                    <a href="{{ route('admin.services.create') }}" class="btn btn-md d-md-none btn-primary" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary d-none d-md-inline-flex" >
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Add Service</span>
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
                                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns"><div class="dataTable-top"><div class="dataTable-dropdown"><label><select class="dataTable-selector"><option value="5">5</option><option value="10" selected="">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option></select> Per page</label></div><div class="dataTable-search"><input class="dataTable-input" placeholder="Search..." type="text"></div></div><div class="dataTable-container table-responsive">
                                            <table class="datatable-init table dataTable-table" data-nk-container="table-responsive">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="tb-col" data-sortable="" style="width: 36.425%;"><a href="#" class="dataTable-sorter">
                                                            <span class="overline-title">Service Detais</span>
                                                        </a></th><th class="tb-col " data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                            <span class="overline-title">Category</span>
                                                        </a></th><th class="tb-col " data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                            <span class="overline-title">Fee</span>
                                                        </a></th><th class="tb-col" data-sortable="" style="width: 0%;"><a href="#" class="dataTable-sorter">
                                                            <span class="overline-title">Status</span>
                                                        </a></th><th class="tb-col tb-col-end" data-sortable="false" style="width: 13.1535%;">
                                                            <span class="overline-title">Action</span>
                                                        </th></tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($services as $service)
                                                    <tr>
                                                        <td class="tb-col">
                                                            <div class="media-group">
                                                                <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                                    <span class="smaller">
                                                                        {{ strtoupper(substr($service->code, 0, 2) ) }}
                                                                    </span>
                                                                </div>
                                                                <div class="media-text">
                                                                    <a href="{{ route('admin.services.show', $service->id) }}" class="title">
                                                                        {{ $service->name }}
                                                                    </a>
                                                                    <span class="small text">{{ $service->code }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td class="tb-col">{{ $service->category }}</td>
                                                        <td class="tb-col">{{ number_format($service->fee, 2) }}</td>
                                                        <td class="tb-col">
                                                            @if ($service->status === 'Active')
                                                                <span class="badge text-bg-success-soft">{{ $service->status }}</span>
                                                            @else
                                                                <span class="badge text-bg-danger-soft">{{ $service->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="tb-col tb-col-end">
                                                            <div class="dropdown">
                                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                                    <em class="icon ni ni-more-v"></em>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                                    <div class="dropdown-content py-1">
                                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                            <li>
                                                                                <a href="{{ route('admin.services.edit', $service->id) }}">
                                                                                    <em class="icon ni ni-edit"></em><span>Edit</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="dropdown-item">
                                                                                        <em class="icon ni ni-trash"></em><span>Delete</span>
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                            <li>
                                                                                <a href="{{ route('admin.services.show', $service->id) }}">
                                                                                    <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No services found.</td>
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