<?php

namespace App\Classe;

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;

class ExportPdf
{
    function export_pdf($data, $html, $file_name_first, $file_name_last)
    {
        $exportPdf = new Dompdf();
        $options = $exportPdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set("isPhpEnabled", true);
        $options->set('isJavascriptEnabled', true);
        $options->set('tempDir', '/Users/abdelmontet/Documents/http/mycms/public/tmp');
        $options->setDefaultFont('Arial');
        
        $exportPdf->setOptions($options);
        $exportPdf->setPaper('A4', 'portrait');
        
        $exportPdf->loadHtml($html);
        $exportPdf->render();
        // Ajout pagination
        $canvas = $exportPdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = date("Y-m-d H:i") . " - " . "Page $pageNumber / $pageCount";
            $font = $fontMetrics->getFont('Arial');
            $pageWidth = $canvas->get_width();
            $pageHeight = $canvas->get_height();
            $size = 8;
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text, $font, $size);
        });

        return new Response (
            $exportPdf->stream($file_name_first . "__" . $file_name_last, ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-type' => 'application/pdf']
        );
    }
}
