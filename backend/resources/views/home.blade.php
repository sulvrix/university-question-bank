<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}- Home</title>

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
    <!-- Header -->
    <header class="container-fluid py-3">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <!-- Left Part: Logo -->
                    <div class="d-flex align-items-center">
                        <div class="logo-icon me-3"></div>
                        <span class="fs-4 fw-medium">University Questions Bank</span>
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
                <div class="col-lg-6">
                    <h1 class="animate__animated animate__fadeInLeft">The Future of University Exams</h1>
                    <p class="animate__animated animate__fadeInLeft animate__delay-1s">Access a vast library of past
                        exam papers, study materials, and solutions tailored to your course.</p>
                    @if (Route::has('login'))
                        @auth
                            <a class="btn custom-btn btn-lg animate__animated animate__fadeInLeft animate__delay-1s"
                                href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn custom-btn btn-lg animate__animated animate__fadeInLeft animate__delay-1s"
                                href="{{ url('login') }}">Login</a>
                        @endauth
                    @endif
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/hero.png') }}" alt="Hero Image" width="550" height="550"
                        class="img-fluid animate__animated animate__fadeInRight">
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
                        <i class="fas fa-book-open feature-icon"></i>
                        <h3>Comprehensive Library</h3>
                        <p>Access a vast collection of past exam papers and study materials tailored to your course.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-search feature-icon"></i>
                        <h3>Quick Search</h3>
                        <p>Find what you need instantly with our powerful search and filter options.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h3>Mobile-Friendly</h3>
                        <p>Study anytime, anywhere with our mobile-friendly platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>10,000+</h2>
                        <p>Questions Available</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>500+</h2>
                        <p>Universities Supported</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <h2>1M+</h2>
                        <p>Happy Students</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <h2 class="text-center mb-5">What Our Users Say</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"This platform has been a game-changer for my exam preparation. Highly recommended!"</p>
                        <div class="user-info">
                            <img src="user1.jpg" alt="User 1">
                            <div>
                                <h4>John Doe</h4>
                                <p>Computer Science Student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"The resources are well-organized and easy to access. It's made studying so much easier."</p>
                        <div class="user-info">
                            <img src="user2.jpg" alt="User 2">
                            <div>
                                <h4>Jane Smith</h4>
                                <p>Engineering Student</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"I love the mobile-friendly design. I can study on the go without any hassle."</p>
                        <div class="user-info">
                            <img src="user3.jpg" alt="User 3">
                            <div>
                                <h4>Alice Johnson</h4>
                                <p>Business Student</p>
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
            <h2 class="animate__animated animate__fadeInUp">Ready to Ace Your Exams?</h2>
            @if (Route::has('login'))
                @auth
                    <a class="btn custom-btn btn-lg animate__animated animate__fadeInUp animate__delay-1s"
                        href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="btn custom-btn btn-lg animate__animated animate__fadeInUp animate__delay-1s"
                        href="{{ url('login') }}">Login</a>
                @endauth
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>University Questions Bank</h3>
                    <p>© 2023 University Questions Bank. All rights reserved.</p>
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
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background-color: var(--background);
        }

        /* Sticky Navbar */
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
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
        .custom-btn,
        .custom-btn:active,
        .custom-btn:focus,
        .custom-btn:hover {
            color: white !important;
            /* Ensures text stays white */
            background: var(--accent-gradient) !important;
            /* Ensures gradient background */
            border: none !important;
            /* Removes any border */
            outline: none !important;
            /* Removes focus outline */
            box-shadow: none !important;
            /* Removes any box shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-btn:hover {
            background: var(--primary-dark) !important;
            box-shadow: 0 5px 15px rgba(96, 125, 227, 0.3);
            transform: translateY(-3px);
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
            background: var(--accent-gradient);
            color: white;
            padding: 150px 0;
            overflow: hidden;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .hero-section .btn {
            font-size: 1.25rem;
            padding: 0.75rem 2rem;
        }

        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Features Section */
        .features-section {
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
            background: var(--background);
            padding: 100px 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-card h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-card p {
            font-size: 1.25rem;
            color: var(--secondary);
        }

        /* Testimonials Section */
        .testimonials-section {
            padding: 100px 0;
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
            background: var(--accent-gradient);
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(96, 125, 227, 0.8) 0%, rgba(138, 164, 245, 0.8) 100%);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .cta-banner:hover::before {
            opacity: 1;
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

        .cta-banner .btn:hover {
            background: var(--primary-dark);
            box-shadow: 0 5px 20px rgba(96, 125, 227, 0.5);
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
                e.preventDefault(); // Prevent default anchor behavior
                const targetId = this.getAttribute('href'); // Get the target section ID
                const targetElement = document.querySelector(targetId); // Find the target element
                if (targetElement) {
                    // Scroll to the target element with smooth behavior
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start' // Aligns the top of the section with the top of the viewport
                    });
                }
            });
        });
    </script>
</body>

</html>
