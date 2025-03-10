@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h1>Edit Question</h1>
        <form action="{{ route('questions.update', $question) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3 mt-5">
                <div class="col-12">
                    <label for="text" class="form-label">Question:</label>
                    <div class="input-group">
                        <input name="text" id="text" class="form-control @error('text') is-invalid @enderror" required
                            value="{{ $question->text }}">
                        <button type="button" id="rephraseButton" class="btn btn-secondary">Rephrase</button>
                    </div>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    @foreach ($question->answers as $index => $answer)
                        <div class="row mb-2 align-items-center">
                            <div class="col-10">
                                <label class="form-label" for="answers[{{ $index }}][text]">Choice
                                    {{ $index + 1 }}:</label>
                                <input type="text" name="answers[{{ $index }}][text]"
                                    class="form-control @error('answers.' . $index . '.text') is-invalid @enderror"
                                    value="{{ $answer['text'] }}" required>
                                @error('answers.' . $index . '.text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2 text-center">
                                <div class="form-check">
                                    <input type="radio" name="correct_answer" value="{{ $index }}"
                                        class="form-check-input custom-radio" {{ $answer['is_correct'] ? 'checked' : '' }}>
                                    <label class="form-check-label visually-hidden">Correct</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <select name="difficulty" id="difficulty"
                            class="form-control @error('difficulty') is-invalid @enderror">
                            <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>Hard
                            </option>
                        </select>
                        @error('difficulty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label">Points:</label>
                        <input type="number" name="points" id="points"
                            class="form-control @error('points') is-invalid @enderror" min="1" max="10"
                            value="{{ $question->points }}">
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
                                    {{ $question->subject_id == $subject->id ? 'selected' : '' }}>
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
                <button type="submit" class="btn btn-primary">Update Question</button>
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

        .form-label {
            display: block;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: bold;
            color: #05060f99;
            transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
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
@endsection
