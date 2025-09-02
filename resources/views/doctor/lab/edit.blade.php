@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Edit Lab Test</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.lab.index') }}">Manage Lab Tests</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Lab Test</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.lab.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View Lab Tests</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Update Lab Test Details</h4>

                            <form action="{{ route('admin.lab.update', $labTest->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">

                                    <!-- Code -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label">Test Code <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('code') is-invalid @enderror"
                                                   id="code"
                                                   name="code"
                                                   value="{{ old('code', $labTest->code) }}"
                                                   placeholder="e.g. CBC001">
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Test Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name', $labTest->name) }}"
                                                   placeholder="e.g. Complete Blood Count">
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
                                                   value="{{ old('category', $labTest->category) }}"
                                                   placeholder="e.g. Hematology, Biochemistry">
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Sample Type -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="sample_type" class="form-label">Sample Type</label>
                                            <input type="text"
                                                   class="form-control @error('sample_type') is-invalid @enderror"
                                                   id="sample_type"
                                                   name="sample_type"
                                                   value="{{ old('sample_type', $labTest->sample_type) }}"
                                                   placeholder="e.g. Blood, Urine">
                                            @error('sample_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Method -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="method" class="form-label">Method</label>
                                            <input type="text"
                                                   class="form-control @error('method') is-invalid @enderror"
                                                   id="method"
                                                   name="method"
                                                   value="{{ old('method', $labTest->method) }}"
                                                   placeholder="e.g. ELISA, PCR">
                                            @error('method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Normal Range -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="normal_range" class="form-label">Normal Range</label>
                                            <input type="text"
                                                   class="form-control @error('normal_range') is-invalid @enderror"
                                                   id="normal_range"
                                                   name="normal_range"
                                                   value="{{ old('normal_range', $labTest->normal_range) }}"
                                                   placeholder="e.g. 4.5-11.0 x10^9/L">
                                            @error('normal_range')
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
                                                   value="{{ old('unit', $labTest->unit) }}"
                                                   placeholder="e.g. x10^9/L">
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
                                                   value="{{ old('price', $labTest->price) }}"
                                                   placeholder="e.g. 50.00">
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
                                                <option value="Active" {{ old('status', $labTest->status)=='Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ old('status', $labTest->status)=='Inactive' ? 'selected' : '' }}>Inactive</option>
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
                                                      placeholder="Optional description">{{ old('description', $labTest->description) }}</textarea>
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
                                        <button class="btn btn-primary" type="submit">Update Lab Test</button>
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
