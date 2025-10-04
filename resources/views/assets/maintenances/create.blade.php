@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2 align-items-center">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Log New Maintenance Record</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="">Asset Maintenance</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Log Record</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="" class="btn btn-soft btn-primary">
                                <em class="icon ni ni-eye"></em><span>View All Records</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-gutter-md">
                        <div class="card-body">
                            <h4 class="mb-4">Enter Maintenance Details</h4>

                            <form action="{{ route('assets.maintenances.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">

                                    <!-- Asset ID (Assuming you pass a list of assets to the view) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="asset_id" class="form-label">Asset Serviced <span class="text-danger">*</span></label>
                                            <select class="form-control @error('asset_id') is-invalid @enderror"
                                                     id="asset_id"
                                                     name="asset_id"
                                                     required>
                                                <!-- Placeholder options - replace with actual assets from the database -->
                                                <option value="" disabled selected>Select an Asset</option>
                                                <option value="1" {{ old('asset_id')=='1' ? 'selected' : '' }}>Asset 1: X-Ray Machine</option>
                                                <option value="2" {{ old('asset_id')=='2' ? 'selected' : '' }}>Asset 2: Server Rack</option>
                                            </select>
                                            @error('asset_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Maintenance Date -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="maintenance_date" class="form-label">Maintenance Date <span class="text-danger">*</span></label>
                                            <input type="date"
                                                     class="form-control @error('maintenance_date') is-invalid @enderror"
                                                     id="maintenance_date"
                                                     name="maintenance_date"
                                                     value="{{ old('maintenance_date', date('Y-m-d')) }}"
                                                     required>
                                            @error('maintenance_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Performed By -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="performed_by" class="form-label">Performed By (Staff or Vendor)</label>
                                            <input type="text"
                                                     class="form-control @error('performed_by') is-invalid @enderror"
                                                     id="performed_by"
                                                     name="performed_by"
                                                     value="{{ old('performed_by') }}"
                                                     placeholder="e.g. John Doe / Tech Solutions Inc.">
                                            @error('performed_by')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Cost -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="cost" class="form-label">Cost (in $)</label>
                                            <input type="number" step="0.01"
                                                     class="form-control @error('cost') is-invalid @enderror"
                                                     id="cost"
                                                     name="cost"
                                                     value="{{ old('cost') }}"
                                                     placeholder="e.g. 150.75">
                                            @error('cost')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Next Due Date (Optional) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="next_due_date" class="form-label">Next Due Date (Optional)</label>
                                            <input type="date"
                                                     class="form-control @error('next_due_date') is-invalid @enderror"
                                                     id="next_due_date"
                                                     name="next_due_date"
                                                     value="{{ old('next_due_date') }}">
                                            @error('next_due_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Details (Replaces Description) -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="details" class="form-label">Details of Work Performed</label>
                                            <textarea class="form-control @error('details') is-invalid @enderror"
                                                      id="details"
                                                      name="details"
                                                      placeholder="Describe the maintenance performed, parts replaced, or issues resolved.">{{ old('details') }}</textarea>
                                            @error('details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Hidden hospital and branch (Kept for context, assuming this data is still relevant) -->
                                    <input type="hidden" name="hospital_id" value="{{ auth()->user()->hospital_id ?? '' }}">
                                    <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id ?? '' }}">

                                    <!-- Submit -->
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit">Save Maintenance Record</button>
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
