<main class="py-4">
    <div class="container form-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-header bg-gradient-primary text-white text-center py-4">
                        <h3 class="card-title mb-0">{{ __('Users') }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-hover table-bordered" style="font-size: 1.25em" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userData as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $user->department->name }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" role="button"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="border:none; background:none; color:red;"><i
                                                        class="bi bi-trash3"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-primary custom-btn btn-lg" href="{{ route('users.create') }}"
                                role="button">Add User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
