<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->name }}</title>
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
            margin-top: 20px;
        }

        .question {
            page-break-inside: avoid;
        }

        .question-text {
            font-weight: bold;
            margin-top: 20px;
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
                <img src="{{ $HadhramutUniversityLogo }}" alt="University Logo" class="university-logo">
            </td>

            <!-- Middle Column: University and Faculty Names -->
            <td style="width: 60%; text-align: center;">
                <h3>{{ $exam->department->faculty->university->name }}</h3>
                <h4>{{ $exam->department->faculty->name }}</h4>
            </td>

            <!-- Right Column: Faculty Logo -->
            <td style="width: 20%; text-align: right;">
                @if ($exam->department->faculty->name === 'Faculty of Engineering')
                    <img src="{{ $engFacLogo }}" alt="Faculty Logo" class="faculty-logo">
                @elseif($exam->department->faculty->name === 'Faculty of Medicine')
                    <img src="{{ $medFacLogo }}" alt="Faculty Logo" class="faculty-logo">
                @else
                    <img src="{{ $engFacLogo }}" alt="Faculty Logo" class="faculty-logo">
                @endif
            </td>
        </tr>
    </table>

    <!-- Bottom Section -->
    <table class="header">
        <tr>
            <!-- Left Column: Department, Academic Year, Exam Semester, Examiner -->
            <td style="width: 50%;">
                <div><strong>Department:</strong> {{ $exam->department->name }}</div>
                <div><strong>Academic Year:</strong>
                    @if (date('m', strtotime($exam->date)) < 6)
                        {{ date('Y', strtotime($exam->date)) - 1 . ' - ' . date('Y', strtotime($exam->date)) }}
                    @else
                        {{ date('Y', strtotime($exam->date)) . ' - ' . (date('Y', strtotime($exam->date)) + 1) }}
                    @endif
                </div>
                @if ($exam->department_id === 2)
                    <div><strong>Block:</strong> {{ $exam->block }}</div>
                @else
                    <div><strong>Exam Semester: </strong>{{ $subjectSemester }}</div>
                    <div><strong>Examiner: </strong>{{ $exam->examiner }}</div>
                @endif
            </td>

            <!-- Right Column: Date, Subject, Level, Time Allowed -->
            <td style="width: 50%; text-align: right;">
                <div><strong>Date:</strong> {{ date('m/d/Y', strtotime($exam->date)) }}</div>
                <div><strong>Level:</strong> {{ $exam->level }}</div>
                <div><strong>Time Allowed:</strong> {{ floor($exam->duration / 60) }} Hours
                    @if ($exam->duration % 60 > 0)
                        {{ $exam->duration % 60 }} Minutes
                    @endif
                </div>
                @if ($exam->department_id !== 2)
                    <div><strong>Subject:</strong> {{ $subjectName }}</div>
                @endif
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
