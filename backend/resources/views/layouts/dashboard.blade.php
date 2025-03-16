<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}- Dashboard</title>
    <link rel="icon" href="{{ asset('images/logo16.png') }}" type="image/png" sizes="16x16">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <!-- Header -->
    <header class="container-fluid py-3">
        <div id="app">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <!-- Left Part: Logo -->
                        <div class="d-flex align-items-center">
                            <div>
                                <img class="me-3" src="{{ asset('images/logo40.png') }}" alt="">
                            </div>
                            <a class="fs-4 fw-medium ink-offset-2 link-underline link-underline-opacity-0 link-dark"
                                href="{{ url('/') }}">University
                                Question Bank</a>
                        </div>
                        <!-- Middle Part: Nav Links -->
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                            <ul class="navbar-nav">
                                @if (in_array(auth()->user()->role, ['admin', 'staff']))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.administration') }}">{{ __('Administration') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.questions') }}">{{ __('Questions') }}</a>
                                </li>
                                @if (Auth::check() && in_array(auth()->user()->role, ['admin', 'staff', 'commissioner']))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.exams') }}">{{ __('Exams') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- Right Part -->
                        <ul class="navbar-nav">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-circle me-2"></i>{{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                        <!-- Hamburger Button for Mobile -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </nav>
            </div>
    </header>

    {{-- Dashboard Content --}}
    <main class="py-4">
        @yield('content')
    </main>
    <style>
        :root {
            --primary: #607de3;
            --primary-light: #8aa4f5;
            --primary-dark: #4a6cd4;
            --secondary: #4a4a4a;
            --background: #f8f9fa;
            --text: #333333;
            --accent-gradient: linear-gradient(135deg, #607de3 0%, #8aa4f5 100%);
        }

        /* Sticky Navbar */
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            color: var(--text)
        }


        body {
            font-family: 'Poppins', sans-serif;
        }

        textarea {
            padding-top: 0.5rem !important;
            min-height: 44px !important;
            max-height: 260px !important;
        }

        .delete-btn {
            z-index: 2000 !important;
            pointer-events: auto;
        }

        /* form Section */
        /* Custom Form Controls */

        .form-control {
            height: 44px;
            background-color: #05060f0a;
            border-radius: .5rem;
            padding: 0 1rem;
            border: 2px solid transparent;
            font-size: 1rem !important;
            transition: border-color .3s cubic-bezier(.25, .01, .25, 1) 0s, color .3s cubic-bezier(.25, .01, .25, 1) 0s, background .2s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        .form-control:hover,
        .form-control:focus {
            outline: none;
            border-color: #05060f;
        }

        .form-label {
            display: block;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: bold;
            color: #05060f99;
            transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        /* Custom Select Dropdown */
        select {
            padding: 5px;
            font-size: 16px;
            line-height: 1;
            border: 0;
            border-radius: 5px;
            height: 34px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"> <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" /> </svg>') no-repeat right #ddd;
            -webkit-appearance: none;
            background-position-x: 98%;
        }

        /* Custom Buttons */
        .btn-primary {
            background-color: #607de3;
            border-color: #607de3;
        }

        .btn-primary:hover {
            background-color: #4a6ed9;
            border-color: #4a6ed9;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        /* Card Layout */
        .card {
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            padding: 1rem;
            font-weight: bold;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Error Messages */
        .text-danger {
            font-size: 0.875rem;
            color: #dc3545;
        }

        /* Loading Overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .form-section {
            background-color: var(--background);
            padding: 25px 0;
        }

        .form-section .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }


        .form-section .card-header {
            background: var(--accent-gradient);
            padding: 2rem;
        }

        .form-section .card-title {
            font-size: 2rem;
            font-weight: 700;
        }

        .form-section .card-body {
            padding: 2rem;
        }

        .form-section .form-control {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-section .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(96, 125, 227, 0.3);
        }

        .form-section .btn-gradient-primary {
            background: var(--accent-gradient);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-section .btn-gradient-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(96, 125, 227, 0.5);
        }

        .form-section .btn-link {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .form-section .btn-link:hover {
            color: var(--primary-dark);
        }

        .navbar-nav .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            margin: 0 0.75rem;
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary);
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Dropdown Menu */
        .navbar-nav .dropdown-menu {
            background: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            padding: 0.5rem 0;
        }

        .navbar-nav .dropdown-item {
            color: var(--text);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar-nav .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--text);
        }

        .navbar-nav .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }

        /* Dropdown Toggle */
        .navbar-nav .dropdown-toggle::after {
            display: none;
            /* Hide default dropdown arrow */
        }

        .navbar-nav .dropdown-toggle:hover {
            color: var(--primary);
        }


        .input-group:hover .label,
        .form-control:focus {
            color: #05060fc2;
        }

        .page-link.active,
        .active>.page-link {
            background-color: #607de3;
        }

        div.dt-length select {
            font-size: 16px;
            line-height: 1;
            border: 0;
            border-radius: 5px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"> <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" /> </svg>') no-repeat right #05060f0a;
            -webkit-appearance: none;
            background-position-x: 90%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var tables = $('table').not('#questionsTable').DataTable({
                autoWidth: false,
                layout: {
                    topStart: {
                        pageLength: {
                            menu: [10, 25, 50, {
                                label: 'All',
                                value: -1
                            }],
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
                        targets: '_all', // Target all columns
                        render: function(data, type, row, meta) {
                            // Exclude the last column
                            if (meta.col === meta.settings.aoColumns.length - 1) {
                                return data; // Return the original data for the last column
                            }

                            // Truncate the text if it exceeds 20 characters
                            if (type === 'display' && data.length > 20) {
                                return '<span class="truncate-text" title="' + data + '">' + data
                                    .substr(0, 18) + '...</span>';
                            }
                            return '<span class="truncate-text">' + data + '</span>';
                        }
                    },
                    {
                        targets: -1,
                        orderable: false,
                        searchable: false,
                        width: '120px',
                        className: 'dt-center',
                    },
                    {
                        targets: 0,
                        width: '50px',
                        className: 'dt-center',
                    },
                    {
                        className: 'dt-left',
                        targets: '_all'
                    },
                ],
            });
            attachDeleteButtonListeners();
        });
    </script>
    <script>
        function attachDeleteButtonListeners() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            console.log('Number of delete buttons:', deleteButtons.length); // Add this line

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    console.log('Delete button clicked'); // Add this line
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#607de3',
                        cancelButtonColor: '#de5464',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('Form submitted'); // Add this line
                            form.submit();
                        }
                    });
                });
            });
        }
    </script>
    <style>
        /* CSS to enforce text truncation */
        .truncate-text {
            white-space: nowrap;
            /* Prevent text from wrapping to the next line */
            overflow: hidden;
            /* Hide overflowed text */
            text-overflow: ellipsis;
            /* Add ellipsis (...) for truncated text */
            display: inline-block;
            /* Ensure the span behaves like a block element */
            max-width: 100%;
            /* Ensure the text doesn't exceed the cell width */
        }

        /* Ensure columns shrink to fit their content */
        table.dataTable td {
            white-space: nowrap;
            /* Prevent text from wrapping */
            max-width: 200px;
            /* Set a maximum width to prevent columns from becoming too wide */
            overflow: hidden;
            /* Hide overflow */
            text-overflow: ellipsis;
            /* Add ellipsis for truncated text */
        }

        /* Optional: Set a minimum width for columns if needed */
        table.dataTable th,
        table.dataTable td {
            min-width: 50px;
            /* Adjust as needed */
        }
    </style>
</body>

</html>
