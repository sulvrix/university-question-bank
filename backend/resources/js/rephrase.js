// import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // Import Bootstrap JS
document.addEventListener('DOMContentLoaded', function () {

    function showLoadingOverlay() {
        document.getElementById('loading-overlay').style.display = 'flex';
    }

    function hideLoadingOverlay() {
        document.getElementById('loading-overlay').style.display = 'none';
    }

    document.getElementById('rephraseButton').addEventListener('click', function () {
        const questionText = document.getElementById('text').value.trim();

        if (!questionText) {
            alert('Please enter a question to rephrase');
            return;
        }

        showLoadingOverlay();

        const rephraseButton = document.getElementById('rephraseButton');
        rephraseButton.disabled = true;
        rephraseButton.textContent = 'Rephrasing...';

        fetch('/api/rephrase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ question: questionText })
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error || 'Something went wrong');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!data.rephrases || !Array.isArray(data.rephrases) || data.rephrases.length === 0) {
                    throw new Error('No rephrases found in response');
                }

                // Filter out empty or null rephrases on the client side (optional)
                data.rephrases = data.rephrases.filter(rephrase => rephrase && rephrase.trim() !== '');

                // Handle invalid question response
                if (data.rephrases.length === 1 && data.rephrases[0].trim().toLowerCase() === 'wrong') {
                    alert('The question is invalid, please try a different question.');
                    return;
                }

                const originalQuestion = document.getElementById('originalQuestion');
                const rephraseList = document.getElementById('rephraseList');

                // Display the original question
                originalQuestion.textContent = `${questionText}`;

                // Clear previous rephrased questions
                rephraseList.innerHTML = '';

                // Add each rephrased question as a new row
                data.rephrases.forEach(rephrase => {
                    const rephrasedQuestion = document.createElement('div');
                    rephrasedQuestion.className = 'rephrased-question p-3 text-primary-emphasis border border-secondary-subtle rounded-3';
                    rephrasedQuestion.textContent = rephrase;

                    // Click event to replace textarea content
                    rephrasedQuestion.addEventListener('click', function () {
                        document.getElementById('text').value = rephrase;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('rephraseModal'));
                        modal.hide();
                    });

                    rephraseList.appendChild(rephrasedQuestion);
                });

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('rephraseModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Failed to rephrase. Please try again.');
            })
            .finally(() => {
                hideLoadingOverlay();
                rephraseButton.disabled = false;
                rephraseButton.textContent = 'Rephrase';
            });
    });
});
