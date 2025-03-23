@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <h1>Edit Subject</h1>
            <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">
            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name }}"
                        required>
                    @if ($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                @if (auth()->user()->department_id == '2')
                    <div class="mb-3">
                        <label for="level" class="form-label">Level:</label>
                        <select class="form-control" name="level" id="level" required>
                            <option value="1" {{ $subject->level == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $subject->level == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $subject->level == '3' ? 'selected' : '' }}>3</option>
                        </select>
                        @if ($errors->has('level'))
                            <div class="text-danger">{{ $errors->first('level') }}</div>
                        @endif
                    </div>
                @else
                    <div class="mb-3">
                        <label for="level" class="form-label">Level:</label>
                        <select class="form-control" name="level" id="level" required>
                            <option value="1" {{ $subject->level == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $subject->level == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ $subject->level == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ $subject->level == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $subject->level == '5' ? 'selected' : '' }}>5</option>
                        </select>
                        @if ($errors->has('level'))
                            <div class="text-danger">{{ $errors->first('level') }}</div>
                        @endif
                    </div>
                @endif

                @if (auth()->user()->role == 'admin')
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Faculty:</label>
                        <select class="form-control" name="faculty_id" id="faculty_id">
                            <option value="">Select Faculty</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}"
                                    {{ $subject->department->faculty_id == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department:</label>
                        <select class="form-control" name="department_id" id="department_id">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" data-faculty-id="{{ $department->faculty_id }}"
                                    {{ $subject->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}"
                        id="department_id">
                    <input type="hidden" name="faculty_id" value="{{ auth()->user()->department->faculty_id }}"
                        id="faculty_id">
                @endif

                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a class="btn btn-secondary" href="{{ '/dashboard' }}" role="button">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const facultyDropdown = document.getElementById('faculty_id');
        const departmentDropdown = document.getElementById('department_id');

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
            }
        }


        facultyDropdown.addEventListener('change', function() {
            filterDepartments(this.value);
            departmentDropdown.value = ""; // Reset the department dropdown
        });
    </script>
@endsection
