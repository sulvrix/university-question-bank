@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h1>Add User</h1>
            <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name:</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                required autocomplete="username">
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required
                                autocomplete="email">
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
                    </div>
                    <div class="col-md-6">
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
                                    <option value="{{ $subject->id }}"
                                        data-department-id="{{ $subject->department_id }}">
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="password" class="form-label">Password:</label>
                        <div class="mb-3 input-group">
                            <input type="password" class="form-control" name="password" required autocomplete="new-password"
                                id="password">
                            <span class="input-group-text" id="inputGroup-sizing-default addon-wrapping">
                                <i class="bi bi-eye-fill password-eye"></i>
                                <i class="bi bi-eye-slash-fill password-eye-closed"></i>
                            </span>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <div class="mb-3 input-group">
                            <input type="password" class="form-control" name="password_confirmation" required
                                autocomplete="new-password" id="password_confirmation">
                            <span class="input-group-text" id="inputGroup-sizing-default addon-wrapping">
                                <i class="bi bi-eye-fill password-confirm-eye"></i>
                                <i class="bi bi-eye-slash-fill password-confirm-eye-closed"></i>
                            </span>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
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
    <style>
        .bi-eye-fill {
            display: block;
        }

        .bi-eye-slash-fill {
            display: none;
        }

        .bi-eye-fill,
        .bi-eye-slash-fill {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
        }

        .input-group-text {
            padding: .375rem 1.5em !important;
            background: var(--accent-gradient)
        }
    </style>
    <script>
        const password1 = document.getElementById('password');
        const password2 = document.getElementById('password_confirmation');
        const eye1 = document.querySelector('.password-eye');
        const eyeSlash1 = document.querySelector('.password-eye-closed');
        const eye2 = document.querySelector('.password-confirm-eye');
        const eyeSlash2 = document.querySelector('.password-confirm-eye-closed');


        eye1.addEventListener('click', () => {
            eye1.style.display = 'none';
            eyeSlash1.style.display = 'block';
            password1.setAttribute('type', 'text');
        });

        eyeSlash1.addEventListener('click', () => {
            eyeSlash1.style.display = 'none';
            eye1.style.display = 'block';
            password1.setAttribute('type', 'password');
        });

        eye2.addEventListener('click', () => {
            eye2.style.display = 'none';
            eyeSlash2.style.display = 'block';
            password2.setAttribute('type', 'text');
        });

        eyeSlash2.addEventListener('click', () => {
            eyeSlash2.style.display = 'none';
            eye2.style.display = 'block';
            password2.setAttribute('type', 'password');
        });
    </script>
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
