@extends('layouts.dashboard')

@section('content')
    <main class="py-4">
        <div class="container form-section">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-header bg-gradient-primary text-white text-center py-4">
                            <h3 class="card-title mb-0">{{ __('Questions') }}</h3>
                        </div>
                        <div class="card-body p-4">
                            <table class="table table-hover table-bordered" style="font-size: 1.25em" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Text</th>
                                        <th scope="col">Answer</th>
                                        <th scope="col">Difficulty</th>
                                        <th scope="col">Points</th>
                                        <th scope="col">Subject</th>
                                        @if (Auth::check() && auth()->user()->department_id == 4)
                                            <th scope="col">Semester</th>
                                        @endif
                                        <th scope="col">Time</th>
                                        <th scope="col">Manage</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->text }}</td>
                                            <td>{{ $question->correct_answer }}</td>
                                            <td>{{ $question->difficulty }}</td>
                                            <td>{{ $question->points }}</td>
                                            <td>{{ $question->subject->name }}</td>
                                            @if (Auth::check() && auth()->user()->department_id == 4)
                                                <td>{{ $question->subject->semester }}</td>
                                            @endif
                                            <td>{{ $question->created_at }}</td>
                                            @if (Auth::check() && in_array(auth()->user()->role, ['staff', 'commissioner']))
                                                <td>
                                                    <a href="{{ route('questions.edit', $question) }}" role="button"><i
                                                            class="bi bi-pencil-square"
                                                            style="display: inline-flex;padding: 5px"></i></a>
                                                    <a href="{{ route('questions.show', $question) }}" role="button"><i
                                                            class="bi bi-eye-fill"
                                                            style="display: inline-flex; color:green;padding: 5px"></i></a>
                                                    <form action="{{ route('questions.destroy', $question) }}"
                                                        method="POST" style="display: inline-flex" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-link text-danger delete-btn"
                                                            style="border:none; background:none; padding: 0; font-size: large; margin-left: 5px;">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{ route('questions.show', $question) }}" role="button"><i
                                                            class="bi bi-eye-fill"
                                                            style="display: inline-flex; color:green;padding: 5px"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary custom-btn btn-lg">Create
                                    New
                                    Question</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <style>
        i.bi.bi-trash3::before {
            margin-right: 5px !important;
            margin-bottom: 5px !important;
        }
    </style>
@endsection
