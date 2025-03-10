@extends('layouts.dashboard')
@section('content')
    <style>
        /* Loading overlay styles */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Ensure it's above other content */
            display: none;
            /* Hidden by default */
        }
    </style>
    <div class="container mt-5">
        <h1 class="text-center">Generate Questions from PDF</h1>

        <!-- File Upload Input -->
        <div class="text-center">
            <input type="file" id="pdf-upload" accept=".pdf" style="display: none;">
            <button id="generateButton" class="btn btn-primary btn-lg">Upload PDF</button>
        </div>

        <!-- Generated Questions List -->
        <div class="question-list mt-4" id="question-list">
            <!-- Questions will be dynamically added here -->
        </div>

        <!-- "Load More" button will be inserted here by JavaScript -->
    </div>
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Link the external JavaScript file -->
    <script src="{{ asset('js/generate.js') }}"></script>
@endsection
