@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Faculty</h2>

        <form method="POST" action="{{ route('faculties.update', $faculty->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $faculty->name }}" required>
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="university" class="form-label">University:</label>
                <select class="form-select" id="university" name="university_id" required>
                    @foreach ($universities as $university)
                        <option value="{{ $university->id }}"
                            {{ $university->id == $faculty->university_id ? 'selected' : '' }}>
                            {{ $university->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('university_id'))
                    <div class="text-danger">{{ $errors->first('faculty_id') }}</div>
                @endif
            </div>

            <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">Back</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
