@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <div class="media media-huge media-middle media-circle text-bg-primary-soft">
                                           <span class="huge">{{ strtoupper(substr($labTest->code, 0, 2)) }}</span>
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            {{-- Full name --}}
                                            <h3 class="title mb-1">{{ $labTest->name }} </h3>
                                            {{-- Code --}}
                                            <span class="badge bg-primary">Code: {{ $labTest->code }}</span>
                                            <ul class="nk-list-option pt-1">
                                                {{-- Show category if exists --}}
                                                @if ($labTest->category)
                                                    <li><em class="icon ni ni-building"></em>
                                                        <span class="small">{{ $labTest->category }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                                
                                </div><!-- .nk-block-head-content -->

                            </div><!-- .nk-block-head-between -->
                        </div><!-- .nk-block-head -->

                            
                        
                        <div class="nk-block">
                            <div class="nk-content" >
                                <div class="card card-bordered">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Lab Test Details</h4>

                                        @if($labTest)
                                            <ul class="list-group list-group-borderless small">
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Code:</span>
                                                    <span class="text">{{ $labTest->code }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Name:</span>
                                                    <span class="text">{{ $labTest->name }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Category:</span>
                                                    <span class="text">{{ $labTest->category ?? 'N/A' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Description:</span>
                                                    <span class="text">{{ $labTest->description ?? 'No description provided' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Sample Type:</span>
                                                    <span class="text">{{ $labTest->sample_type ?? 'N/A' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Method:</span>
                                                    <span class="text">{{ $labTest->method ?? 'N/A' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Normal Range:</span>
                                                    <span class="text">{{ $labTest->normal_range ?? '-' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Unit:</span>
                                                    <span class="text">{{ $labTest->unit ?? '-' }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Price:</span>
                                                    <span class="text">{{ number_format($labTest->price, 2) }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Status:</span>
                                                    <span class="badge bg-{{ $labTest->status === 'Active' ? 'success' : 'danger' }}">
                                                        {{ $labTest->status }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="fw-medium w-40 d-inline-block">Created On:</span>
                                                    <span class="text">
                                                        {{ \Carbon\Carbon::parse($labTest->created_at)->format('M d, Y') }}
                                                    </span>
                                                </li>
                                            </ul>
                                        @else
                                            <p class="text-muted">No lab test details available.</p>
                                        @endif
                                    </div>
                                </div>

                            </div><!-- .nk-content -->
                        </div><!-- .nk-block --> 
                    </div>
            </div>
        </div>
    </div>
@endsection
