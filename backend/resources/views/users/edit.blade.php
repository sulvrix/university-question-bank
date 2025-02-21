@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="role">Role:</label>
        <input type="text" name="role" value="{{ old('role', $user->role) }}">
        @error('role')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="status">Status:</label>
        <input type="text" name="status" value="{{ old('status', $user->status) }}">
        @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="department_id">Department:</label>
        <select name="department_id">
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ $department->id == old('department_id', $user->department_id) ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password">
        @error('new_password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="new_password_confirmation">Confirm New Password:</label>
        <input type="password" name="new_password_confirmation">
        @error('new_password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit">Update User</button>
    </form>
@endsection
