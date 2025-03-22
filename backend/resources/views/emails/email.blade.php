<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: #607de3;
            padding: 1.5rem;
            text-align: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
            color: #fff;
        }

        .card-body {
            padding: 2rem;
            background-color: #fff;
        }

        .card-body p {
            font-size: 1rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .card-body strong {
            color: #607de3;
            font-weight: 600;
        }

        .card-body .message {
            background-color: #f8f9fa;
            border-left: 4px solid #607de3;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1.5rem;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .footer a {
            color: #607de3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <h2>New Contact Form Submission</h2>
            </div>

            <!-- Body -->
            <div class="card-body">
                <p><strong>Name:</strong> {{ $data['name'] }}</p>
                <p><strong>Email:</strong> {{ $data['email'] }}</p>

                <!-- Message Section -->
                <div class="message">
                    <p><strong>Message:</strong></p>
                    <p>{{ $data['message'] }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer mt-4">
            <p>This email was sent from your website's contact form. If you have any questions, please <a
                    href="mailto:noreply.uqb@gmail.com">contact support</a>.</p>
        </div>
    </div>
</body>

</html>
