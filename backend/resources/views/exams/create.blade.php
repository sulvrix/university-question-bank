@extends('layouts.dashboard')

@section('content')
    <div class="position-fixed top-0 start-50 translate-middle-x z-3 p-2" id="alertPlaceholder"
        style="z-index: 1500 !important;"></div>
    <div class="container mt-5">
        <form action="{{ route('exams.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <!-- Exam Details Section -->
                <div class="col-md-12">
                    <div class="card p-4 mb-4">
                        <h3>Exam Details</h3>
                        <hr class="mb-4 mt-0 border border-primary-subtle border-3 opacity-50">

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Exam Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" required
                                placeholder="Enter exam name...">
                            @error('name')
                                <div class="invalid-feedback">{{ $errors->first('level') }}</div>
                            @enderror
                        </div>

                        <!-- Level Select Menu -->
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                <option value="1" selected>Level 1</option>
                                <option value="2">Level 2</option>
                                <option value="3">Level 3</option>
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Block Dropdown -->
                        <div class="mb-3">
                            <label for="block" class="form-label">Block</label>
                            <select name="block" id="block" class="form-control @error('block') is-invalid @enderror"
                                required>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">{{ 'Block ' . $i }}</option>
                                @endfor
                            </select>
                            @error('block')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Department Dropdown -->
                        @if (auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select name="department_id" id="department_id"
                                    class="form-control @error('department_id') is-invalid @enderror" required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card p-4">
                        <h3>Questions</h3>
                        <hr class="mb-4 mt-0 border border-primary-subtle border-3 opacity-50">
                        <!-- Questions Table -->
                        <div class="mb-3">
                            <div class="table" id="questions-table-container">
                                <!-- The table will be dynamically created here by JavaScript -->
                            </div>
                        </div>

                        <!-- Select All Checkbox -->
                        <div class="mb-3">
                            <div class="form-check">
                                <label class="check-container" for="select-all-checkbox">
                                    <h6>Select all</h6>
                                    <input class="form-check-input" type="checkbox" id="select-all-checkbox">
                                    <div class="checkmark"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('dashboard.exams') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Create Exam
                </button>
                <button type="button" id="random-exam-btn" class="btn btn-info">
                    <i class="bi bi-shuffle"></i> Random
                </button>
            </div>
        </form>
    </div>
    <!-- Modal for Random Configuration -->
    <div class="modal fade" id="randomConfigModal" tabindex="-1" aria-labelledby="randomConfigModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="randomConfigModalLabel">Random Exam Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Difficulty Slider -->
                    <div class="mb-3">
                        <label for="difficultySlider" class="form-label">Difficulty</label>
                        <input type="range" class="form-range" id="difficultySlider" min="0" max="100"
                            step="1" value="50">
                        <div class="d-flex justify-content-between">
                            <small>Easy</small>
                            <small>Medium</small>
                            <small>Hard</small>
                        </div>
                    </div>

                    <!-- Points Slider -->
                    <div class="mb-3">
                        <label for="pointsSlider" class="form-label">Average Points</label>
                        <input type="range" class="form-range" id="pointsSlider" min="1" max="10"
                            step="1" value="5">
                        <div class="d-flex justify-content-between">
                            <small>1</small>
                            <small>2</small>
                            <small>3</small>
                            <small>4</small>
                            <small>5</small>
                        </div>
                    </div>

                    <!-- Subject Distribution Checkbox -->
                    <div class="mb-3">
                        <label class="form-label">Subject Distribution</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="evenDistribution" checked>
                            <label class="form-check-label" for="evenDistribution">
                                Evenly distribute questions across subjects
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applyRandomConfig">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }

        .custom-radio {
            margin-top: 30px;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #607de3;
            border-color: #607de3;
        }

        .form-control {
            height: 44px;
            background-color: #05060f0a;
            border-radius: .5rem;
            padding: 0 1rem;
            border: 2px solid transparent;
            font-size: 1rem;
            transition: border-color .3s cubic-bezier(.25, .01, .25, 1) 0s, color .3s cubic-bezier(.25, .01, .25, 1) 0s, background .2s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        .form-control:hover,
        .form-control:focus {
            outline: none;
            border-color: #05060f;
        }

        .form-label {
            display: block;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: bold;
            color: #05060f99;
            transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        select {
            padding: 5px;
            font-size: 16px;
            line-height: 1;
            border: 0;
            border-radius: 5px;
            height: 34px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"> <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" /> </svg>') no-repeat right #ddd;
            -webkit-appearance: none;
            background-position-x: 98%;
        }

        .check-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .check-container h6 {
            position: relative;
            width: 70px;
            left: 30px;
        }

        .check-container {
            position: relative;
            cursor: pointer;
            font-size: 17px;
            width: 1.25em;
            height: 1.25em;
            user-select: none;
            border: 2px solid black;
            display: block;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .checkmark:after {
            content: '';
            position: absolute;
            top: 25%;
            left: 25%;
            background-color: black;
            width: 50%;
            height: 50%;
            transform: scale(0);
            transition: .1s ease;
        }

        .check-container input:checked~.checkmark:after {
            transform: scale(1);
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        const allQuestions = @json($questions);
    </script>
    <script src="{{ asset('js/createFilter.js') }}"></script>
    <script>
        function showAlert(message, type = 'warning', duration = 5000) {
            const alertPlaceholder = document.getElementById('alertPlaceholder');
            if (!alertPlaceholder) {
                console.error('Alert placeholder not found!');
                return;
            }

            // Create the alert HTML
            const alertHTML = `
<div class="alert alert-${type} alert-dismissible fade show" role="alert">
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
`;

            // Append the alert to the placeholder
            alertPlaceholder.innerHTML = alertHTML;

            // Automatically remove the alert after the specified duration
            setTimeout(() => {
                alertPlaceholder.innerHTML = ''; // Clear the alert
            }, duration);
        }
    </script>
    <script>
        $(document).ready(function() {

            // Select/Deselect All Checkbox
            $('#select-all-checkbox').on('change', function() {
                const isChecked = $(this).prop('checked');
                $('input[name="questions[]"]').prop('checked', isChecked);
            });

            // Handle individual checkbox changes
            $(document).on('change', 'input[name="questions[]"]', function() {
                const allChecked = $('input[name="questions[]"]').length === $(
                    'input[name="questions[]"]:checked').length;
                $('#select-all-checkbox').prop('checked', allChecked);
            });

            // Validate at least 5 questions are selected before form submission
            $('form').submit(function(event) {
                const selectedQuestions = $('input[name="questions[]"]:checked').length;
                if (selectedQuestions < 5) {
                    showAlert('Please select at least five questions.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Open the modal when the random button is clicked
            $('#random-exam-btn').click(function() {
                $('#randomConfigModal').modal('show');
            });

            // Apply the random configuration
            $('#applyRandomConfig').click(function() {
                const difficultySliderValue = parseFloat($('#difficultySlider')
                    .val()); // Get the slider value (0-100)
                const points = parseFloat($('#pointsSlider').val()); // Get the selected points
                const evenDistribution = $('#evenDistribution').prop(
                    'checked'); // Check if even distribution is enabled
                $('input[name="questions[]"]').prop('checked', false);

                // Step 1: Set the total number of questions to select
                const totalQuestionsToSelect = 10; // Change this to the desired number of questions

                // Step 2: Calculate difficulty distribution based on slider position
                let easyPercentage, mediumPercentage, hardPercentage;

                if (difficultySliderValue <= 25) {
                    // First quarter: Mostly easy and medium
                    easyPercentage = 0.45;
                    mediumPercentage = 0.45;
                    hardPercentage = 0.10;
                } else if (difficultySliderValue <= 50) {
                    // Second quarter: More medium, less easy and hard
                    easyPercentage = 0.20;
                    mediumPercentage = 0.60;
                    hardPercentage = 0.20;
                } else if (difficultySliderValue <= 75) {
                    // Third quarter: More medium and hard, less easy
                    easyPercentage = 0.10;
                    mediumPercentage = 0.45;
                    hardPercentage = 0.45;
                } else {
                    // Last quarter: Mostly medium and hard
                    easyPercentage = 0.05;
                    mediumPercentage = 0.45;
                    hardPercentage = 0.50;
                }

                // Step 3: Assign scores to questions based on constraints
                const scoredQuestions = allQuestions.map(question => {
                    let score = 0;

                    // Points score: Higher score for questions closer to the target points
                    const pointsDifference = Math.abs(question.points - points);
                    score += 10 / (pointsDifference + 1); // +1 to avoid division by zero

                    // Difficulty score: Higher score for questions that match the desired difficulty distribution
                    if (question.difficulty === 'easy') {
                        score += easyPercentage * 10;
                    } else if (question.difficulty === 'medium') {
                        score += mediumPercentage * 10;
                    } else if (question.difficulty === 'hard') {
                        score += hardPercentage * 10;
                    }

                    return {
                        ...question,
                        score
                    };
                });

                // Step 4: Sort questions by score (highest score first)
                const sortedQuestions = scoredQuestions.sort((a, b) => b.score - a.score);

                // Step 5: Select questions based on score and constraints
                let selectedQuestions = [];
                let attempts = 0;

                while (selectedQuestions.length < totalQuestionsToSelect && attempts < 10) {
                    // Reset selected questions for each attempt
                    selectedQuestions = [];

                    // Select questions based on score
                    for (const question of sortedQuestions) {
                        if (selectedQuestions.length >= totalQuestionsToSelect) break;

                        // Check if the question matches the constraints
                        const pointsDifference = Math.abs(question.points - points);
                        const pointsRange = 2 + attempts; // Gradually widen the range
                        if (pointsDifference <= pointsRange) {
                            selectedQuestions.push(question);
                        }
                    }

                    attempts++;
                }

                // Step 6: If still not enough questions, fall back to top-scored questions
                if (selectedQuestions.length < totalQuestionsToSelect) {
                    selectedQuestions = sortedQuestions.slice(0, totalQuestionsToSelect);
                }

                // Step 7: If even distribution is enabled, ensure questions are spread across subjects
                if (evenDistribution) {
                    const groupedBySubject = groupBy(selectedQuestions, 'subject.name');
                    const subjects = Object.keys(groupedBySubject);

                    // If there are more subjects than questions, prioritize spreading across subjects
                    if (subjects.length > totalQuestionsToSelect) {
                        selectedQuestions.length = 0; // Reset selected questions
                        for (const subject of subjects.slice(0, totalQuestionsToSelect)) {
                            const questionsInSubject = groupedBySubject[subject];
                            selectedQuestions.push(questionsInSubject[
                                0]); // Select the top-scored question for each subject
                        }
                    }
                }

                // Step 8: Deselect all questions first
                $('input[name="questions[]"]').prop('checked', false);

                // Step 9: Check the selected questions in the table
                selectedQuestions.forEach(question => {
                    $(`input[name="questions[]"][value="${question.id}"]`).prop('checked', true);
                });

                // Step 10: Close the modal
                $('#randomConfigModal').modal('hide');
            });

            // Helper function to group questions by a property (e.g., subject.name)
            function groupBy(array, property) {
                return array.reduce((acc, obj) => {
                    const key = obj[property];
                    if (!acc[key]) {
                        acc[key] = [];
                    }
                    acc[key].push(obj);
                    return acc;
                }, {});
            }
        });
    </script>
@endsection
