@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <!-- Question Section -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card p-4 mb-4">
                    <h3>Question Details</h3>
                    <hr class="mb-4 mt-0 border border-primary-subtle border-3 opacity-50">
                    <div class="mb-3">
                        <label for="text" class="form-label">Question:</label>
                        <div class="input-group">
                            <input name="text" id="text" class="form-control" rows="3"
                                value="{{ $question->text }}" readonly>
                        </div>
                    </div>

                    <!-- Answers Section -->
                    <h3 class="mt-4 mb-3">Answers</h3>
                    @foreach ($answers as $index => $answer)
                        <div class="row mb-3 align-items-center">
                            <div class="col-10">
                                <label class="form-label" for="answers[{{ $index }}][text]">Choice
                                    {{ $index + 1 }}:</label>
                                <input type="text" name="answers[{{ $index }}][text]" class="form-control"
                                    value="{{ $answer['text'] }}" readonly>
                            </div>
                            <div class="col-2 text-center">
                                <div class="form-check">
                                    <input type="radio" name="correct_answer" value="{{ $index }}"
                                        class="form-check-input custom-radio" {{ $answer['is_correct'] ? 'checked' : '' }}
                                        disabled>
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
                    <h3>Additional Settings</h3>
                    <hr class="mb-4 mt-0 border border-primary-subtle border-3 opacity-50">
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <input type="text" name="difficulty" id="difficulty" class="form-control"
                            value="{{ ucfirst($question->difficulty) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="points" class="form-label">Points:</label>
                        <input type="number" name="points" id="points" class="form-control"
                            value="{{ $question->points }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject:</label>
                        <input type="text" name="subject_id" id="subject_id" class="form-control"
                            value="{{ $question->subject->name }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="d-flex align-items-center justify-content-center gap-3">
            <a href="{{ route('dashboard.questions') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Styles -->
    <style>
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
    </style>
@endsection
