






{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.app')

@section('content')
    <div style="text-align:center; padding:50px;">
        {{-- Leave this blank for a "gap" --}}
        {{-- Or show a friendly message --}}
        <h2>Oops! You don’t have permission to view this page.</h2>
        <a href="{{ route('login') }}">Login</a>
    </div>
@endsection