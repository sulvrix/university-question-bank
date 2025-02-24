document.getElementById('rephraseButton').addEventListener('click',
    function () {
        const questionText = document.getElementById('text').value;
        if (!questionText) {
            alert('Please enter a question to rephrase');
            return;
        }

        fetch('/api/rephrase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content')
            },
            body: JSON.stringify({
                question: questionText
            })
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
                if (data.rephrases) {
                    // Check if any rephrase contains the word "wrong"
                    if (data.rephrases.some(rephrase => rephrase.toLowerCase() === 'wrong')) {
                        alert('The question is invalid, please try a different question.');
                        return; // Exit the function if the response is "wrong"
                    }
                    const originalQuestion = document.getElementById('originalQuestion');
                    const rephraseList = document.getElementById('rephraseList');

                    // Display the original question
                    originalQuestion.textContent = `Original: ${questionText}`;

                    // Clear previous rephrased questions
                    rephraseList.innerHTML = '';

                    // Ensure that each rephrase is added individually
                    data.rephrases.forEach(rephrase => {
                        const rephrasedQuestion = document.createElement('div');
                        rephrasedQuestion.className = 'rephrased-question';
                        rephrasedQuestion.textContent = rephrase;

                        // Add click event to replace textarea content
                        rephrasedQuestion.addEventListener('click', function () {
                            document.getElementById('text').value = rephrase;
                            const modal = bootstrap.Modal.getInstance(document
                                .getElementById('rephraseModal'));
                            modal.hide();
                        });

                        rephraseList.appendChild(rephrasedQuestion);
                    });

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('rephraseModal'));
                    modal.show();
                } else {
                    throw new Error('No rephrases found in response');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message); // Show an alert with the error message
            });
    });