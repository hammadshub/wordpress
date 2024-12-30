document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('download-pdf');
    if (button) {
        button.addEventListener('click', function () {
            // Use html2pdf.js to generate PDF
            const element = document.body; // You can specify a specific element instead of entire body
            const options = {
                margin: 1,
                filename: 'page.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
            };
            html2pdf().set(options).from(element).save();
        });
    }
});
