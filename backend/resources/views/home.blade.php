@php
    use App\Models\User;
    use App\Models\Question;
    use App\Models\Exam;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
</head>

<body>
    @if (session('success'))
        <div class="position-fixed start-50 translate-middle-x z-3 p-2" style="z-index: 1500 !important; top: 15%;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    <!-- Header -->
    <header class="container-fluid py-3">
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
                            <li class="nav-item">
                                <a class="nav-link" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#features">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#testimonials">Testimonials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Right Part: Get Started Button -->
                    @if (Route::has('login'))
                        @auth
                            <div class="d-none d-lg-flex align-items-center">
                                <a class="btn custom-btn px-4 py-2 rounded-3 fw-medium"
                                    href="{{ url('/dashboard') }}">Dashboard</a>
                            </div>
                        @else
                            <div class="d-none d-lg-flex align-items-center">
                                <a class="btn custom-btn px-4 py-2 rounded-3 fw-medium" href="{{ url('login') }}">Login</a>
                            </div>
                        @endauth
                    @endif
                    <!-- Hamburger Button for Mobile -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">

            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="animate__animated animate__fadeInLeft">Empowering University Staff with Smart Exam
                        Solutions</h1>
                    <p class="animate__animated animate__fadeInLeft animate__delay-1s">Streamline exam creation,
                        store
                        questions securely, and leverage AI tools to enhance efficiency for commissioners and
                        teachers.
                    </p>
                    @if (Route::has('login'))
                        @auth
                            <a class="btn custom-btn btn-lg " href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn custom-btn btn-lg " href="{{ url('login') }}">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-database feature-icon"></i>
                        <h3>Secure Question Bank</h3>
                        <p>Store and manage exam questions securely with advanced access controls.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-cogs feature-icon"></i>
                        <h3>AI-Powered Tools</h3>
                        <p>Use AI to generate, analyze, and optimize exam questions effortlessly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-clock feature-icon"></i>
                        <h3>Time-Saving</h3>
                        <p>Create exams faster with pre-built templates and automated workflows.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section" id="stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>{{ Question::count() . '+' }}</h2>
                        <p>Questions Stored</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>{{ Exam::count() . '+' }}</h2>
                        <p>Exams Created</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>{{ User::count() . '+' }}</h2>
                        <p>Happy Staff Members</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <h2 class="text-center mb-5">What Our Users Say</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"This platform has revolutionized how we create and manage exams. Highly
                            recommended!"</p>
                        <div class="user-info">
                            <img src="user1.jpg" alt="User 1">
                            <div>
                                <h4>Dr. John Doe</h4>
                                <p>Head of Computer Science</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"The AI tools are a game-changer. They save us so much time and effort."</p>
                        <div class="user-info">
                            <img src="user2.jpg" alt="User 2">
                            <div>
                                <h4>Prof. Jane Smith</h4>
                                <p>Dean of Engineering</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"The question bank is incredibly secure and easy to use. It's a must-have for any
                            university."</p>
                        <div class="user-info">
                            <img src="user3.jpg" alt="User 3">
                            <div>
                                <h4>Dr. Alice Johnson</h4>
                                <p>Director of Academics</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="cta-banner">
        <div class="container">
            <h2 class="animate__animated animate__fadeInUp">Ready to Transform Exam Management?</h2>
            @if (Route::has('login'))
                @auth
                    <a class="btn custom-btn btn-lg" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="btn custom-btn btn-lg" href="{{ url('login') }}">Login</a>
                @endauth
            @endif
        </div>
    </section>
    <<!-- Contact -->
        <x-contact-component />
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>University Question Bank</h3>
                        <p>© 2023 University Question Bank. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

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

            html {
                scroll-behavior: smooth;
            }

            body {
                background-image: url('{{ asset('images/hero.jpg') }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                position: relative;
                font-family: 'Poppins', sans-serif;
                color: white;
            }

            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, rgba(96, 125, 227, 0.8) 0%, rgba(138, 164, 245, 0.8) 100%);
                /* Accent overlay */
                z-index: -1;
                /* Place behind all content */
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

            /* Custom Button Styles */
            .custom-btn {
                background: var(--accent-gradient);
                color: white;
                border: none;
                border-radius: 10px;
                padding: 0.75rem 2rem;
                font-size: 1rem;
                font-weight: 500;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .custom-btn:hover {
                background: var(--primary-dark) !important;
                transform: translateY(-3px);
                box-shadow: 0 5px 20px rgba(96, 125, 227, 0.5);
            }

            .custom-btn:hover,
            .custom-btn:active {
                color: white !important;

            }


            /* Hamburger Menu for Mobile */
            .navbar-toggler {
                border: none;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }

            /* Hero Section */
            .hero-section {
                padding: 200px 0;
                /* Adjust padding as needed */
                position: relative;
                overflow: hidden;
                color: white;
                /* Ensure text is visible */
            }


            .hero-section h1 {
                font-size: 3.5rem;
                font-weight: 700;
                line-height: 1.2;
                position: relative;
                z-index: 2;
            }

            .hero-section p {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                position: relative;
                z-index: 2;
            }

            .hero-section .btn {
                font-size: 1.25rem;
                padding: 0.75rem 2rem;
                position: relative;
                z-index: 2;
            }

            .hero-section .custom-btn {
                font-size: 1.25rem;
                padding: 0.75rem 2rem;
            }

            /* Features Section */
            .features-section {
                color: var(--text);
                background-color: white;
                padding: 100px 0;
            }

            .feature-card {
                background: white;
                border-radius: 15px;
                padding: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 8px 20px rgba(96, 125, 227, 0.3);
            }

            .feature-icon {
                font-size: 2.5rem;
                background: var(--accent-gradient);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                margin-bottom: 1rem;
            }

            /* Statistics Section */
            .stats-section {
                padding: 100px 0;
            }

            .stat-card {
                text-align: center;
                padding: 2rem;
                color: white;
            }

            .stat-card h2 {
                font-size: 3rem;
                font-weight: 700;
            }

            .stat-card p {
                font-size: 1.25rem;
            }

            /* Testimonials Section */
            .testimonials-section {
                padding: 100px 0;
                background: white;
                color: var(--text)
            }

            .testimonial-card {
                background: white;
                border-radius: 15px;
                padding: 2rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .testimonial-card p {
                font-size: 1rem;
                color: var(--secondary);
            }

            .testimonial-card .user-info img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                margin-right: 1rem;
            }

            /* CTA Banner */
            .cta-banner {
                padding: 100px 0;
                /* Adjust padding as needed */
                position: relative;
                overflow: hidden;
                color: white;
                text-align: center;
            }

            .cta-banner h2 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
                animation: fadeInUp 1s ease;
            }

            .cta-banner .btn {
                font-size: 1.25rem;
                padding: 0.75rem 2rem;
                position: relative;
                z-index: 2;
            }


            .cta-banner .custom-btn {
                padding: 0.75rem 2rem;
                font-size: 1rem;
                font-weight: 500;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Contact Section */
            .contact-section {
                padding: 100px 0;
                background-color: var(--background);
            }

            .contact-section .card {
                border: none;
                border-radius: 15px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }


            .contact-section .card-header {
                background: var(--accent-gradient);
                padding: 2rem;
            }

            .contact-section .card-title {
                font-size: 2rem;
                font-weight: 700;
            }

            .contact-section .card-body {
                padding: 2rem;
            }

            .contact-section .form-control {
                height: 44px;
                background-color: #05060f0a;
                border-radius: .5rem;
                padding: 0 1rem;
                border: 2px solid transparent;
                font-size: 1rem !important;
                transition: border-color .3s cubic-bezier(.25, .01, .25, 1) 0s, color .3s cubic-bezier(.25, .01, .25, 1) 0s, background .2s cubic-bezier(.25, .01, .25, 1) 0s;
            }

            textarea {
                padding-top: 0.5rem !important;
                height: auto !important;
            }

            .contact-section .form-control:hover,
            .contact-section .form-control:focus {
                outline: none;
                border-color: #05060f;
            }

            .contact-section .form-label {
                display: block;
                margin-bottom: .3rem;
                font-size: .9rem;
                font-weight: bold;
                color: #05060f99;
                transition: color .3s cubic-bezier(.25, .01, .25, 1) 0s;
            }

            .contact-section .custom-btn {
                padding: 0.75rem 2rem;
                font-size: 1rem;
                font-weight: 500;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }


            /* Footer */
            footer {
                background: var(--primary-dark);
                color: white;
                padding: 2rem 0;
            }

            footer a {
                color: white;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            footer a:hover {
                color: var(--primary-light);
            }

            .social-icons a {
                font-size: 1.5rem;
                margin-right: 1rem;
            }
        </style>
        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
</body>

</html>
