let page = 1; // Track the current page of questions
let isLoading = false; // Prevent multiple simultaneous requests
let loadMoreButton = null; // Reference to the "Load More" button
let pdfText = ''; // Store the extracted PDF text

function showLoadingOverlay() {
    const loadingOverlay = document.getElementById('loading-overlay');
    loadingOverlay.style.display = 'flex'; // Show the overlay
}

// Function to hide the loading overlay
function hideLoadingOverlay() {
    const loadingOverlay = document.getElementById('loading-overlay');
    loadingOverlay.style.display = 'none'; // Hide the overlay
}

// Function to load more questions
function loadMoreQuestions() {
    if (isLoading) return; // Prevent multiple requests
    isLoading = true;

    showLoadingOverlay();
    console.log('Fetching more questions for page:', page); // Log the current page

    fetch(`/api/generate?page=${page}&pdfText=${encodeURIComponent(pdfText)}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorText => {
                    console.error('Server response error:', errorText); // Log the error response
                    throw new Error('Something went wrong. Please check the console for details.');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('API response data:', data); // Log the API response
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

                page++; // Increment the page for the next request
                console.log('Loaded more questions. Current page:', page); // Log the updated page

                // Add the "Load More" button if it doesn't exist
                if (!loadMoreButton) {
                    loadMoreButton = document.createElement('button');
                    loadMoreButton.className = 'btn btn-primary mt-3';
                    loadMoreButton.textContent = 'Load More';
                    loadMoreButton.addEventListener('click', loadMoreQuestions);

                    // Append the "Load More" button to the page
                    document.getElementById('question-list').insertAdjacentElement('afterend', loadMoreButton);
                }
            } else {
                throw new Error('No more questions found');
            }
        })
        .catch(error => {
            console.error('Error loading more questions:', error); // Log the error
            alert(error.message); // Show an alert with the error message
        })
        .finally(() => {
            isLoading = false; // Reset the loading state
            hideLoadingOverlay();
            console.log('Loading complete.'); // Log when loading is complete
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
                return response.text().then(errorText => {
                    console.error('Server response:', errorText);
                    throw new Error('Something went wrong. Please check the console for details.');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response data:', data); // Log the response data
            if (data.questions && Array.isArray(data.questions)) {
                const questionList = document.getElementById('question-list');
                questionList.innerHTML = ''; // Clear previous content

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

                // Store the extracted PDF text for future requests
                pdfText = data.pdfText;

                // Add the "Load More" button after the first set of questions is loaded
                if (!loadMoreButton) {
                    loadMoreButton = document.createElement('button');
                    loadMoreButton.className = 'btn btn-primary mt-3';
                    loadMoreButton.textContent = 'Load More';
                    loadMoreButton.addEventListener('click', loadMoreQuestions);

                    // Append the "Load More" button to the page
                    document.getElementById('question-list').insertAdjacentElement('afterend', loadMoreButton);
                }
            } else {
                throw new Error('No questions found in response');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message); // Show an alert with the error message
        })
        .finally(() => {
            hideLoadingOverlay(); // Hide the loading overlay
        });
});