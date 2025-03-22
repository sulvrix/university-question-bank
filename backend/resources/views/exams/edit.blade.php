@extends('layouts.dashboard')

@section('content')
    <div class="position-fixed top-0 start-50 translate-middle-x z-3 p-2" id="alertPlaceholder"
        style="z-index: 1500 !important;"></div>
    <div class="container mt-5">
        <form action="{{ route('exams.update', $exam->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card p-4 mb-4">
                <div class="row mb-4">
                    <!-- Exam Details Section -->
                    <h3>Exam Details</h3>
                    <hr class="mb-4 mt-0 border border-primary-subtle border-3 opacity-50">
                    <div class="col-md-6">

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Exam Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" required
                                value="{{ $exam->name }}" placeholder="Enter exam name...">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Level Select Menu -->
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                @if (auth()->user()->department_id == '2')
                                    <option value="1" {{ $exam->level == 1 ? 'selected' : '' }}>Level 1</option>
                                    <option value="2" {{ $exam->level == 2 ? 'selected' : '' }}>Level 2</option>
                                    <option value="3" {{ $exam->level == 3 ? 'selected' : '' }}>Level 3</option>
                                @else
                                    <option value="1" {{ $exam->level == 1 ? 'selected' : '' }}>Level 1</option>
                                    <option value="2" {{ $exam->level == 2 ? 'selected' : '' }}>Level 2</option>
                                    <option value="3" {{ $exam->level == 3 ? 'selected' : '' }}>Level 3</option>
                                    <option value="4" {{ $exam->level == 4 ? 'selected' : '' }}>Level 4</option>
                                    <option value="5" {{ $exam->level == 5 ? 'selected' : '' }}>Level 5</option>
                                @endif
                            </select>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (auth()->user()->department_id == '2')
                            <div class="mb-3">
                                <label for="block" class="form-label">Block</label>
                                <select name="block" id="block"
                                    class="form-control @error('block') is-invalid @enderror" required>
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $exam->block == $i ? 'selected' : '' }}>
                                            {{ 'Block ' . $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="block" value="">
                        @endif

                        <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">

                        @if (auth()->user()->department_id == '2')
                            <input type="hidden" name="examiner" value="">
                        @else
                            <div class="mb-3">
                                <label for="examiner" class="form-label">Examiner</label>
                                <select name="examiner" id="examiner"
                                    class="form-control @error('examiner') is-invalid @enderror" required>
                                    <option value="">Select Examiner</option>
                                    @foreach ($examiners as $examiner)
                                        <option value="{{ $examiner->name }}"
                                            {{ $exam->examiner == $examiner->name ? 'selected' : '' }}
                                            data-subjects="{{ $examiner->subjects->pluck('id')->toJson() }}">
                                            {{ $examiner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('examiner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">

                        <!-- Duration Input -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (in Minutes)</label>
                            <input type="number" name="duration" id="duration"
                                class="form-control @error('duration') is-invalid @enderror" required
                                value="{{ $exam->duration }}" placeholder="Enter exam duration..." min="1">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Input -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Exam Date</label>
                            <input type="date" name="date" id="date"
                                class="form-control @error('date') is-invalid @enderror" required
                                value="{{ $exam->date }}" min="{{ now()->addDay()->format('m-d-Y') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject Dropdown -->
                        @if (auth()->user()->department_id == '2')
                            <input type="hidden" name="subject_id" value="">
                        @else
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">Subject</label>
                                <select name="subject_id" id="subject_id"
                                    class="form-control @error('subject_id') is-invalid @enderror" required>
                                    <option value="">Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ $exam->subject_id == $subject->id ? 'selected' : '' }}
                                            data-level="{{ $subject->level }}">
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                    <i class="bi bi-save"></i> Update Exam
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            // When the level dropdown changes
            $('#level').change(function() {
                const selectedLevel = $(this).val();

                // Filter subjects based on the selected level
                $('#subject_id option').each(function() {
                    const subjectLevel = $(this).data('level');
                    if (subjectLevel == selectedLevel) {
                        $(this).show(); // Show subjects with matching level
                    } else {
                        $(this).hide(); // Hide subjects with non-matching level
                    }
                });

                // Reset the selected value in the subject dropdown
                $('#subject_id').val('');

                // Disable the examiner dropdown if no subject is selected
                $('#examiner').prop('disabled', true);
                $('#examiner').val('');
            });

            // When the subject dropdown changes (to handle examiner filtering)
            $('#subject_id').change(function() {
                const selectedSubjectId = $(this).val();

                if (selectedSubjectId) {
                    // Enable the examiner dropdown
                    $('#examiner').prop('disabled', false);

                    // Filter examiners based on the selected subject
                    $('#examiner option').each(function() {
                        const subjectsData = $(this).data('subjects');
                        if (subjectsData) {
                            const examinerSubjects = Array.isArray(subjectsData) ? subjectsData :
                                JSON.parse(subjectsData); // Ensure it's an array
                            const hasSubject = examinerSubjects.includes(parseInt(
                                selectedSubjectId
                            )); // Check if the examiner teaches the selected subject

                            if (hasSubject) {
                                $(this).show(); // Show examiners who teach the selected subject
                            } else {
                                $(this)
                                    .hide(); // Hide examiners who don't teach the selected subject
                            }
                        } else {
                            $(this).hide(); // Hide examiners without subjects data
                        }
                    });

                    // Reset the selected value in the examiner dropdown
                    $('#examiner').val('');
                } else {
                    // If no subject is selected, disable the examiner dropdown
                    $('#examiner').prop('disabled', true);
                    $('#examiner').val('');
                }
            });

            // Trigger the subject change event on page load to initialize the examiner dropdown
            $('#subject_id').trigger('change');
            $('#level').trigger('change');

            $('#subject_id').val('{{ $exam->subject_id }}').trigger('change');
            $('#examiner').val('{{ $exam->examiner }}').trigger('change');
        });
    </script>
    <script>
        const allQuestions = @json($questions);
        const selectedQuestions = @json($exam->questions->pluck('id')->toArray());
        const departmentId = {{ auth()->user()->department_id }};
    </script>
    <script src="{{ asset('js/editFilter.js') }}"></script>
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
@endsection
