@extends('layouts.app')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title mb-0">Edit Exam</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Exam Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $exam->name }}"
                            required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Level Radio Buttons -->
                    <div class="mb-3">
                        <label class="form-label">Level</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="1" id="level1"
                                {{ $exam->level == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="level1">Level 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="2" id="level2"
                                {{ $exam->level == 2 ? 'checked' : '' }}>
                            <label class="form-check-label" for="level2">Level 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="3" id="level3"
                                {{ $exam->level == 3 ? 'checked' : '' }}>
                            <label class="form-check-label" for="level3">Level 3</label>
                        </div>
                        @error('level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Block Dropdown -->
                    <div class="mb-3">
                        <label for="block" class="form-label">Block</label>
                        <select name="block" id="block" class="form-select" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ $exam->block == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        @error('block')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department Dropdown -->
                    @if (auth()->user()->role == 'admin')
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ $exam->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title mb-0">Questions</h1>
                    </div>
                    <div class="card-body">
                        <!-- Questions Table -->
                        <div class="mb-3">
                            <div class="table-responsive" id="questions-table-container">
                                <!-- The table will be dynamically created here by JavaScript -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <a href="{{ route('dashboard.exams') }}" class="btn btn-secondary">Go Back</a>
                            <button type="submit" class="btn btn-primary">Update Exam</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <!-- Pass Questions and Selected Questions as JavaScript Variables -->
    <script>
        const allQuestions = @json($questions);
        const selectedQuestions = @json($exam->questions->pluck('id')->toArray());
    </script>

    <!-- JavaScript for Filtering Questions -->
    <script>
        $(document).ready(function() {
            let dataTable;

            // Function to create and populate the table
            function createAndPopulateTable(questions) {
                // Clear the table container
                $('#questions-table-container').empty();

                // Create the table structure
                const table = `
                    <table class="table table-bordered table-hover" id="questionsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Select</th>
                                <th>Question</th>
                                <th>Difficulty</th>
                                <th>Points</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${questions.map(question => `
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="questions[]" value="${question.id}" class="form-check-input"
                                                        ${selectedQuestions.includes(question.id) ? 'checked' : ''}>
                                                </td>
                                                <td>${question.text}</td>
                                                <td>${question.difficulty}</td>
                                                <td>${question.points}</td>
                                                <td>${question.subject.name}</td>
                                            </tr>
                                        `).join('')}
                        </tbody>
                    </table>
                `;

                // Append the table to the container
                $('#questions-table-container').html(table);

                // Initialize DataTable
                dataTable = $('#questionsTable').DataTable({
                    paging: true, // Enable pagination
                    searching: true, // Enable search
                    ordering: true, // Enable sorting
                    info: true, // Show table information
                    pageLength: 10, // Default number of rows per page
                    lengthMenu: [10, 25, 50, 100], // Rows per page options
                    columnDefs: [{
                            targets: 0, // First column (Select)
                            width: '50px',
                            className: 'dt-center',
                            orderable: false, // Disable sorting for this column
                        },
                        {
                            targets: 1, // Second column (Question)
                            className: 'dt-left',
                        },
                        {
                            targets: [2, 3, 4], // Difficulty, Points, Subject columns
                            className: 'dt-left',
                        },
                    ],
                });
            }

            // Function to filter questions by level and department
            function filterQuestions(level, departmentId) {
                const filteredQuestions = allQuestions.filter(question => {
                    return question.subject &&
                        question.subject.level == level &&
                        (departmentId == 1 || question.subject.department_id == departmentId);
                });

                // Create and populate the table with filtered questions
                createAndPopulateTable(filteredQuestions);
            }

            // Load questions on page load (default level and department from the exam)
            const defaultLevel = {{ $exam->level }};
            const defaultDepartmentId = $('#department_id').val();
            filterQuestions(defaultLevel, defaultDepartmentId);

            // Load questions when level or department changes
            $('input[name="level"], #department_id').change(function() {
                const level = $('input[name="level"]:checked').val();
                const departmentId = $('#department_id').val();
                filterQuestions(level, departmentId);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                const selectedQuestions = $('input[name="questions[]"]:checked').length;
                if (selectedQuestions < 5) {
                    alert('Please select at least five questions.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
@endsection
