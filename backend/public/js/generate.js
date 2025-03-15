let page = 1; // Track the current page of questions
let isLoading = false; // Prevent multiple simultaneous requests
let loadMoreButton = null; // Reference to the "Load More" button
let extractedText = null; // Store the extracted text for pagination

// Function to show loading overlay
function showLoadingOverlay() {
    document.getElementById('loading-overlay').style.display = 'flex';
}

// Function to hide loading overlay
function hideLoadingOverlay() {
    document.getElementById('loading-overlay').style.display = 'none';
}

// Function to disable the "Load More" button
function disableLoadMoreButton(disabled, text = "Load More") {
    if (loadMoreButton) {
        loadMoreButton.disabled = disabled;
        loadMoreButton.textContent = disabled ? "Loading..." : text;
    }
}

// Function to show an alert
function showAlert(message, type = 'warning', duration = 5000) {
    const alertPlaceholder = document.getElementById('alertPlaceholder');
    if (!alertPlaceholder) {
        console.error('Alert placeholder not found!');
        return;
    }

    // Create the alert HTML
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // Append the alert to the placeholder
    alertPlaceholder.innerHTML = alertHTML;

    // Automatically remove the alert after the specified duration
    setTimeout(() => {
        alertPlaceholder.innerHTML = ''; // Clear the alert
    }, duration);
}

// Function to load more questions
function loadMoreQuestions() {
    if (isLoading || !extractedText) return;
    isLoading = true;

    disableLoadMoreButton(true);
    showLoadingOverlay();

    fetch(`/api/generate?text=${encodeURIComponent(extractedText)}&page=${page}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', // Ensure the response is JSON
        }
    })
        .then(response => {
            if (!response.ok) {
                showAlert('Failed to process the PDF. Please try again.');
                return response.json().then(errorData => {
                    throw new Error(errorData.error || 'Failed to load more questions');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.questions && Array.isArray(data.questions)) {
                const questionList = document.getElementById('question-list');

                data.questions.forEach((question) => {
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'question-item';
                    questionDiv.innerHTML = `
                        <div class="question-details">
                            <strong>Question:</strong> ${question.question}
                            <br>
                            <strong>Correct Answer:</strong> ${question.correct_answer}
                        </div>
                        <div>
                            <a href="/dashboard/questions/create?question=${encodeURIComponent(question.question)}&answers=${encodeURIComponent(JSON.stringify(question.choices))}&correct_answer=${encodeURIComponent(question.correct_answer)}" class="btn btn-sm btn-primary" target="_blank">Create</a>
                        </div>
                    `;
                    questionList.appendChild(questionDiv);
                });

                page++; // Increment page for next request
            } else {
                disableLoadMoreButton(true, "No More Questions");
            }
        })
        .catch(error => {
            showAlert('Failed to load more questions. Please try again.');
            console.error('Error loading more questions:', error);
        })
        .finally(() => {
            isLoading = false;
            hideLoadingOverlay();
            disableLoadMoreButton(false);
        });
}

// Handle PDF upload and generate questions
document.getElementById('generateButton').addEventListener('click', function () {
    document.getElementById('pdf-upload').click();
});

document.getElementById('pdf-upload').addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (!file || file.type !== 'application/pdf') {
        showAlert('Please upload a valid PDF file.');
        return;
    }

    showLoadingOverlay();
    page = 1; // Reset pagination on new upload

    const formData = new FormData();
    formData.append('pdf', file);

    fetch('/api/generate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                showAlert('Failed to process the PDF. Please try again.');
                return response.json().then(errorData => {
                    throw new Error(errorData.error || 'Failed to process the PDF');
                });
            }
            return response.json();
        })
        .then(data => {
            const questionList = document.getElementById('question-list');
            questionList.innerHTML = ''; // Clear previous content

            if (data.questions && Array.isArray(data.questions)) {
                data.questions.forEach((question) => {
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'question-item';
                    questionDiv.innerHTML = `
                        <div class="question-details">
                            <strong>Question:</strong> ${question.question}
                            <br>
                            <strong>Correct Answer:</strong> ${question.correct_answer}
                        </div>
                        <div>
                            <a href="/dashboard/questions/create?question=${encodeURIComponent(question.question)}&answers=${encodeURIComponent(JSON.stringify(question.choices))}&correct_answer=${encodeURIComponent(question.correct_answer)}" class="btn btn-sm btn-primary" target="_blank">Create</a>
                        </div>
                    `;
                    questionList.appendChild(questionDiv);
                });

                extractedText = data.text; // Store the extracted text for pagination

                if (!loadMoreButton) {
                    loadMoreButton = document.createElement('button');
                    loadMoreButton.className = 'btn btn-primary mt-0';
                    loadMoreButton.innerHTML = '<i class="bi bi-upload"></i> Load More';
                    loadMoreButton.addEventListener('click', loadMoreQuestions);
                    document.getElementById('loadmore-div').appendChild(loadMoreButton);
                } else {
                    disableLoadMoreButton(false);
                }

                // Hide the "Upload PDF" button and show the "Reset" button
                document.getElementById('generateButton').style.display = 'none';
                document.getElementById('backButton1').style.display = 'none';
                document.getElementById('resetButton').style.display = 'block';
                document.getElementById('backButton2').style.display = 'block';
            } else {
                showAlert('No questions found in the PDF.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Failed to process the PDF. Please try again.');
        })
        .finally(() => {
            hideLoadingOverlay();
        });
});

// Handle Reset button click
document.getElementById('resetButton').addEventListener('click', function () {
    // Reset the page
    window.location.reload();
});