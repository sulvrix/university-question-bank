document.addEventListener('DOMContentLoaded', function () {
    let dataTable;

    // Function to create and populate the table
    function createAndPopulateTable(questions) {
        // Clear the table container
        $('#questions-table-container').empty();

        // Create the table structure
        const table = `
            <table class="table table-bordered table-hover" id="questionsTable">
                <thead class="table-light">
                    <tr class="user-select-none">
                        <th>Select</th>
                        <th>Question</th>
                        <th>Difficulty</th>
                        <th>Points</th>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    ${questions.map(question => `
                        <tr class="user-select-none" role="button">
                            <td>
                                <input type="checkbox" name="questions[]" value="${question.id}" class="form-check-input"
                                    ${selectedQuestions.includes(question.id) ? 'checked' : ''}>
                            </td>
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

        // Destroy existing DataTable instance if it exists
        if (dataTable) {
            dataTable.destroy();
        }

        // Initialize DataTable
        dataTable = $('#questionsTable').DataTable({
            layout: {
                topStart: {
                    pageLength: {
                        menu: [10, 25, 50, {
                            label: 'All',
                            value: -1
                        }],
                    }
                },
                topEnd: {
                    search: {
                        placeholder: 'Type Something..'
                    }
                },
                bottomEnd: {
                    paging: {
                        buttons: 3
                    }
                },
            },
            columnDefs: [
                {
                    targets: '_all', // Target all columns
                    render: function (data, type, row, meta) {
                        if (meta.col === 0 || meta.col === meta.settings.aoColumns.length - 1) {
                            return '<span>' + data + '</span>';
                        }
                        // Default truncation for text
                        return '<span" title="' + data + '">' + data +
                            '</span>';
                    }
                },
                {
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
        // Handle row clicks to toggle checkboxes
        $('#questionsTable tbody').on('click', 'tr', function (e) {
            // Check if the click was on the checkbox itself
            if ($(e.target).is('input[type="checkbox"]')) {
                return; // Let the checkbox handle its own click event
            }

            // Find the checkbox inside the clicked row
            const checkbox = $(this).find('input[type="checkbox"]');

            // Toggle the checkbox
            checkbox.prop('checked', !checkbox.prop('checked'));

            // Update the Select All checkbox state
            updateSelectAllCheckbox();
        });

        // Handle Select All checkbox
        $('#select-all-checkbox').on('change', function () {
            const isChecked = $(this).prop('checked');
            $('input[name="questions[]"]').prop('checked', isChecked);
        });

        // Handle individual checkbox changes
        $('#questionsTable').on('change', 'input[name="questions[]"]', function () {
            updateSelectAllCheckbox();
        });

        // Function to update the Select All checkbox state
        function updateSelectAllCheckbox() {
            const allChecked = $('input[name="questions[]"]').length === $('input[name="questions[]"]:checked').length;
            $('#select-all-checkbox').prop('checked', allChecked);
        }
    }

    // Function to filter questions based on department ID
    function filterQuestions() {
        const level = $('#level').val();
        const subjectId = $('#subject_id').val();

        let filteredQuestions;

        if (departmentId == 2) {
            // For department ID 2, filter by level
            filteredQuestions = allQuestions.filter(question => {
                return question.subject && question.subject.level == level;
            });
        } else {
            // For other departments, filter by subject
            if (subjectId) {
                filteredQuestions = allQuestions.filter(question => {
                    return question.subject && question.subject.id == subjectId;
                });
            } else {
                // If no subject is selected, show no questions
                filteredQuestions = [];
            }
        }

        // Create and populate the table with filtered questions
        createAndPopulateTable(filteredQuestions);
    }

    // Determine the default level and subject based on the selected questions
    let defaultLevel;
    let defaultSubjectId;

    if (selectedQuestions.length > 0) {
        // Find the first selected question to get its subject's level and subject ID
        const firstSelectedQuestion = allQuestions.find(question => selectedQuestions.includes(question.id));
        if (firstSelectedQuestion && firstSelectedQuestion.subject) {
            defaultLevel = firstSelectedQuestion.subject.level;
            defaultSubjectId = firstSelectedQuestion.subject.id;
        }
    }

    // If no selected questions, fall back to the dropdown values
    if (!defaultLevel) {
        defaultLevel = $('#level').val(); // Get the selected level from the dropdown
    }
    if (!defaultSubjectId) {
        defaultSubjectId = $('#subject_id').val(); // Get the selected subject from the dropdown
    }

    // Set the default values for level and subject dropdowns
    $('#level').val(defaultLevel);
    $('#subject_id').val(defaultSubjectId);

    // Trigger the level change event to filter subjects based on the default level
    $('#level').trigger('change');

    // Load questions on page load (default level and subject)
    filterQuestions();

    // Load questions when level changes (only for department ID 2)
    $('#level').change(function () {
        if (departmentId == 2) {
            filterQuestions();
        } else {
            // Reset the subject dropdown to "Select a Subject"
            $('#subject_id').val('');
            filterQuestions(); // This will filter based on the new level and no subject
        }
    });

    // Load questions when subject changes (for other departments)
    $('#subject_id').change(function () {
        if (departmentId != 2) {
            filterQuestions();
        }
    });
});