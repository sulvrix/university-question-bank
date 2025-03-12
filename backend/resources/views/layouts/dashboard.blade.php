<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}- Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" />


    <!-- Scripts -->
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
                            <div class="logo-icon me-3"></div>
                            <a class="fs-4 fw-medium ink-offset-2 link-underline link-underline-opacity-0 link-dark"
                                href="{{ url('/') }}">University
                                Question Bank</a>
                        </div>
                        <!-- Middle Part: Nav Links -->
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                            <ul class="navbar-nav">
                                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'staff'))
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('dashboard.administration') }}">{{ __('Administration') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('dashboard.questions') }}">{{ __('Questions') }}</a>
                                </li>
                                @if (Auth::check() &&
                                        (Auth::user()->role == 'admin' || Auth::user()->role == 'staff' || Auth::user()->role == 'commissioner'))
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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
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

        .logo-icon {
            width: 28px;
            height: 28px;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(96, 125, 227, 0.5) 31%, #607de3 100%);
            border-radius: 50%;
            position: relative;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            width: 80%;
            height: 80%;
            background: linear-gradient(270deg, #607de3 0%, rgba(96, 125, 227, 0.56) 59%, rgba(0, 0, 0, 0) 100%);
            transform: rotate(-50deg);
        }

        /* form Section */
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

        .form-control {
            height: 44px;
            background-color: #05060f0a;
            border-radius: .5rem;
            padding: 0 1rem;
            border: 2px solid transparent;
            font-size: 1rem;
            transition: border-color .3s cubic-bezier(.25, .01, .25, 1) 0s, color .3s cubic-bezier(.25, .01, .25, 1) 0s, background .2s cubic-bezier(.25, .01, .25, 1) 0s;
        }

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

        .form-label {
            display: block;
            margin-bottom: .3rem;
            font-size: .9rem;
            font-weight: bold;
            color: #05060f99;
            transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
        }

        .form-control:hover,
        .form-control:focus,
        .form-control-group:hover .form-control {
            outline: none;
            border-color: #05060f;
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

    <script>
        $(document).ready(function() {
            var tables = $('table').not('#questionsTable').DataTable({
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
                        targets: 1,
                        data: 'name',
                        render: function(data, type, row, meta) {
                            return type === 'display' && data.length > 40 ?
                                '<span title="' + data + '">' + data.substr(0, 38) +
                                '...</span>' :
                                data;
                        }
                    },
                    {
                        className: 'dt-left',
                        targets: '_all'
                    },
                ],
            });
        });
    </script>
</body>

</html>
