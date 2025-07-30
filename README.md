# University Question Bank
A structured question bank system for university-level multiple-choice questions (MCQs). This repository provides a foundation for managing, organizing, and retrieving questions efficiently, making it useful for online learning platforms, exam preparation tools, or educational content management systems.

## User Interface
<img alt="Home / Landing Page" src="https://github.com/sulvrix/university-question-bank/blob/main/frontend/New/Home1.jpeg">

## Libraries & Technologies
Laravel – PHP framework for the backend.

Alpine.js – Lightweight frontend framework for handling UI interactions.

Tailwind CSS – Utility-first CSS framework.

Tesseract.js – OCR library for extracting text from images.

Roboto Font – Used for typography.

## Project Structure
```bash
├── app/                 # Laravel application logic
├── bootstrap/           # Framework bootstrap files
├── config/              # Configuration settings
├── database/            # Migrations and seeds
├── public/              # Frontend assets (CSS, JS, images)
│   ├── images/          # Stored question images
├── resources/           # Views and frontend assets
│   ├── css/             # Tailwind styles
│   ├── js/              # Alpine.js scripts
├── routes/              # API and web routes
├── storage/             # Local storage (logs, uploads, caches)
├── tests/               # Automated tests
├── .env.example         # Example environment file
├── artisan              # Laravel CLI
├── composer.json        # PHP dependencies
├── package.json         # JavaScript dependencies
├── README.md            # Project documentation
```

- public/images/ – Stores images for questions.

- resources/js/ – Contains Alpine.js scripts for interactive components.

- routes/ – Defines API endpoints for fetching questions and related data.
