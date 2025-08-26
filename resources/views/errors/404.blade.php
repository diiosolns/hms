@extends('layouts.app')

@section('content')
<div class="text-center p-10">
    <h1 class="text-4xl font-bold text-red-600">404</h1>
    <p class="text-lg mt-4">Sorry, the page you are looking for could not be found.</p>
    <a href="{{ route('login') }}">Login</a>
</div>
@endsection
