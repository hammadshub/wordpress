jQuery(document).ready(function ($) {
    $('#generate-pdf').on('click', function () {
        const url = $('#pdf-url').val(); // Get the input URL
        if (!url) {
            alert('Please enter a URL.');
            return;
        }

        // Send the URL to the server via AJAX
        $.post(htmlToPdfAjax.ajax_url, {
            action: 'generate_pdf',
            pdf_url: url
        }, function (response) {
            if (response.success) {
                window.open(response.data); // Open the generated PDF
            } else {
                alert('Failed to generate PDF: ' + response.data);
            }
        });
    });
});
