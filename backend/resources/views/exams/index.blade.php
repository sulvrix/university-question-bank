@extends('layouts.dashboard')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ __('Exams') }}</div>
                        <div class="card-body">
                            <table class="table table-hover" style="font-size: 1.25em" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Block</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($exams as $exam)
                                        <tr>
                                            <td>{{ $exam->id }}</td>
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->block }}</td>
                                            <td>{{ $exam->department->name }}</td>
                                            <td>{{ $exam->created_at }}</td>
                                            <td>
                                                <a href="{{ route('exams.edit', $exam) }}" role="button"><i
                                                        class="bi bi-pencil-square"></i></a>
                                                <form action="{{ route('exams.destroy', $exam) }}" method="POST"
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
                                <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">Create New
                                    Exam</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
