<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/logo16.png') }}" type="image/png" sizes="16x16">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <main>
            <div>
                @yield('content')
            </div>
        </main>
    </div>
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

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* form Section */
        .form-section {
            background-color: var(--background);
            padding: 100px 0;
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
            color: white !important;
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
