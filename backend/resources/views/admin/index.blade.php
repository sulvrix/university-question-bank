@extends('layouts.dashboard')

@section('content')
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <x-users-component />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-departments-component />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <x-faculties-component />
            </div>
            <div class="row">
                <div class="col">
                    <x-universities-component />
                </div>
            </div>
        </div>
    </div>
@endsection
