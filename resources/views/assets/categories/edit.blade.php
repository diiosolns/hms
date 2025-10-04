@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Update Asset Category</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('assets.categories.index') }}">Manage Categories</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Asset Category</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('assets.categories.index') }}" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View Categories</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Update Category</h4>

                            <form action="{{ route('assets.categories.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    <!-- Category Name -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name', $assetCategory->name) }}"
                                                   placeholder="e.g. Paracetamol 500mg">
                                            @error('name')
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

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="user" class="form-label">Registered by <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control @error('user') is-invalid @enderror"
                                                   id="user"
                                                   name="user"
                                                   value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}"
                                                   disabled>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Update Asset Category</button>
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
