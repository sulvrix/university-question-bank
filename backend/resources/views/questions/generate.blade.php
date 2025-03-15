@extends('layouts.dashboard')

@section('content')
    <div class="position-fixed top-0 start-50 translate-middle-x z-3 p-2" id="alertPlaceholder"
        style="z-index: 1500 !important;"></div>
    <div class="container mt-4">
        <h1 class="text-center">Generate Questions</h1>
        <hr class="mb-5 mt-0 border border-primary-subtle border-3 opacity-50">

        <!-- File Upload Input -->
        <div class="d-flex align-items-center justify-content-center mt-3 gap-3">
            <div id="backButton1">
                <a href="{{ route('questions.create') }}" class="btn btn-secondary btn-lg"> <i class="bi bi-arrow-left"></i>
                    Back</a>
            </div>
            <div class="text-center">
                <input type="file" id="pdf-upload" accept=".pdf" style="display: none;">
                <button id="generateButton" class="btn btn-primary btn-lg">
                    <i class="bi bi-upload"></i> Upload PDF
                </button>
            </div>
        </div>

        <!-- Generated Questions List -->
        <div class="question-list mt-4" id="question-list">
            <!-- Questions will be dynamically added here -->
        </div>

        <!-- Load More and Cancel Buttons -->
        <div class="d-flex align-items-center justify-content-center mt-3 gap-3">
            <div id="backButton2" style="display: none;">
                <a href="{{ route('questions.create') }}" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i>
                    Back</a>
            </div>
            <div id="loadmore-div">
                <!-- "Load More" button will be inserted here by JavaScript -->
            </div>
            <div id="resetButton" style="display: none;">
                <button class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i> Reset</button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Styles -->
    <style>
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

        .question-list .question-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #f8f9fa;
        }

        .question-list .question-item .question-details {
            flex-grow: 1;
            margin-right: 1rem;
        }

        .question-list .question-item .question-details strong {
            color: #05060f99;
        }

        .question-list .question-item .btn {
            white-space: nowrap;
        }

        .btn-primary {
            background-color: #607de3;
            border-color: #607de3;
        }

        .btn-primary:hover {
            background-color: #4a6ed9;
            border-color: #4a6ed9;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.25rem;
        }
    </style>
    <!-- Link the external JavaScript file -->
    <script src="{{ asset('js/generate.js') }}"></script>
@endsection
