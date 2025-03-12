@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Create Faculty</h2>
        <form action="{{ route('faculties.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @if ($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="university_id" class="form-label">University:</label>
                <select class="form-select" name="university">
                    @foreach ($universities as $univeristy)
                        <option value="{{ $university->id }}">
                            {{ $university->name }}
                        </option>
                    @endforeach
                </select>
                @error('university_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
