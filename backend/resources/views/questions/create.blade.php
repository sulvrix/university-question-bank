@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Question</h1>
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <label for="text" class="form-label">Question:</label>
                    <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" required>{{ old('text') }}</textarea>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-8">
                    <h3>Answers</h3>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="row mb-2 align-items-center">
                            <div class="col-10">
                                <label class="form-label">Answer {{ $i + 1 }}:</label>
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
            <a href="javascript:history.back();" class="btn btn-secondary">Go Back</a>
            <button type="submit" class="btn btn-primary">Create Question</button>
        </form>
    </div>

    <style>
        .custom-radio {
            width: 20px;
            height: 20px;
        }

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
@endsection
