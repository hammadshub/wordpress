<?php
/*
 * Plugin Name:       HTML TO PDF GENERATOR
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Hammad Saleem
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       html-to-pdf
 * Domain Path:       /languages
 
 */

 /*
HTML TO PDF GENERATOR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

HTML TO PDF GENERATOR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with HTML TO PDF GENERATOR. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/




if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add admin menu
add_action('admin_menu', 'html_to_pdf_add_menu');
function html_to_pdf_add_menu() {
    add_menu_page(
        'HTML to PDF Generator',      // Page title
        'HTML to PDF',                // Menu title
        'manage_options',             // Capability
        'html-to-pdf',                // Menu slug
        'html_to_pdf_admin_page',     // Callback function
        'dashicons-media-document',   // Icon
        20                            // Position
    );
}

// Admin page content
function html_to_pdf_admin_page() {
    echo '<h1>HTML to PDF Generator</h1>';
    echo '<p>Enter a URL and click "Generate PDF" to create a PDF of that page.</p>';
    echo '<input type="text" id="pdf-url" placeholder="Enter URL" style="width: 300px; margin-bottom: 10px;">';
    echo '<button id="generate-pdf" class="button button-primary">Generate PDF</button>';
}

// Enqueue scripts and styles
add_action('admin_enqueue_scripts', 'html_to_pdf_enqueue_scripts');
function html_to_pdf_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_html-to-pdf') {
        return;
    }
    wp_enqueue_script('jquery'); // Enqueue jQuery
    wp_enqueue_script('html2pdf-js', 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js', array('jquery'), null, true); // External HTML2PDF library
    wp_enqueue_script('html-to-pdf-custom', plugins_url('js/html-to-pdf.js', __FILE__), array('jquery', 'html2pdf-js'), '1.0', true);

    // Pass AJAX URL to JavaScript
    wp_localize_script('html-to-pdf-custom', 'htmlToPdfAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

// Handle AJAX request for PDF generation
add_action('wp_ajax_generate_pdf', 'html_to_pdf_generate_pdf');
function html_to_pdf_generate_pdf() {
    if (!isset($_POST['pdf_url']) || empty($_POST['pdf_url'])) {
        wp_send_json_error('No URL provided.');
    }

    $url = esc_url_raw($_POST['pdf_url']);
    $html = file_get_contents($url); // Fetch the HTML content of the URL

    // Include Dompdf
    require_once __DIR__ . '/vendor/autoload.php'; // Ensure Dompdf is installed
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $output = $dompdf->output();

    // Save PDF
    $upload_dir = wp_upload_dir();
    $pdf_path = $upload_dir['basedir'] . '/generated.pdf';
    file_put_contents($pdf_path, $output);

    wp_send_json_success($upload_dir['baseurl'] . '/generated.pdf'); // Return the PDF URL
}
?>
