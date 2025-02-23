@extends('layouts.dashboard')

@section('content')
    <div class="container text-center">
        <div class="row">
            <x-users-component />
        </div>
        <div class="row">
            <x-subjects-component />
        </div>
        <div class="row">
            <x-departments-component />
        </div>
        <div class="row">
            <x-faculties-component />
        </div>
        <div class="row">
            <x-universities-component />
        </div>
    </div>
@endsection
