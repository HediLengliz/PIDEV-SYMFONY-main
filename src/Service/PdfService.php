<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfService
{
    private $domPdf;

    public function __construct() {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
    
        // Save the PDF to a temporary file
        $tempPdfPath = tempnam(sys_get_temp_dir(), 'pdf');
        $this->domPdf->stream($tempPdfPath);
    
        // Use BinaryFileResponse to handle the response
        $response = new BinaryFileResponse($tempPdfPath);
        $response->headers->set('Content-Type', 'application/pdf');
    
        return $response;
    }
    public function generateBinaryPDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }
}