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
                        @if (Auth::check() && auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label for="faculty_id" class="form-label">Faculty:</label>
                                <select class="form-control" name="faculty_id" id="faculty_id" required>
                                    <option value="">Select Faculty</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty['id'] }}"
                                            {{ old('faculty_id') == $faculty['id'] ? 'selected' : '' }}>
                                            {{ $faculty['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="faculty_id" value="{{ auth()->user()->department->faculty_id }}"
                                id="faculty_id">
                        @endif
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
                        @if (Auth::check() && auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department:</label>
                                <select class="form-control" name="department_id" id="department_id" required disabled>
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            data-faculty-id="{{ $department->faculty_id }}"
                                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}"
                                id="department_id">
                        @endif

                        <div class="mb-3" id="subject_dropdown">
                            <label for="subject_ids" class="form-label">Subjects:</label>
                            <div class="dropdown">
                                <button class="form-control dropdown-toggle customDropDown-toggle" type="button"
                                    id="subjectDropdownButton" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                    Select Subjects
                                </button>
                                <ul class="dropdown-menu customDropDown-menu" aria-labelledby="subjectDropdownButton">
                                    @foreach ($subjects as $subject)
                                        <li>
                                            <label class="dropdown-item customDropDown-item">
                                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                                    data-department-id="{{ $subject->department_id }}"
                                                    {{ in_array($subject->id, old('subject_ids', [])) ? 'checked' : '' }}>
                                                {{ $subject->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('subject_ids')
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
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <div class="mb-3 input-group">
                            <input type="password" class="form-control" name="password_confirmation" required
                                autocomplete="new-password" id="password_confirmation">
                            <span class="input-group-text" id="inputGroup-sizing-default addon-wrapping">
                                <i class="bi bi-eye-fill password-confirm-eye"></i>
                                <i class="bi bi-eye-slash-fill password-confirm-eye-closed"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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
        /* Custom Select Dropdown */
        .customDropDown-toggle {
            padding: 5px;
            font-size: 16px;
            line-height: 1;
            border: 0;
            border-radius: 5px;
            height: 34px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"> <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" /> </svg>') no-repeat right #ddd;
            -webkit-appearance: none;
            background-position-x: 98%;
            text-align: left;
        }

        .customDropDown-toggle::after {
            display: none !important;
        }

        .customDropDown-menu {
            width: 100% !important;
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        .customDropDown-item:hover {
            background-color: var(--primary) !important;
            color: #ddd;
        }

        .customDropDown-item {
            padding: 0.5rem 1rem !important;
        }


        .customDropDown-item input[type="checkbox"] {
            scale: 1.5 !important;
            margin-right: 0.5rem !important;
            accent-color: var(--secondary) !important;

        }

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
        document.addEventListener('DOMContentLoaded', function() {
            const roleDropdown = document.getElementById('role');
            const facultyDropdown = document.getElementById('faculty_id');
            const departmentDropdown = document.getElementById('department_id');
            const subjectDropdown = document.getElementById('subject_dropdown');
            const subjectCheckboxes = document.querySelectorAll('input[name="subject_ids[]"]');
            const subjectDropdownButton = document.getElementById('subjectDropdownButton');

            // Function to filter departments based on the selected faculty
            function filterDepartments(facultyId) {
                const departmentOptions = departmentDropdown.querySelectorAll('option');
                departmentOptions.forEach(option => {
                    if (option.value === "") {
                        return; // Skip the default option
                    }
                    const departmentFacultyId = option.getAttribute('data-faculty-id');
                    if (facultyId === null || departmentFacultyId == facultyId) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Enable or disable the department dropdown based on whether a faculty is selected
                if (facultyId) {
                    departmentDropdown.disabled = false;
                } else {
                    departmentDropdown.disabled = true;
                    departmentDropdown.value = ""; // Clear the selected value
                    resetSubjects(); // Reset subjects when no faculty is selected
                }
            }

            // Function to filter subjects based on the selected department
            function filterSubjects(departmentId) {
                subjectCheckboxes.forEach(checkbox => {
                    const subjectDepartmentId = checkbox.getAttribute('data-department-id');
                    if (departmentId === null || subjectDepartmentId == departmentId) {
                        checkbox.closest('li').style.display = 'block';
                    } else {
                        checkbox.closest('li').style.display = 'none';
                    }
                });
            }

            // Function to reset the subjects dropdown
            function resetSubjects() {
                subjectCheckboxes.forEach(checkbox => {
                    checkbox.checked = false; // Uncheck all checkboxes
                    checkbox.closest('li').style.display = 'none'; // Hide all subjects
                });
                updateDropdownButtonText(); // Update the dropdown button text
            }

            // Function to update the dropdown button text
            function updateDropdownButtonText() {
                const selectedSubjects = Array.from(subjectCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.nextSibling.textContent.trim());

                if (selectedSubjects.length > 0) {
                    // Show only the first subject and truncate if necessary
                    subjectDropdownButton.textContent = selectedSubjects[0].length > 20 ?
                        selectedSubjects[0].substring(0, 40) + '...' :
                        selectedSubjects[0];
                    if (selectedSubjects.length > 1) {
                        subjectDropdownButton.textContent += ` (+${selectedSubjects.length - 1})`;
                    }
                } else {
                    subjectDropdownButton.textContent = 'Select Subjects';
                }
            }

            // Event listeners
            roleDropdown.addEventListener('change', function() {
                if (this.value === 'teacher') { // Reset the department dropdown) {
                    subjectDropdownButton.disabled = false;
                    filterSubjects(departmentDropdown.value);
                } else {
                    subjectDropdownButton.disabled = true;
                    resetSubjects(); // Reset subjects when the role is not "teacher"
                }
            });

            facultyDropdown.addEventListener('change', function() {
                filterDepartments(this.value);
                departmentDropdown.value = ""; // Reset the department dropdown
                resetSubjects(); // Reset the subjects dropdown
            });

            departmentDropdown.addEventListener('change', function() {
                if (roleDropdown.value === 'teacher') {
                    resetSubjects(); // Reset subjects before filtering
                    filterSubjects(this.value);
                }
            });

            subjectCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateDropdownButtonText);
            });

            // Initial check
            if (roleDropdown.value === 'teacher') {
                subjectDropdownButton.disabled = false;
                filterSubjects(departmentDropdown.value);
            } else {
                subjectDropdownButton.disabled = true;
                resetSubjects(); // Reset subjects if the role is not "teacher"
            }
            updateDropdownButtonText();
        });
    </script>
@endsection
