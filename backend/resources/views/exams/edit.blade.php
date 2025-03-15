@extends('layouts.dashboard')

@section('content')
<div class="position-fixed top-0 start-50 translate-middle-x z-3 p-2" id="alertPlaceholder"
    style="z-index: 1500 !important;"></div>
<div class="container mt-5">
    <form action="{{ route('exams.update', $exam->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-4">
            <!-- Exam Details Section -->
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <h3>Exam Details</h3>
                    <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Exam Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" required value="{{ $exam->name }}"
                            placeholder="Enter exam name...">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Level Dropdown -->
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                            <option value="1" {{ $exam->level == 1 ? 'selected' : '' }}>Level 1</option>
                            <option value="2" {{ $exam->level == 2 ? 'selected' : '' }}>Level 2</option>
                            <option value="3" {{ $exam->level == 3 ? 'selected' : '' }}>Level 3</option>
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
                            @for ($i = 1; $i <= 6; $i++) <option value="{{ $i }}" {{ $exam->block == $i ? 'selected' :
                                '' }}>
                                {{ 'Block ' . $i }}</option>
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
                            <option value="{{ $department->id }}" {{ $exam->department_id == $department->id ?
                                'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="department_id" value="{{ auth()->user()->department_id }}">
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Questions Section -->
            <div class="col-md-12">
                <div class="card p-4">
                    <h3 class="mb-3">Questions</h3>

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
        const selectedQuestions = @json($exam->questions->pluck('id')->toArray());
</script>
<script src="{{ asset('js/editFilter.js') }}"></script>
<script>
    $(document).ready(function() {
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
                    showAlert('Please select at least five questions.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
</script>
@endsection