@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h1>Edit User</h1>
            <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" name="username"
                        value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-control" name="status">
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
                    <label for="role" class="form-label">Role:</label>
                    <select class="form-control" name="role" id="role">
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
                    <label for="department_id" class="form-label">Department:</label>
                    <select class="form-control" name="department_id" id="department_id">
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

                <div class="mb-3" id="subject_dropdown" style="display: none;">
                    <label for="subject_id" class="form-label">Subject:</label>
                    <select class="form-control" name="subject_id" id="subject_id">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" data-department-id="{{ $subject->department_id }}"
                                {{ $user->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update User
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

            // Function to show/hide subject dropdown and set required attribute
            function toggleSubjectDropdown() {
                if (roleDropdown.value === 'teacher') {
                    subjectDropdown.style.display = 'block';
                    subjectSelect.setAttribute('required', 'required');
                    filterSubjects(departmentDropdown.value);
                } else {
                    subjectDropdown.style.display = 'none';
                    subjectSelect.removeAttribute('required');
                }
            }

            // Function to filter subjects based on department
            function filterSubjects(departmentId) {
                subjectSelect.innerHTML = '';
                allSubjects.forEach(subject => {
                    if (subject.getAttribute('data-department-id') == departmentId) {
                        subjectSelect.appendChild(subject.cloneNode(true));
                    }
                });
            }

            // Event listeners
            roleDropdown.addEventListener('change', toggleSubjectDropdown);
            departmentDropdown.addEventListener('change', () => {
                if (roleDropdown.value === 'teacher') {
                    filterSubjects(departmentDropdown.value);
                }
            });

            // Initial check
            toggleSubjectDropdown();
            if (roleDropdown.value === 'teacher') {
                filterSubjects(departmentDropdown.value);
            }
        });
    </script>
@endsection
