@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Create Subject</h2>
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Level:</label>
                <select class="form-select" name="level" id="level" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                @if ($errors->has('level'))
                    <div class="text-danger">{{ $errors->first('level') }}</div>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department:</label>
                    <select class="form-select" name="department_id" id="department_id" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('department_id'))
                        <div class="text-danger">{{ $errors->first('department_id') }}</div>
                    @endif
                </div>
            @else
                <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
            @endif

            <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
