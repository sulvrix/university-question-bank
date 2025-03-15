@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h1>Add User</h1>
            <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-control" name="status" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role:</label>
                    <select class="form-control" name="role" id="role" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">Department:</label>
                    <select class="form-control" name="department_id" id="department_id" required>
                        @foreach ($departments as $department)
                            <option value="{{ $department['id'] }}"
                                {{ old('department_id') == $department['id'] ? 'selected' : '' }}>
                                {{ $department['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="subject_dropdown" style="display: none;">
                    <label for="subject_id" class="form-label">Subject:</label>
                    <select class="form-control" name="subject_id" id="subject_id">
                        <!-- Subjects will be populated here dynamically -->
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" data-department-id="{{ $subject->department_id }}">
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Add User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleDropdown = document.getElementById('role');
            const departmentDropdown = document.getElementById('department_id');
            const subjectDropdown = document.getElementById('subject_dropdown');
            const subjectSelect = document.getElementById('subject_id');
            const allSubjects = Array.from(subjectSelect.options);

            roleDropdown.addEventListener('change', function() {
                if (this.value === 'teacher') {
                    subjectDropdown.style.display = 'block';
                    subjectSelect.setAttribute('required', 'required'); // Add required attribute
                    filterSubjects(departmentDropdown.value);
                } else {
                    subjectDropdown.style.display = 'none';
                    subjectSelect.removeAttribute('required'); // Remove required attribute
                }
            });

            departmentDropdown.addEventListener('change', function() {
                if (roleDropdown.value === 'teacher') {
                    filterSubjects(this.value);
                }
            });

            function filterSubjects(departmentId) {
                // Clear existing options
                subjectSelect.innerHTML = '';

                // Filter subjects based on the selected department
                allSubjects.forEach(subject => {
                    if (subject.getAttribute('data-department-id') == departmentId) {
                        subjectSelect.appendChild(subject.cloneNode(true));
                    }
                });
            }

            // Initial check in case the role is already set to 'teacher'
            if (roleDropdown.value === 'teacher') {
                subjectDropdown.style.display = 'block';
                subjectSelect.setAttribute('required', 'required'); // Add required attribute
                filterSubjects(departmentDropdown.value);
            }
        });
    </script>
@endsection
