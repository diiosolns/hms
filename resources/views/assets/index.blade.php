@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Assets</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        {{-- Dynamic Dashboard Link based on Role --}}
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

                                        {{-- Add New Asset Link for Admins --}}
                                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
                                        <li class="breadcrumb-item"><a href="{{ route('assets.asset.create') }}">Add New Asset</a></li>
                                        @endif
                                        <li class="breadcrumb-item active" aria-current="page">Manage Assets</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    {{-- Add Asset Button for Admins and Owners --}}
                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'owner')
                                    <li>
                                        <a href="{{ route('assets.asset.create') }}" class="btn btn-md d-md-none btn-primary" >
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('assets.asset.create') }}" class="btn btn-primary d-none d-md-inline-flex" >
                                            <em class="icon ni ni-plus"></em>
                                            <span>Add New Asset</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div><!-- .nk-block-head-between -->
                    </div><!-- .nk-block-head -->






                                {{-- Display Success or Error Messages --}}
                                @if (session('success'))
                                    <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Display Validation Errors --}}
                                @if ($errors->any())
                                    <div class="mt-3 alert alert-danger alert-dismissible fade show">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif






                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col">
                                            <span class="overline-title">Asset Name</span>
                                        </th>
                                        <th class="tb-col tb-col-md">
                                            <span class="overline-title">Asset Cost</span>
                                        </th>
                                        <th class="tb-col">
                                            <span class="overline-title">Category</span>
                                        </th>
                                        <th class="tb-col tb-col-xl">
                                            <span class="overline-title">Location</span>
                                        </th>
                                        <th class="tb-col tb-col-md">
                                            <span class="overline-title">Hospital Branch</span>
                                        </th>
                                        <th class="tb-col ">
                                            <span class="overline-title">Acquisition Date</span>
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
                                    {{-- Assuming the controller passes a collection named $assets --}}
                                    @forelse ($assets as $asset)
                                    <tr>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                {{-- Using first two letters of asset name for avatar placeholder --}}
                                                <div class="media media-md media-middle media-circle text-bg-info-soft">
                                                    <span class="smaller">
                                                        {{ strtoupper(substr($asset->name, 0, 2) ) }}
                                                    </span>
                                                </div>
                                                <div class="media-text">
                                                    <a href="{{ route('assets.asset.show', $asset->id) }}" class="title">
                                                        {{ $asset->name }}
                                                    </a>
                                                    <span class="small text">{{ $asset->serial_number }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tb-col tb-col-md">{{ number_format($asset->purchase_cost, 0) }} </td>
                                        <td class="tb-col">{{ $asset->category->name }}</td>
                                        <td class="tb-col tb-col-xl">{{ $asset->location }}</td>
                                        <td class="tb-col tb-col-md">{{ $asset->branch->name }}</td>
                                        <td class="tb-col ">{{ \Carbon\Carbon::parse($asset->acquisition_date)->format('M d, Y') }}</td>
                                        <td class="tb-col">
                                            {{-- Assuming status field exists and uses 'Operational'/'Retired' --}}
                                            @if ($asset->status === 'Operational')
                                                <span class="badge text-bg-success-soft">{{ $asset->status }}</span>
                                            @elseif ($asset->status === 'Maintenance')
                                                <span class="badge text-bg-warning-soft">{{ $asset->status }}</span>
                                            @else
                                                <span class="badge text-bg-danger-soft">{{ $asset->status }}</span>
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
                                                                <a href="{{ route('assets.asset.show', $asset) }}">
                                                                    <em class="icon ni ni-eye"></em><span>View Details</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('assets.maintenances.index', $asset) }}">
                                                                    <em class="icon ni ni-setting"></em><span>Maintainances</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('assets.asset.edit', $asset->id) }}">
                                                                    <em class="icon ni ni-edit"></em><span>Edit Asset</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                {{-- NOTE: Removed JavaScript confirm() for compliance. A custom modal/UI confirmation should be implemented client-side --}}
                                                                <form action="{{ route('assets.asset.destroy', $asset->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">
                                                                        <em class="icon ni ni-trash"></em><span>Delete Asset</span>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- dropdown -->
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No assets found.</td>
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
