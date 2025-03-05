@extends('layouts.app')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title mb-0">Create Exam</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Exam Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Level Radio Buttons -->
                    <div class="mb-3">
                        <label class="form-label">Level</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="1" id="level1"
                                checked>
                            <label class="form-check-label" for="level1">Level 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="2" id="level2">
                            <label class="form-check-label" for="level2">Level 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="level" value="3" id="level3">
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
                                <option value="{{ $i }}">{{ $i }}</option>
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
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                    @endif
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title mb-0">Questions</h1>
                    </div>
                    <div class="card-body">
                        <!-- Select/Deselect All Checkbox -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                                <label class="form-check-label" for="select-all-checkbox">Select All</label>
                            </div>
                        </div>
                        <!-- Questions Table -->
                        <div class="mb-3">
                            <div class="table-responsive" id="questions-table-container">
                                <!-- The table will be dynamically created here by JavaScript -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <a href="{{ route('dashboard.exams') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create Exam</button>
                            <button type="button" id="random-exam-btn" class="btn btn-outline-success">Random</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <!-- Pass Questions as a JavaScript Variable -->
    <script>
        const allQuestions = @json($questions);
    </script>

    <!-- JavaScript for Filtering Questions -->
    <script src="{{ asset('js/createFilter.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Select/Deselect All Checkbox
            $('#select-all-checkbox').change(function() {
                const isChecked = $(this).prop('checked');
                $('input[name="questions[]"]').prop('checked', isChecked);
            });

            // Generate Random Exam
            $('#random-exam-btn').click(function() {
                const questions = $('input[name="questions[]"]');
                const totalQuestions = questions.length;
                const requiredQuestions = 5; // Number of questions to select randomly

                // Deselect all questions first
                questions.prop('checked', false);

                // Randomly select questions
                const selectedIndices = new Set();
                while (selectedIndices.size < requiredQuestions && selectedIndices.size < totalQuestions) {
                    const randomIndex = Math.floor(Math.random() * totalQuestions);
                    selectedIndices.add(randomIndex);
                }

                // Check the randomly selected questions
                selectedIndices.forEach(index => {
                    questions.eq(index).prop('checked', true);
                });
            });

            // Validate at least 5 questions are selected before form submission
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
