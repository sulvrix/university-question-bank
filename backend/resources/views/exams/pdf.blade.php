<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->name }}</title>
    <link rel="icon" href="{{ asset('images/logo16.png') }}" type="image/png" sizes="16x16">
    <style>
        body {
            font-family: Arial, sans-serif;
            border: 1px solid black;
            margin: 20px;
            padding: 20px;
            padding-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        img {
            margin: 0;
            padding: 0;
        }

        h3,
        h4 {
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .header td {
            vertical-align: top;
            padding: 5px;
        }

        .university-logo,
        .faculty-logo {
            margin: 0;
            padding: 0;
            width: 75px;
            height: auto;
        }

        .university-info {
            padding: 0;
            margin: 0;
            text-align: center;
        }


        .separator {
            border-top: 1px solid black;
            margin: 20px 0;
        }

        .question {
            margin-bottom: 20px;
        }

        .question-text {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .answer {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <table class="header">
        <tr>
            <!-- Left Column: University Logo -->
            <td style="width: 20%;">
                <img src="{{ $universityLogo }}" alt="University Logo" class="university-logo">
            </td>

            <!-- Middle Column: University and Faculty Names -->
            <td style="width: 60%; text-align: center;">
                <h3>{{ $exam->department->faculty->university->name }}</h3>
                <h4>{{ $exam->department->faculty->name }}</h4>
            </td>

            <!-- Right Column: Faculty Logo -->
            <td style="width: 20%; text-align: right;">
                <img src="{{ $facultyLogo }}" alt="Faculty Logo" class="faculty-logo">
            </td>
        </tr>
    </table>

    <!-- Bottom Section -->
    <table class="header">
        <tr>
            <!-- Left Column: Department, Academic Year, Exam Semester, Examiner -->
            <td style="width: 50%;">
                <div><strong>Department:</strong> {{ $exam->department->name }}</div>
                <div><strong>Academic Year:</strong></div>
                <div><strong>Exam Semester:</strong></div>
                <div><strong>Examiner:</strong></div>
            </td>

            <!-- Right Column: Date, Subject, Level, Time Allowed -->
            <td style="width: 50%; text-align: right;">
                <div><strong>Date:</strong></div>
                <div><strong>Subject:</strong> {{ $exam->name }}</div>
                <div><strong>Level:</strong> {{ $exam->level }}</div>
                <div><strong>Time Allowed:</strong></div>
            </td>
        </tr>
    </table>

    <!-- Separator Line -->
    <div class="separator"></div>

    <!-- Questions Section -->
    @foreach ($questions as $question)
        <div class="question">
            <div class="question-text">{{ $loop->iteration }}. {{ $question->text }}</div>
            @foreach ($question->answers as $index => $answer)
                <div class="answer">
                    {{ chr(65 + $index) }}. {{ $answer['text'] }}
                </div>
            @endforeach
        </div>
    @endforeach
</body>

</html>
