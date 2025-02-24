@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center">
            <h1 class="display-1">404</h1>
            <p class="lead">Page Not Found</p>
            <a href="javascript:history.back();" class="btn btn-secondary">Go Back</a>
            <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
@endsection
