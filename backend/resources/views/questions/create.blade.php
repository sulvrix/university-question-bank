@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Question</h1>
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <label for="text" class="form-label">Question:</label>
                    <div class="input-group">
                        <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" required rows="1">{{ old('text') }}</textarea>
                        <button type="button" id="rephraseButton" class="btn btn-secondary">Rephrase
                            Question</button>
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
                                <label class="form-label">Choice {{ $i + 1 }}:</label>
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
                            class="form-select @error('difficulty') is-invalid @enderror">
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
                            class="form-select @error('subject_id') is-invalid @enderror" required>
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
                <a href="javascript:history.back();" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary">Create Question</button>
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
                    <div id="originalQuestion" class="original-question"></div>
                    <div id="rephraseList">
                        <!-- Rephrased questions will be inserted here dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <style>
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
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/rephrase.js') }}"></script>
@endsection
