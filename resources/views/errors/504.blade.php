@extends('layouts.err')

@section('content')
    <div class="nk-main">
        <div class="nk-wrap align-items-center justify-content-center">
            <div class="container">
                <div class="nk-block wide-md mx-auto">
                    <div class="row g-gs align-items-center">
                        <div class="col-lg-6">
                            <img src="{{ asset('images/error/c.png') }}" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="nk-block-content">
                                <div class="nk-error-number"><img src="{{ asset('images/error/504.svg') }}" alt=""></div>
                                <h2 class="nk-error-title mb-2">Gateway Timeout Error</h2>
                                <p class="nk-error-text"> We are very sorry for inconvenience. It looks like some how our server did not receive a timely response. </p>
                                <a href="{{ route('login') }}" class="btn btn-primary mt-1"><em class="icon ni ni-arrow-left"></em><span>Back To Home</span></a>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div>
            </div>
        </div><!-- .nk-wrap -->
    </div> <!-- .nk-main -->
@endsection
