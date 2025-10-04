@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Asset</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('assets.asset.index') }}">Manage Assets</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add an Asset</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('assets.asset.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View assets</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Register an Assets</h4>

                            <form action="{{ route('assets.asset.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">

                                    <!-- Asset Name (Required) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="name"
                                                name="name"
                                                value="{{ old('name') }}"
                                                placeholder="e.g. Dell Latitude Laptop">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Serial Number -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="serial_number" class="form-label">Serial Number (Unique)</label>
                                            <input type="text"
                                                class="form-control @error('serial_number') is-invalid @enderror"
                                                id="serial_number"
                                                name="serial_number"
                                                value="{{ old('serial_number') }}"
                                                placeholder="e.g. SN-A1B2C3D4">
                                            @error('serial_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Category ID (Dropdown for Relationship) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror"
                                                    id="category_id"
                                                    name="category_id"
                                                    required>
                                                <option value="">Select Category</option>
                                                {{-- Assuming $categories is passed to this view --}}
                                                @isset($categories)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                     <option value="" disabled>No categories available</option>
                                                @endisset
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Assigned To (Dropdown for User) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="assigned_to" class="form-label">Assigned To (User)</label>
                                            <select class="form-control @error('assigned_to') is-invalid @enderror"
                                                    id="assigned_to"
                                                    name="assigned_to">
                                                <option value="">Unassigned</option>
                                                {{-- Assuming $users is passed to this view --}}
                                                @isset($users)
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->first_name }} {{ $user->last_name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>No users available</option>
                                                @endisset
                                            </select>
                                            @error('assigned_to')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Purchase Date -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="purchase_date" class="form-label">Purchase Date</label>
                                            <input type="date"
                                                class="form-control @error('purchase_date') is-invalid @enderror"
                                                id="purchase_date"
                                                name="purchase_date"
                                                value="{{ old('purchase_date') }}">
                                            @error('purchase_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Purchase Cost -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="purchase_cost" class="form-label">Purchase Cost</label>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('purchase_cost') is-invalid @enderror"
                                                id="purchase_cost"
                                                name="purchase_cost"
                                                value="{{ old('purchase_cost') }}"
                                                placeholder="e.g. 599.99">
                                            @error('purchase_cost')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Location -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text"
                                                class="form-control @error('location') is-invalid @enderror"
                                                id="location"
                                                name="location"
                                                value="{{ old('location') }}"
                                                placeholder="e.g. Server Room, Office 301">
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Warranty Expiry -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="warranty_expiry" class="form-label">Warranty Expiry Date</label>
                                            <input type="date"
                                                class="form-control @error('warranty_expiry') is-invalid @enderror"
                                                id="warranty_expiry"
                                                name="warranty_expiry"
                                                value="{{ old('warranty_expiry') }}">
                                            @error('warranty_expiry')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status (Enum) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status"
                                                    name="status"
                                                    required>
                                                {{-- Options match your database enum ['active', 'in_maintenance', 'retired', 'lost'] --}}
                                                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                                                <option value="in_maintenance" {{ old('status')=='in_maintenance' ? 'selected' : '' }}>In Maintenance</option>
                                                <option value="retired" {{ old('status')=='retired' ? 'selected' : '' }}>Retired</option>
                                                <option value="lost" {{ old('status')=='lost' ? 'selected' : '' }}>Lost</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                        id="description"
                                                        name="description"
                                                        placeholder="Detailed description of the asset, condition, and use.">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    @if(Auth::user()->role === 'owner')
                                    <div class="col-md-6 mb-0">
                                        <label for="hospital_id" class="form-label">Hospital</label>
                                        <select class="form-select" id="hospital_id" name="hospital_id" required>
                                            <option value="">Select a Hospital</option>
                                            @foreach ($hospitals as $hospital)
                                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-0">
                                        <label for="branch_id" class="form-label">Branch</label>
                                        <select class="form-select" id="branch_id" name="branch_id" required>
                                            <option value="">Select a Branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <!-- Hidden hospital and branch -->
                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                                    @endif
                                    
                                    <!-- Submit -->
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Register New Asset</button>
                                    </div>
                                </div>
                            </form>


                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
