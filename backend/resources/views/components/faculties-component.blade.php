<!doctype html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" />
</head>

<body>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">{{ __('Faculties') }}</div>
                        <div class="card-body">
                            <table class="table table-hover" id="tableFaculties">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">University</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facultyData as $faculty)
                                        <tr>
                                            <th scope="row">{{ $faculty->id }}</th>
                                            <td>{{ $faculty->name }}</td>
                                            <td>{{ $faculty->University->name }}</td>
                                            <td>
                                                <a href="{{ route('faculties.edit', ['faculty' => $faculty->id]) }}"
                                                    role="button"><i class="bi bi-pencil-square"></i></a>
                                                <a href="{{ route('faculties.destroy', ['faculty' => $faculty->id]) }}"
                                                    role="button"><i class="bi bi-trash3"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary" href="{{ route('departments.create') }}"
                                    role="button">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#tableFaculties', {
                layout: {
                    topStart: {
                        pageLength: {
                            menu: [10, 25, 50, 100],
                        }
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Type Something..'
                        }
                    },
                    bottomEnd: {
                        paging: {
                            buttons: 3
                        }
                    },
                },
                columnDefs: [
                    // targets may be classes
                    {
                        targets: 3,
                        orderable: false,
                        searchable: false,
                    },
                    {
                        targets: 1,
                        data: 'name',
                        render: function(data, type, row, meta) {
                            return type === 'display' && data.length > 40 ?
                                '<span title="' + data + '">' + data.substr(0, 38) +
                                '...</span>' :
                                data;
                        }
                    }
                ],
            });
        });
    </script>

</body>

</html>
