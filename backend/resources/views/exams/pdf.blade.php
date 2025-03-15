<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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
    <div class="header">
        <h1>{{ $exam->name }}</h1>
        <p>Level: {{ $exam->level }} | Block: {{ $exam->block }} | Department: {{ $exam->department->name }}</p>
    </div>

    @foreach ($questions as $question)
        <div class="question">
            <div class="question-text">{{ $loop->iteration }}. {{ $question->text }}</div>
            @foreach ($question->answers as $index => $answer)
                <div class="answer">
                    {{ chr(65 + $index) }}. {{ $answer['text'] }}
                </div>
            @endforeach
            {{-- <div style="margin-top: 10px;">
                <strong>Difficulty:</strong> {{ $question->difficulty }} | <strong>Points:</strong>
                {{ $question->points }}
            </div> --}}
        </div>
    @endforeach
</body>

</html>
