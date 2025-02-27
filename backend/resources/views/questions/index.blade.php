@extends('layouts.dashboard')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ __('Questions') }}</div>
                        <div class="card-body">
                            <table class="table table-hover" style="font-size: 1.25em" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Text</th>
                                        <th scope="col">Answer</th>
                                        <th scope="col">Difficulty</th>
                                        <th scope="col">Points</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>{{ $question->text }}</td>
                                            <td>{{ $question->correct_answer }}</td>
                                            <td>{{ $question->difficulty }}</td>
                                            <td>{{ $question->points }}</td>
                                            <td>{{ $question->subject->name }}</td>
                                            <td>{{ $question->created_at }}</td>
                                            <td>
                                                <a href="{{ route('questions.edit', $question) }}" role="button"><i
                                                        class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('questions.destroy', $question) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="border:none; background:none;color:red;"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Create New
                                    Question</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
