@extends('layouts.app')

@section('content')
<div class="text-center p-10">
    <h1 class="text-4xl font-bold text-red-600">429</h1>
    <p class="text-lg mt-4">Too many requests. Please slow down.</p>
    <a href="{{ route('login') }}">Login</a>
</div>
@endsection
