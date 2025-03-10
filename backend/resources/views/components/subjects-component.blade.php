<div class="container">
    <div class="container form-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-header bg-gradient-primary text-white text-center py-4">
                        <h3 class="card-title mb-0">{{ __('Subjects') }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-hover table-bordered" style="font-size: 1.25em" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjectData as $subject)
                                    <tr>
                                        <td>{{ $subject->id }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->level }}</td>
                                        <td>{{ $subject->department->name }}</td>
                                        <td>
                                            <a href="{{ route('subjects.edit', ['subject' => $subject->id]) }}"
                                                role="button"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST"
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
                            <a class="btn btn-primary custom-btn btn-lg" href="{{ route('subjects.create') }}"
                                role="button">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
