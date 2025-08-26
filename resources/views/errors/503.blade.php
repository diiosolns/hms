@extends('layouts.app')

@section('content')
<div class="text-center p-10">
    <h1 class="text-4xl font-bold text-red-600">503</h1>
    <p class="text-lg mt-4">Service unavailable. Please check back later.</p>
    <a href="{{ route('login') }}">Login</a>
</div>
@endsection
