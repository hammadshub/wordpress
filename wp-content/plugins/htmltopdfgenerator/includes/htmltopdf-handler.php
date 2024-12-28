<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Load Dompdf library
use Dompdf\Dompdf;

// Hook to handle AJAX requests
add_action('wp_ajax_generate_pdf', 'htmltopdf_generate_pdf');
add_action('wp_ajax_nopriv_generate_pdf', 'htmltopdf_generate_pdf');

// Function to process the PDF generation
function htmltopdf_generate_pdf() {
    // Validate input
    if (!isset($_POST['url']) || empty($_POST['url'])) {
        wp_send_json_error('Invalid URL.');
    }

    $url = esc_url_raw($_POST['url']); // Sanitize URL input
    $html = file_get_contents($url); // Fetch the HTML from the provided URL

    // Initialize Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html); // Load HTML into Dompdf
    $dompdf->setPaper('A4', 'portrait'); // Set paper size and orientation
    $dompdf->render(); // Render the PDF

    // Save the PDF to the uploads directory
    $output = $dompdf->output();
    $upload_dir = wp_upload_dir();
    $pdf_path = $upload_dir['path'] . '/generated-pdf.pdf';
    file_put_contents($pdf_path, $output);

    // Return the URL of the generated PDF
    wp_send_json_success($upload_dir['url'] . '/generated-pdf.pdf');
}
