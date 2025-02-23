@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="text-center">
            <h1 class="display-1">404</h1>
            <p class="lead">Page Not Found</p>
            <a href="javascript:history.back();" class="btn btn-secondary">Go Back</a>
            <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
@endsection
