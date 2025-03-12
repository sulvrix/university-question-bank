@extends('layouts.dashboard')

@section('content')
    <main class="py-4">
        <div class="container form-section">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-header bg-gradient-primary text-white text-center py-4">
                            <h3 class="card-title mb-0">{{ __('Exams') }}</h3>
                        </div>
                        <div class="card-body p-4">
                            <table class="table table-hover table-bordered" style="font-size: 1.25em" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Block</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->block }}</td>
                                            <td>{{ $exam->level }}</td>
                                            <td>{{ $exam->department->name }}</td>
                                            <td>{{ $exam->created_at }}</td>
                                            <td>
                                                <a href="{{ route('exams.edit', $exam) }}" role="button"><i
                                                        class="bi bi-pencil-square"
                                                        style="display: inline-flex;padding: 5px"></i></a>
                                                <a href="{{ route('exams.show', $exam) }}" target="_blank" role="button"><i
                                                        class="bi bi-eye-fill"
                                                        style="display: inline-flex; color:green;padding: 5px"></i></a>
                                                <form action="{{ route('exams.destroy', $exam) }}" method="POST"
                                                    style="display: inline-flex">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        style="border:none; background:none;color:red; padding: 5px;"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('exams.create') }}" class="btn btn-primary cutsom-btn btn-lg">Create New
                                    Exam</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
