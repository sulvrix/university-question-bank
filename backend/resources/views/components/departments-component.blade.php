<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Departments') }}</div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered" style="font-size: 1.25em" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Faculty</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentData as $department)
                                    <tr>
                                        <td>{{ $department->id }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ $department->faculty->name }}</td>
                                        <td>
                                            <a href="{{ route('departments.edit', ['department' => $department->id]) }}"
                                                role="button"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('departments.destroy', $department) }}"
                                                method="POST" style="display:inline;">
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
                            <a class="btn btn-primary" href="{{ route('departments.create') }}" role="button">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
