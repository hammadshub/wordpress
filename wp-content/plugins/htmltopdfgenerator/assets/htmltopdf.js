jQuery(document).ready(function ($) {
    $('#generate-pdf-btn').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Get the URL entered by the user
        const url = $('#html-to-pdf-url').val();

        if (url) {
            // Send an AJAX POST request to the server
            $.post(
                ajaxurl, // WordPress-provided AJAX URL
                {
                    action: 'generate_pdf', // Action name for WordPress
                    url: url, // The URL entered by the user
                },
                function (response) {
                    // If the server responds successfully
                    if (response.success) {
                        window.location.href = response.data; // Redirect to the generated PDF
                    } else {
                        alert('Error generating PDF: ' + response.data); // Show error
                    }
                }
            );
        } else {
            alert('Please enter a valid URL.'); // If the input is empty
        }
    });
});
