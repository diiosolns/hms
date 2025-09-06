@extends('layouts.err')

@section('content')
    <div class="nk-main">
        <div class="nk-wrap align-items-center justify-content-center">
            <div class="container">
                <div class="nk-block">
                    <div class="nk-block-content wide-sm text-center mx-auto">
                        <img src="{{ asset('images/error/c.png') }}" alt="" class="mb-5">
                        <h2 class="nk-error-title mb-2">Oops! Page expired. Please refresh and try again.</h2>
                        <p class="nk-error-text">We are very sorry for inconvenience. Please refresh and try again. </p>
                        <a href="{{ route('login') }}" class="btn btn-primary mt-1"><em class="icon ni ni-arrow-left"></em><span>Back To Home</span></a>
                    </div>
                </div>
            </div>
        </div><!-- .nk-wrap -->
    </div> <!-- .nk-main -->
@endsection


