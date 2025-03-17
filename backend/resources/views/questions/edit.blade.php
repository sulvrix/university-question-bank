@extends('layouts.dashboard')

@section('content')
    <div class="position-fixed top-0 start-50 translate-middle-x z-3 p-2" id="alertPlaceholder"
        style="z-index: 1500 !important;"></div>
    <div class="container mt-5">
        <form action="{{ route('questions.update', $question) }}" method="POST" id="questionForm">
            @csrf
            @method('PUT')
            <!-- Question Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card p-4 mb-4">
                        <h3 class="mb-3">Question Details</h3>
                        <div class="mb-3">
                            <label for="text" class="form-label">Question:</label>
                            <div class="input-group">
                                <textarea name="text" id="text" class="form-control" rows="1" placeholder="Enter your question here..."
                                    required>{{ $question->text }}</textarea>
                                <button type="button" id="rephraseButton" class="btn btn-secondary"
                                    data-bs-toggle="tooltip" title="Click to rephrase the question">
                                    <i class="bi bi-arrow-repeat"></i> Rephrase
                                </button>
                            </div>
                            @if ($errors->has('text'))
                                <div class="text-danger">{{ $errors->first('text') }}</div>
                            @endif
                        </div>

                        <!-- Answers Section -->
                        <h3 class="mt-4 mb-3">Answers</h3>
                        @foreach ($question->answers as $index => $answer)
                            <div class="row mb-3 align-items-center">
                                <div class="col-10">
                                    <label class="form-label" for="answers[{{ $index }}][text]">Choice
                                        {{ $index + 1 }}:</label>
                                    <input type="text" name="answers[{{ $index }}][text]"
                                        class="form-control @error('answers.' . $index . '.text') is-invalid @enderror"
                                        placeholder="Enter choice {{ $index + 1 }}..." value="{{ $answer['text'] }}"
                                        required>
                                    @error('answers.' . $index . '.text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2 text-center">
                                    <div class="form-check">
                                        <input type="radio" name="correct_answer" value="{{ $index }}"
                                            class="form-check-input custom-radio"
                                            {{ $answer['is_correct'] ? 'checked' : '' }}>
                                        <label class="form-check-label visually-hidden">Correct</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Additional Settings Section -->
                <div class="col-md-4">
                    <div class="card p-4">
                        <h3 class="mb-3">Additional Settings</h3>
                        <div class="mb-3">
                            <label for="difficulty" class="form-label">Difficulty:</label>
                            <select name="difficulty" id="difficulty"
                                class="form-control @error('difficulty') is-invalid @enderror">
                                <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>Easy
                                </option>
                                <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>
                                    Medium
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
                                value="{{ $question->points }}" placeholder="Enter points...">
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if (in_array(auth()->user()->role, ['admin', 'staff', 'commissioner']))
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
                            </div>
                        @else
                            <input type="hidden" name="subject_id" value="{{ auth()->user()->subject_id }}">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex align-items-center justify-content-center gap-3">
                <a href="{{ route('dashboard.questions') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button id="clearBtn" type="button" class="btn btn-warning">
                    <i class="bi bi-eraser"></i> Clear
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Question
                </button>
            </div>
        </form>
    </div>

    <!-- Rephrase Modal -->
    <div class="modal fade" id="rephraseModal" tabindex="-1" aria-labelledby="rephraseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rephraseModalLabel">Rephrased Questions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="originalQuestion"
                        class="original-question mb-4 p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
                    </div>
                    <div id="rephraseList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    </style>

    <!-- Scripts -->
    @vite(['resources/js/rephrase.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
