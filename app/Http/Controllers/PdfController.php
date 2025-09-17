<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function demo()
    {
        $pdf = Pdf::loadView('pdf.demo', [
            'title' => 'Mi primer PDF en Laravel'
        ]);

        // Descargar directamente
        return $pdf->download('ejemplo.pdf');

        // 👉 Si prefieres verlo en navegador en lugar de descargar:
        // return $pdf->stream('ejemplo.pdf');
    }
}
