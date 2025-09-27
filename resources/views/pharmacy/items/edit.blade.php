@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Pharmacy Item</h2>
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
                                    <li class="breadcrumb-item active" aria-current="page">Edit Item</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('pharmacy.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View Items</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Update Pharmacy Item</h4>

                            <form action="{{ route('pharmacy.update', $pharmacyItem->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    <!-- Item Code -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Item Code <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                class="form-control @error('code') is-invalid @enderror" 
                                                id="code" 
                                                name="code" 
                                                value="{{ old('code', $pharmacyItem->code) }}" 
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
                                                value="{{ old('name', $pharmacyItem->name) }}" 
                                                placeholder="e.g. Paracetamol">
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
                                                value="{{ old('category', $pharmacyItem->category) }}" 
                                                placeholder="e.g. Painkiller, Antibiotic">
                                            @error('category')
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
                                                value="{{ old('unit', $pharmacyItem->unit) }}" 
                                                placeholder="e.g. Tablet, Bottle">
                                            @error('unit')
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
                                                value="{{ old('price', $pharmacyItem->price) }}" 
                                                placeholder="e.g. 10.00">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Stock Quantity -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="stock" class="form-label">Stock Quantity</label>
                                            <input type="number" 
                                                class="form-control @error('stock') is-invalid @enderror" 
                                                id="stock" 
                                                name="stock" 
                                                value="{{ old('stock', $pharmacyItem->stock) }}" 
                                                placeholder="e.g. 100">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status">
                                                <option value="Active" {{ old('status', $pharmacyItem->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ old('status', $pharmacyItem->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Hidden hospital and branch -->
                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                    <!-- Submit -->
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Update Item</button>
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
