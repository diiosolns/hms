@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Add New Pharmacy Item</h2>
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
                                    <li class="breadcrumb-item"><a href="{{ route('pharmacy.index') }}">Manage Pharmacy Items</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Pharmacy Item</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('pharmacy.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View Pharmacy Items</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Register a New Pharmacy Item</h4>

                            <form action="{{ route('pharmacy.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">

                                    <!-- Item Code -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Item Code <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('code') is-invalid @enderror"
                                                   id="code"
                                                   name="code"
                                                   value="{{ old('code') }}"
                                                   placeholder="e.g. MED001">
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Item Name -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="e.g. Paracetamol 500mg">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="category" class="form-label">Category</label>
                                            <input type="text"
                                                   class="form-control @error('category') is-invalid @enderror"
                                                   id="category"
                                                   name="category"
                                                   value="{{ old('category') }}"
                                                   placeholder="e.g. Analgesic, Antibiotic">
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Manufacturer -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="manufacturer" class="form-label">Manufacturer</label>
                                            <input type="text"
                                                   class="form-control @error('manufacturer') is-invalid @enderror"
                                                   id="manufacturer"
                                                   name="manufacturer"
                                                   value="{{ old('manufacturer') }}"
                                                   placeholder="e.g. Pfizer, GSK">
                                            @error('manufacturer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Expiry Date -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="expiry_date" class="form-label">Expiry Date</label>
                                            <input type="date"
                                                   class="form-control @error('expiry_date') is-invalid @enderror"
                                                   id="expiry_date"
                                                   name="expiry_date"
                                                   value="{{ old('expiry_date') }}">
                                            @error('expiry_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="unit" class="form-label">Unit</label>
                                            <input type="text"
                                                   class="form-control @error('unit') is-invalid @enderror"
                                                   id="unit"
                                                   name="unit"
                                                   value="{{ old('unit') }}"
                                                   placeholder="e.g. Tablet, Bottle, Box">
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number"
                                                   class="form-control @error('quantity') is-invalid @enderror"
                                                   id="quantity"
                                                   name="quantity"
                                                   value="{{ old('quantity') }}"
                                                   placeholder="e.g. 100">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   id="price"
                                                   name="price"
                                                   value="{{ old('price') }}"
                                                   placeholder="e.g. 10.50">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status"
                                                    name="status">
                                                <option value="Active" {{ old('status')=='Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ old('status')=='Inactive' ? 'selected' : '' }}>Inactive</option>
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
                                                      placeholder="Optional description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Hidden hospital and branch -->
                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                    <!-- Submit -->
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Save Pharmacy Item</button>
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
