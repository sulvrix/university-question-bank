@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Department</h2>

        <form method="POST" action="{{ route('departments.update', $department->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}"
                    required>
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="faculty" class="form-label">Faculty:</label>
                <select class="form-select" id="faculty" name="faculty_id" required>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ $faculty->id == $department->faculty_id ? 'selected' : '' }}>
                            {{ $faculty->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('faculty_id'))
                    <div class="text-danger">{{ $errors->first('faculty_id') }}</div>
                @endif
            </div>

            <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">Back</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
