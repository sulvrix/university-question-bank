@extends('layouts.app')

@section('content')
    <h1>Edit Question</h1>
    <form action="{{ route('questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="col-12">
            <label for="text" class="form-label">Question:</label>
            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" required>{{ $question->text }}</textarea>
            @error('text')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <h3>Answers</h3>
                @foreach ($question->answers as $index => $answer)
                    <div class="row mb-2 align-items-center">
                        <div class="col-10">
                            <label class="form-label">Answer {{ $index + 1 }}:</label>
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
                    <select name="difficulty" id="difficulty" class="form-select @error('difficulty') is-invalid @enderror">
                        <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>Hard</option>
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
                    <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror"
                        required>
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

        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
@endsection
