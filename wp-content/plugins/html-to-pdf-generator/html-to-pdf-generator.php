
<?php
/*
Plugin Name: HTML to PDF Generator  
Description: Generate PDF files from WordPress posts/pages or custom URLs.
Version: 1.3
Author: WS Squad
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue JavaScript and CSS
function htpdf_enqueue_scripts() {
    wp_enqueue_script('htpdf-js', plugins_url('html-to-pdf.js', __FILE__), [], '1.3', true);
}
add_action('wp_enqueue_scripts', 'htpdf_enqueue_scripts');

// Add "Download as PDF" Button on Frontend
function htpdf_add_download_button($content) {
    if (is_singular()) { // Display on single posts/pages
        $button = '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">
            <input type="hidden" name="action" value="htpdf_generate_pdf">
            <input type="hidden" name="html_content" value="' . esc_attr(base64_encode($content)) . '">
            <button type="submit" style="margin-top: 20px;">Download as PDF</button>
        </form>';
        $content .= $button;
    }
    return $content;
}
add_filter('the_content', 'htpdf_add_download_button');

// Handle PDF Generation
function htpdf_generate_pdf() {
    if (!isset($_POST['html_content'])) {
        wp_die('Invalid request');
    }

    require_once(plugin_dir_path(__FILE__) . 'lib/dompdf/autoload.inc.php');
 
    $dompdf = new Dompdf\Dompdf();

    $html_content = base64_decode(sanitize_text_field($_POST['html_content']));
    $dompdf->loadHtml($html_content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the PDF as a file download
    $dompdf->stream('generated.pdf', ['Attachment' => true]);
    exit;
}
add_action('admin_post_htpdf_generate_pdf', 'htpdf_generate_pdf');
add_action('admin_post_nopriv_htpdf_generate_pdf', 'htpdf_generate_pdf');

// Add Admin Menu for URL Input
function htpdf_add_admin_menu() {
    add_menu_page(
        'HTML to PDF Generator',
        'HTML to PDF',
        'manage_options',
        'html-to-pdf',
        'htpdf_admin_page',
        'dashicons-media-document',
        80
    );
}
add_action('admin_menu', 'htpdf_add_admin_menu');

// Admin Page Content
function htpdf_admin_page() {
    ?>
    <div class="wrap">
        <h1>HTML to PDF Generator</h1>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="htpdf_generate_pdf_url">
            <label for="url">Enter URL:</label>
            <input type="url" id="url" name="url" placeholder="https://example.com" required style="width: 300px;">
            <button type="submit">Generate PDF</button>
        </form>
    </div>
    <?php
}

// Handle PDF Generation from URL
function htpdf_generate_pdf_url() {
    if (!isset($_POST['url'])) {
        wp_die('Invalid request');
    }

    require_once(plugin_dir_path(__FILE__) . 'lib/dompdf/autoload.inc.php');

    $dompdf = new Dompdf\Dompdf();

    $url = esc_url_raw($_POST['url']);
    $html_content = wp_remote_retrieve_body(wp_remote_get($url));

    if (is_wp_error($html_content)) {
        wp_die('Failed to fetch URL content');
    }

    $dompdf->loadHtml($html_content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the PDF as a file download
    $dompdf->stream('generated-url.pdf', ['Attachment' => true]);
    exit;
}
add_action('admin_post_htpdf_generate_pdf_url', 'htpdf_generate_pdf_url');
