<?php

namespace App\Traits;

trait PdfExportable
{
    /**
     * Generate PDF filename
     */
    public function getPdfFilename($type, $id)
    {
        return strtolower($type) . '_' . $id . '_' . now()->format('Y-m-d-His') . '.pdf';
    }

    /**
     * Get PDF headers
     */
    public function getPdfHeaders($filename)
    {
        return [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
    }

    /**
     * Render view as PDF-ready HTML
     */
    public function renderPdfView($view, $data = [])
    {
        return view($view, $data)->render();
    }
}
