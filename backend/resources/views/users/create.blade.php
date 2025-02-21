@extends('layouts.app')

@section('content')
    <h1>Add User</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="role">Role:</label>
        <input type="text" name="role" value="{{ old('role') }}">
        @error('role')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="status">Status:</label>
        <input type="text" name="status" value="{{ old('status') }}">
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="department_id">Department:</label>
        <select name="department_id">
            @foreach($departments as $department)
            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">Password:</label>
        <input type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation">
        @error('password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Add User</button>
    </form>
@endsection
