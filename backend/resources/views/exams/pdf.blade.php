<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 15px;
        }

        .question-text {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $exam->name }}</h1>
        <p>Level: {{ $exam->level }} | Block: {{ $exam->block }} | Department: {{ $exam->department->name }}</p>
    </div>

    @foreach ($questions as $question)
        <div class="question">
            <div class="question-text">{{ $loop->iteration }}. {{ $question->text }}</div>
            <div>Difficulty: {{ $question->difficulty }} | Points: {{ $question->points }}</div>
        </div>
    @endforeach
</body>

</html>
