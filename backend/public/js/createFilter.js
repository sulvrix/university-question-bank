$(document).ready(function () {
    let dataTable;

    // Function to create and populate the table
    function createAndPopulateTable(questions) {
        // Clear the table container
        $('#questions-table-container').empty();

        // Create the table structure
        const table = `
            <table class="table table-bordered table-hover" id="questionsTable">
                <thead class="table-light">
                    <tr>
                        <th>Select</th>
                        <th>Question</th>
                        <th>Difficulty</th>
                        <th>Points</th>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    ${questions.map(question => `
                                    <tr>
                                        <td><input type="checkbox" name="questions[]" value="${question.id}" class="form-check-input"></td>
                                        <td>${question.text}</td>
                                        <td>${question.difficulty}</td>
                                        <td>${question.points}</td>
                                        <td>${question.subject.name}</td>
                                    </tr>
                                `).join('')}
                </tbody>
            </table>
        `;

        // Append the table to the container
        $('#questions-table-container').html(table);

        // Initialize DataTable
        dataTable = $('#questionsTable').DataTable({
            paging: true, // Enable pagination
            searching: true, // Enable search
            ordering: true, // Enable sorting
            info: true, // Show table information
            pageLength: 10, // Default number of rows per page
            lengthMenu: [10, 25, 50, 100], // Rows per page options
            columnDefs: [{
                targets: 0, // First column (Select)
                width: '50px',
                className: 'dt-center',
                orderable: false, // Disable sorting for this column
            },
            {
                targets: 1, // Second column (Question)
                className: 'dt-left',
            },
            {
                targets: [2, 3, 4], // Difficulty, Points, Subject columns
                className: 'dt-left',
            },
            ],
        });
    }

    // Function to filter questions by level
    function filterQuestions(level) {
        const filteredQuestions = allQuestions.filter(question => {
            return question.subject && question.subject.level == level;
        });

        // Create and populate the table with filtered questions
        createAndPopulateTable(filteredQuestions);
    }

    // Load questions on page load (default level 1)
    const defaultLevel = 1;
    filterQuestions(defaultLevel);

    // Load questions when level changes
    $('input[name="level"]').change(function () {
        const level = $('input[name="level"]:checked').val();
        filterQuestions(level);
    });
});