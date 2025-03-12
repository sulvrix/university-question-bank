@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Edit User</h1>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" name="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Role:</label>
                <select class="form-select" name="status">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $user->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Department:</label>
                <select class="form-select" name="department_id">
                    @foreach ($departments as $department)
                        <option value="{{ $department['id'] }}"
                            {{ $user->department_id == $department['id'] ? 'selected' : '' }}>
                            {{ $department['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" class="form-control" name="new_password">
                @error('new_password')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" name="new_password_confirmation">
                @error('new_password_confirmation')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">Back</a>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
