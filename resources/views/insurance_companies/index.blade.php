@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">

                <!-- Header -->
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Insurance Companies</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    @if(Auth::user()->role === 'admin')
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'owner')
                                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'receptionist')
                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                    @endif

                                    <li class="breadcrumb-item"><a href="{{ route('insurance_companies.create') }}">Add Company</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Insurance Companies</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="nk-block-head-content">
                            <ul class="d-flex">
                                @if(in_array(Auth::user()->role, ['admin', 'owner']))
                                <li>
                                    <a href="{{ route('insurance_companies.create') }}" class="btn btn-primary">
                                        <em class="icon ni ni-plus"></em>
                                        <span>Add Insurance Company</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Header -->

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                <!-- /Flash Messages -->

                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th>Company Name</th>
                                    <th>Contact Person</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th class="tb-col-end text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($insuranceCompanies as $company)
                                    <tr>
                                        <td>
                                            <div class="media-group">
                                                <div class="media media-md media-middle media-circle text-bg-primary-soft">
                                                    <span class="smaller">
                                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="media-text">
                                                    <a href="{{ route('insurance_companies.show', $company->id) }}" class="title">
                                                        {{ $company->name }}
                                                    </a>
                                                    <span class="small text-muted">
                                                        {{ $company->branch->name ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $company->contact_person ?? '-' }}</td>
                                        <td>{{ $company->phone ?? '-' }}</td>
                                        <td>{{ $company->email ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($company->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $company->created_at->format('Y-m-d') }}</td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-v"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li>
                                                                <a href="{{ route('insurance_companies.edit', $company->id) }}">
                                                                    <em class="icon ni ni-edit"></em>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('insurance_companies.destroy', $company->id) }}"
                                                                      method="POST"
                                                                      onsubmit="return confirm('Are you sure you want to delete this insurance company?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>Delete</span>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('insurance_companies.show', $company->id) }}">
                                                                    <em class="icon ni ni-eye"></em>
                                                                    <span>View Details</span>
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
                                        <td colspan="7" class="text-center text-muted">No insurance companies found.</td>
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
