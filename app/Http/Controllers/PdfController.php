<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $data = ['title' => 'Application de Gestion des Auxiliaires', 'description' => 'Gérez efficacement les auxiliaires, leurs familles et les entités territoriales.'];
        
        // Charger une vue et passer les données
        $pdf = Pdf::loadView('presentApp', $data);

        // Télécharger le PDF
        return $pdf->download('Presentation_Application_Auxiliaire.pdf');
    }
}


