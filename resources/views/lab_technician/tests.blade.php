@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    {{-- Check if the labRequest object exists --}}
                    @if ($labRequest)
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <!-- <div class="media media-huge media-circle">
                                            {{-- Placeholder avatar --}}
                                            <img src="{{ asset('images/users/def.jpg') }}" class="img-thumbnail" alt="{{ $labRequest->patient->first_name }}">
                                        </div> -->
                                        <div class="media media-huge media-middle media-circle text-bg-primary-soft">
                                           <span class="huge">{{ strtoupper(substr($labRequest->patient->first_name, 0, 1) . substr($labRequest->patient->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            {{-- Full name --}}
                                            <h3 class="title mb-1">{{ $labRequest->patient->first_name }} {{ $labRequest->patient->last_name }}</h3>
                                            {{-- Patient ID --}}
                                            <span class="badge bg-primary">ID: {{ $labRequest->patient->patient_id }}</span>
                                            <ul class="nk-list-option pt-1">
                                                {{-- Show branch if exists --}}
                                                @if ($labRequest->branch)
                                                    <li><em class="icon ni ni-building"></em>
                                                        <span class="small">{{ $labRequest->branch->name }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                    <div class="d-flex gap g-3">
                                        <div class="gap-col">
                                            <a href="{{ route('lab_technician.patient.back.doctor', $labRequest->patient->id) }}" class="btn btn-soft btn-primary">
                                                <em class="icon ni ni-arrow-left"></em>
                                                <span>Back to Doctor</span>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-head-between -->
                        </div><!-- .nk-block-head -->
                        
                        <div class="nk-block">
                            <div class="tab-content" id="myTabContent">




                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif




                                <!-- LABORATORY TAB -->
                                <div class="tab-pane @if(Auth::user()->role === 'lab_technician') show active @endif  " id="pills-lab" role="lab">
                                    @forelse($labRequest->requestTests as $key => $test)
                                        <div class="card h-100 mt-3">
                                                <div class="col-sep">
                                                    <div class="card-body py-2">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h4 class="title mb-0">{{ $test->labTest->name }}</h4>
                                                            </div>
                                                            <div class="card-tools">
                                                                @if ($test->status !== 'Cancelled' && in_array(Auth::user()->role, [ 'admin', 'lab_technician']))
                                                                <a href="" class="btn btn-sm btn-soft btn-primary"  class="btn btn-soft btn-primary" data-bs-toggle="modal" data-bs-target="#updateTestResultsModal{{ $test->status }}" >
                                                                    <em class="icon ni ni-edit"></em> <span>Update Results</span>
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div><!-- .card-title-group -->
                                                    </div><!-- .card-body -->
                                                    <div class="card-body">
                                                        <div class="nk-timeline nk-timeline-center">
                                                            <ul class="nk-timeline-list">
                                                                <li class="nk-timeline-item">
                                                                    <div class="nk-timeline-item-inner">
                                                                        <div class="nk-timeline-symbol">
                                                                            <div class="media media-md media-middle media-circle">
                                                                                <img src="{{ asset('images/users/def.jpg') }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="nk-timeline-content">
                                                                            <p class="small"><strong>Test Results</strong> </p>
                                                                            <span class="smaller time">Unit: {{ $test->unit ?? 'None' }} | {{ $test->reference_range ?? '' }}</span>
                                                                            <p class="small">{{ $test->result ?? 'No results yet.' }}</p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="nk-timeline-item">
                                                                    <div class="nk-timeline-item-inner">
                                                                        <div class="nk-timeline-symbol">
                                                                            <div class="media media-md media-middle media-circle">
                                                                                <img src="{{ asset('images/users/def.jpg') }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="nk-timeline-content">
                                                                            <p class="small"><strong>Attachment</strong></p>
                                                                            <!-- <span class="smaller time">pdf/ Image file </span> -->
                                                                            @if($test->attachment)
                                                                                <a href="{{ asset('storage/' . $test->attachment) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                    <em class="icon ni ni-eye"></em> Preview
                                                                                </a>

                                                                                <a href="{{ asset('storage/' . $test->attachment) }}" download class="btn btn-sm btn-secondary">
                                                                                    <em class="icon ni ni-download"></em> Download
                                                                                </a>
                                                                            @else
                                                                                <p class="small">No attachment yet.</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div><!-- .nk-timeline -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- UPDATE RESULTS MODAL -->
                                            <div class="modal fade" id="updateTestResultsModal{{ $test->status }}" tabindex="-1" aria-labelledby="updateTestResultsModalLabel{{ $test->status }}" aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateNurseTriageModalLabel">{{ $test->labTest->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('lab_technician.results.upload', $test->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                           <div class="modal-body">
                                                                <div class="row g-3 gx-gs">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="result" class="form-label">Test Results</label>
                                                                            <div class="form-control-wrap">
                                                                                <textarea name="result" placeholder="Enter test resul description" class="form-control" id="result" rows="3">{{ $test->result ?? '' }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">   
                                                                        <div class="form-group">
                                                                            <label for="attachment" class="form-label">Attachment</label>
                                                                            <div class="form-control-wrap">
                                                                                <input 
                                                                                    name="attachment" 
                                                                                    class="form-control" 
                                                                                    type="file" 
                                                                                    id="attachment" 
                                                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                                                />
                                                                                <small class="text-muted text-primary">Allowed file types: PDF, JPG, JPEG, PNG</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="status" value="Closed">
                                                                <button type="submit" class="btn btn-md btn-primary">Update Results</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END UPDATE RESULTS MODAL -->
                                        @empty
                                          <div>
                                              <p>No lab tests requested.</p>
                                          </div>
                                        @endforelse

                                </div><!-- .lab tab-pane -->



                            </div><!-- .tab-content -->
                        </div><!-- .nk-block -->
                    @else
                        {{-- Show a message if the patient is not found --}}
                        <div class="alert alert-danger" role="alert">
                            labRequest not found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>









@endsection
