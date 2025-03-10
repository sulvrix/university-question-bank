@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h1>Create Question</h1>
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="row mb-3 mt-5">
                <div class="col-12">
                    <label for="text" class="form-label">Question:</label>
                    <div class="input-group">
                        <input name="text" id="text" class="form-control @error('text') is-invalid @enderror"
                            required>{{ old('text') }}</input>
                        <button type="button" id="rephraseButton" class="btn btn-secondary">Rephrase</button>
                    </div>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    {{-- <h3>Answers</h3> --}}
                    @for ($i = 0; $i < 4; $i++)
                        <div class="row mb-2 align-items-center">
                            <div class="col-10">
                                <label class="form-label" for="answers[{{ $i }}][text]">Choice
                                    {{ $i + 1 }}:</label>
                                <input type="text" name="answers[{{ $i }}][text]"
                                    class="form-control @error('answers.' . $i . '.text') is-invalid @enderror"
                                    value="{{ old('answers.' . $i . '.text') }}" required>
                                @error('answers.' . $i . '.text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2 text-center">
                                <div class="form-check">
                                    <input type="radio" name="correct_answer" value="{{ $i }}"
                                        class="form-check-input custom-radio"
                                        {{ old('correct_answer', 0) == $i ? 'checked' : '' }}>
                                    <label class="form-check-label visually-hidden">Correct</label>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <select name="difficulty" id="difficulty"
                            class="form-control @error('difficulty') is-invalid @enderror">
                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label">Points:</label>
                        <input type="number" name="points" id="points"
                            class="form-control @error('points') is-invalid @enderror" min="1" max="10"
                            value="{{ old('points') }}">
                        @error('points')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject:</label>
                        <select name="subject_id" id="subject_id"
                            class="form-control @error('subject_id') is-invalid @enderror" required>
                            <option value="">Select a subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('dashboard.questions') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Create Question</button>
                <a href="{{ route('questions.generate') }}" class="btn btn-info">Generate</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap 5.3.3 Modal -->
    <div class="modal fade" id="rephraseModal" tabindex="-1" aria-labelledby="rephraseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rephraseModalLabel">Rephrased Questions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="originalQuestion"
                        class="original-question p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
                    </div>
                    <div id="rephraseList">
                        <!-- Rephrased questions will be inserted here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <style>
        /* Loading overlay styles */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Ensure it's above other content */
            display: none;
            /* Hidden by default */
        }

        .custom-radio {
            margin-top: 30px;
            width: 30px;
            /* Adjust the width */
            height: 30px;
            /* Adjust the height */

            /* Remove default margin */
            cursor: pointer;
            /* Add pointer cursor */
        }

        .form-check-input:checked {
            background-color: #607de3;
            border-color: #607de3;
        }

        /* Ensure modal is centered and scrollable */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
            /* Adjust for Bootstrap's default margin */
        }

        .modal {
            scrollbar-width: none;
            overflow-y: hidden;
            /* Hide scrollbar for Firefox */
            -ms-overflow-style: none;
            /* Hide scrollbar for IE and Edge */
        }

        /* Style for the original question */
        .original-question {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        /* Style for the rephrased questions */
        .rephrased-question {
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }

        .rephrased-question:hover {
            background-color: #f1f1f1;
        }

        .form-control {
            /* max-width: 190px; */
            height: 44px;
            background-color: #05060f0a;
            border-radius: .5rem;
            padding: 0 1rem;
            border: 2px solid transparent;
            font-size: 1rem;
            transition: border-color .3s cubic-bezier(.25, .01, .25, 1) 0s, color .3s cubic-bezier(.25, .01, .25, 1) 0s, background .2s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        select {
            width: 268px;
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

        .form-label {
            display: block;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: bold;
            color: #05060f99;
            transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        .form-control:hover,
        .form-control:focus,
        .form-control-group:hover .form-control {
            outline: none;
            border-color: #05060f;
        }

        .input-group:hover .label,
        .form-control:focus {
            color: #05060fc2;
        }
    </style>

    <script src="{{ asset('js/rephrase.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const question = urlParams.get('question');
            const answersParam = urlParams.get('answers'); // Get the raw answers parameter
            const correctAnswer = urlParams.get('correct_answer');

            let answers = [];
            if (answersParam) {
                try {
                    // Attempt to parse the answers parameter as JSON
                    answers = JSON.parse(answersParam);
                } catch (error) {
                    console.error('Failed to parse answers:', error);
                    // If parsing fails, default to an empty array
                    answers = [];
                }
            }

            // Set the question if it exists
            if (question) {
                const questionInput = document.getElementById('text');
                if (questionInput) {
                    questionInput.value = question;
                }
            }

            // Set the answers if they exist
            if (answers.length > 0) {
                answers.forEach((answer, index) => {
                    const answerInput = document.querySelector(`input[name="answers[${index}][text]"]`);
                    if (answerInput) {
                        answerInput.value = answer;
                    }
                });
            }

            // Set the correct answer if it exists
            if (correctAnswer) {
                const correctAnswerIndex = answers.indexOf(correctAnswer);
                if (correctAnswerIndex !== -1) {
                    const correctAnswerRadio = document.querySelector(
                        `input[name="correct_answer"][value="${correctAnswerIndex}"]`);
                    if (correctAnswerRadio) {
                        correctAnswerRadio.checked = true;
                    }
                }
            }
        });
    </script>
@endsection
