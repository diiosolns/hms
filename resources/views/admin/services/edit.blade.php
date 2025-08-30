@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Service</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Manage Services</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Service</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-soft btn-primary"><em class="icon ni ni-eye"></em><span>View Services</span></a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Update Service</h4>

                            <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label for="code" class="form-label">Service Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $service->code) }}">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $service->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                            <option value="">Select Category</option>
                                            <option value="Consultation" {{ old('category', $service->category)=='Consultation' ? 'selected' : '' }}>Consultation</option>
                                            <option value="Laboratory" {{ old('category', $service->category)=='Laboratory' ? 'selected' : '' }}>Laboratory</option>
                                            <option value="Pharmacy" {{ old('category', $service->category)=='Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="fee" class="form-label">Service Fee <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('fee') is-invalid @enderror" id="fee" name="fee" value="{{ old('fee', $service->fee) }}">
                                        @error('fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                            <option value="Active" {{ old('status', $service->status)=='Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Inactive" {{ old('status', $service->status)=='Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">

                                    <div class="col-lg-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Update Service</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
