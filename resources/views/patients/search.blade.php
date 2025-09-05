@extends('layouts.app')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Patient Search</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    @if(Auth::user()->role === 'receptionist')
                                        <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'doctor')
                                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                                    @elseif(Auth::user()->role === 'admin')
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li class="breadcrumb-item active" aria-current="page">Search a patient</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="nk-block-head-content">
                            
                        </div>
                    </div><!-- .nk-block-head-between -->
                </div><!-- .nk-block-head -->

                <div class="nk-block">
                    <div class="card">
                        



                        
                    </div><!-- .card -->
                </div><!-- .nk-block -->

            </div>
        </div>
    </div>
</div>
@endsection
