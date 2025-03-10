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

// Function to load more questions
function loadMoreQuestions() {
    if (isLoading || !extractedText) return;
    isLoading = true;

    disableLoadMoreButton(true);
    showLoadingOverlay();
    console.log('Fetching more questions for page:', page);

    fetch(`/api/generate?text=${encodeURIComponent(extractedText)}&page=${page}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', // Ensure the response is JSON
        }
    })
        .then(response => {
            if (!response.ok) {
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
                    questionDiv.className = 'd-flex justify-content-between align-items-center p-3 mb-3 border rounded bg-light';
                    questionDiv.innerHTML = `
                    <div class="flex-grow-1 me-3">
                        <strong>Question:</strong> ${question.question}
                        <br>
                        <strong>Correct Answer:</strong> ${question.correct_answer}
                    </div>
                    <div>
                        <a href="/dashboard/questions/create?question=${encodeURIComponent(question.question)}&answers=${encodeURIComponent(JSON.stringify(question.choices))}&correct_answer=${encodeURIComponent(question.correct_answer)}" class="btn btn-sm btn-success">Create</a>
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
            console.error('Error loading more questions:', error);
            alert(error.message || "Failed to load more questions. Please try again.");
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
        alert('Please upload a valid PDF file.');
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
                    questionDiv.className = 'd-flex justify-content-between align-items-center p-3 mb-3 border rounded bg-light';
                    questionDiv.innerHTML = `
                    <div class="flex-grow-1 me-3">
                        <strong>Question:</strong> ${question.question}
                        <br>
                        <strong>Correct Answer:</strong> ${question.correct_answer}
                    </div>
                    <div>
                        <a href="/dashboard/questions/create?question=${encodeURIComponent(question.question)}&answers=${encodeURIComponent(JSON.stringify(question.choices))}&correct_answer=${encodeURIComponent(question.correct_answer)}" class="btn btn-sm btn-success">Create</a>
                    </div>
                `;
                    questionList.appendChild(questionDiv);
                });

                extractedText = data.text; // Store the extracted text for pagination

                if (!loadMoreButton) {
                    loadMoreButton = document.createElement('button');
                    loadMoreButton.className = 'btn btn-primary mt-3';
                    loadMoreButton.textContent = 'Load More';
                    loadMoreButton.addEventListener('click', loadMoreQuestions);
                    document.getElementById('question-list').insertAdjacentElement('afterend', loadMoreButton);
                } else {
                    disableLoadMoreButton(false);
                }
            } else {
                alert('No questions found in the PDF.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Failed to process the PDF. Please try again.');
        })
        .finally(() => {
            hideLoadingOverlay();
        });
});