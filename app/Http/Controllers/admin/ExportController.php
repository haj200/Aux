<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auxiliaire;
use App\Models\Conjoint;
use App\Models\Enfant;
use App\Models\Entiteterritorielle;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\writer;

class ExportController extends Controller
{
    private function exportAsExcel($spreadsheet, $filename)
    {
        // Create an Xlsx writer from the spreadsheet
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Create a new response object
        $response = new \Illuminate\Http\Response();

        // Set the headers for the Excel file download
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        // Write the content to output and capture it
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        // Set the captured content as the response content
        $response->setContent($content);

        return $response;
    }

    // Exportation des Entités Territoriales
    public function exportEntiteTerritoriale()
    {
        // Get all territorial entities with the manager (user) details
        $entities = Entiteterritorielle::with('manager')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header and style it with red color and bold
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];

        // Headers for territorial entities and managers
        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Nom Ar');
        $sheet->setCellValue('C1', 'Type');
        $sheet->setCellValue('D1', 'ID Manager');
        $sheet->setCellValue('E1', 'Nom Complet Manager (Fr)');
        $sheet->setCellValue('F1', 'Nom Complet Manager (Ar)');
        $sheet->setCellValue('G1', 'Email Manager');

        // Apply styles to the header row (A1 to G1)
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Fill in the data
        $row = 2;
        foreach ($entities as $entity) {
            $sheet->setCellValue('A' . $row, $entity->Nom);
            $sheet->setCellValue('B' . $row, $entity->Nom_Ar);
            $sheet->setCellValue('C' . $row, $entity->type);
            $sheet->setCellValue('D' . $row, $entity->managed_by);

            // Check if manager exists
            if ($entity->manager) {
                $sheet->setCellValue('E' . $row, $entity->manager->Nom_Fr . ' ' . $entity->manager->Prenom_Fr);
                $sheet->setCellValue('F' . $row, $entity->manager->Nom_Ar . ' ' . $entity->manager->Prenom_Ar);
                $sheet->setCellValue('G' . $row, $entity->manager->email);
            }

            $row++;
        }

        // Return the spreadsheet as a downloadable Excel file
        return $this->exportAsExcel($spreadsheet, 'entites_territoriales.xlsx');
    }


    // Exportation des Users (Managers)
    public function exportUsers()
    {
        $users = User::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header and style it with red color and bold
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];

        // Headers for user details
        $sheet->setCellValue('A1', 'Nom (Fr)');
        $sheet->setCellValue('B1', 'Prénom (Fr)');
        $sheet->setCellValue('C1', 'Nom (Ar)');
        $sheet->setCellValue('D1', 'Prénom (Ar)');
        $sheet->setCellValue('E1', 'Email');

        // Apply styles to the header row (A1 to E1)
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Fill in the data
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->Nom_Fr);
            $sheet->setCellValue('B' . $row, $user->Prenom_Fr);
            $sheet->setCellValue('C' . $row, $user->Nom_Ar);
            $sheet->setCellValue('D' . $row, $user->Prenom_Ar);
            $sheet->setCellValue('E' . $row, $user->email);
            $row++;
        }

        // Return the spreadsheet as a downloadable Excel file
        return $this->exportAsExcel($spreadsheet, 'managers.xlsx');
    }


    // Exportation des Auxiliaires
    public function exportAuxiliaires()
    {
        
        $auxiliaires = Auxiliaire::with('entiteTerritorielle')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header style (red color, bold)
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];

        // Headers for auxiliaires details
        $sheet->setCellValue('A1', 'Nom (Fr)');
        $sheet->setCellValue('B1', 'Prénom (Fr)');
        $sheet->setCellValue('C1', 'Nom (Ar)');
        $sheet->setCellValue('D1', 'Prénom (Ar)');
        $sheet->setCellValue('E1', 'Grade');
        $sheet->setCellValue('F1', 'CNIE');
        $sheet->setCellValue('G1', 'Date de Naissance');
        $sheet->setCellValue('H1', 'Date de Recrutement');
        $sheet->setCellValue('I1', 'Type');
        $sheet->setCellValue('J1', 'Pensionné');
        $sheet->setCellValue('K1', 'Entité Territorielle');

        // Apply header styles to cells A1 to J1
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Fill in the data for each auxiliaire
        $row = 2;
        foreach ($auxiliaires as $auxiliaire) {
            $sheet->setCellValue('A' . $row, $auxiliaire->Nom_Fr);
            $sheet->setCellValue('B' . $row, $auxiliaire->Prenom_Fr);
            $sheet->setCellValue('C' . $row, $auxiliaire->Nom_Ar);
            $sheet->setCellValue('D' . $row, $auxiliaire->Prenom_Ar);
            $sheet->setCellValue('E' . $row, $auxiliaire->Grade);
            $sheet->setCellValue('F' . $row, $auxiliaire->CNIE);
            $sheet->setCellValue('G' . $row, $auxiliaire->date_de_naissance);
            $sheet->setCellValue('H' . $row, $auxiliaire->date_de_recrutement);
            $sheet->setCellValue('I' . $row, $auxiliaire->Type);
            $sheet->setCellValue('J' . $row, $auxiliaire->pensionne ? 'Oui' : 'Non');
            $sheet->setCellValue('K' . $row, $auxiliaire->entiteTerritorielle->Nom);
            $row++;
        }

        // Export as Excel file
        return $this->exportAsExcel($spreadsheet, 'auxiliaires.xlsx');
    }


    // Exportation des Enfants
    public function exportEnfants()
    {
        $enfants = Enfant::with('auxiliaire')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header style (red color, bold)
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];

        // Headers for enfants details
        $sheet->setCellValue('A1', 'Nom (Fr)');
        $sheet->setCellValue('B1', 'Prénom (Fr)');
        $sheet->setCellValue('C1', 'Nom (Ar)');
        $sheet->setCellValue('D1', 'Prénom (Ar)');
        $sheet->setCellValue('E1', 'Date de Naissance');
        $sheet->setCellValue('F1', 'Nom De l\' Auxiliaire ');
        $sheet->setCellValue('G1', 'Prénom De \' Auxiliaire');

        // Apply header styles to cells A1 to F1
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Fill in the data for each enfant
        $row = 2;
        foreach ($enfants as $enfant) {
            $sheet->setCellValue('A' . $row, $enfant->Nom_Fr);
            $sheet->setCellValue('B' . $row, $enfant->Prenom_Fr);
            $sheet->setCellValue('C' . $row, $enfant->Nom_Ar);
            $sheet->setCellValue('D' . $row, $enfant->Prenom_Ar);
            $sheet->setCellValue('E' . $row, $enfant->Date_De_Naissance);
            $sheet->setCellValue('F' . $row, $enfant->auxiliaire->Nom_Fr );
            $sheet->setCellValue('G' . $row, $enfant->auxiliaire->Prenom_Fr );
            
            
            $row++;
        }

        // Export as Excel file
        return $this->exportAsExcel($spreadsheet, 'enfants.xlsx');
    }


    // Exportation des Conjoints
    public function exportConjoints()
    {
        $conjoints = Conjoint::with('auxiliaire')->get();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header style (red color, bold)
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];

        // Headers for conjoints details
        $sheet->setCellValue('A1', 'Nom (Fr)');
        $sheet->setCellValue('B1', 'Prénom (Fr)');
        $sheet->setCellValue('C1', 'Nom (Ar)');
        $sheet->setCellValue('D1', 'Prénom (Ar)');
        $sheet->setCellValue('E1', 'CNIE');
        $sheet->setCellValue('F1', 'Nom De l\' Auxiliaire ');
        $sheet->setCellValue('G1', 'Prénom De \' Auxiliaire');

        // Apply header styles to cells A1 to F1
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Fill in the data for each conjoint
        $row = 2;
        foreach ($conjoints as $conjoint) {
            $sheet->setCellValue('A' . $row, $conjoint->Nom_Fr);
            $sheet->setCellValue('B' . $row, $conjoint->Prenom_Fr);
            $sheet->setCellValue('C' . $row, $conjoint->Nom_Ar);
            $sheet->setCellValue('D' . $row, $conjoint->Prenom_Ar);
            $sheet->setCellValue('E' . $row, $conjoint->CNIE);
            $sheet->setCellValue('F' . $row, $conjoint->auxiliaire_id);
            $sheet->setCellValue('F' . $row, $conjoint->auxiliaire->Nom_Fr );
            $sheet->setCellValue('G' . $row, $conjoint->auxiliaire->Prenom_Fr );
            $row++;
        }

        // Export as Excel file
        return $this->exportAsExcel($spreadsheet, 'conjoints.xlsx');
    }
    private function getColumnLetter($columnIndex)
    {
        $letter = '';
        while ($columnIndex > 0) {
            $letter = chr(($columnIndex - 1) % 26 + 65) . $letter;
            $columnIndex = (int)(($columnIndex - 1) / 26);
        }
        return $letter;
    }

    // Exportation Globale


    public function exportGlobal()
    {
        $auxiliaires = Auxiliaire::with(['enfants', 'conjoints'])->get();
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Set the headers for the auxiliary information
        $headers = ['Nom (Fr)', 'Prénom (Fr)', 'Nom (Ar)', 'Prénom (Ar)', 'Email', 'Grade', 'CNIE', 'Date de Naissance', 'Date de Recrutement', 'Type', 'Pensionné'];
        $columnLetter = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($columnLetter . '1', $header);
            $columnLetter++;
        }
    
        // Apply header styles (bold and red)
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFF0000'], // Red color
            ],
        ];
        $sheet->getStyle('A1:K1')->applyFromArray($headerStyleArray); // Apply to header range
    
        // Start row for auxiliary data
        $row = 2; // Starting from row 2 after headers
    
        // Fill in the auxiliary data
        foreach ($auxiliaires as $auxiliaire) {
            $sheet->setCellValue('A' . $row, $auxiliaire->Nom_Fr);
            $sheet->setCellValue('B' . $row, $auxiliaire->Prenom_Fr);
            $sheet->setCellValue('C' . $row, $auxiliaire->Nom_Ar);
            $sheet->setCellValue('D' . $row, $auxiliaire->Prenom_Ar);
            $sheet->setCellValue('E' . $row, $auxiliaire->Email);
            $sheet->setCellValue('F' . $row, $auxiliaire->Grade);
            $sheet->setCellValue('G' . $row, $auxiliaire->CNIE);
            $sheet->setCellValue('H' . $row, $auxiliaire->date_de_naissance);
            $sheet->setCellValue('I' . $row, $auxiliaire->date_de_recrutement);
            $sheet->setCellValue('J' . $row, $auxiliaire->Type);
            $sheet->setCellValue('K' . $row, $auxiliaire->pensionne ? 'Oui' : 'Non');
    
            // Add Children Headers
            $startColumn = 'M'; // Start column for children and spouses
    
            // Check if the auxiliary has children
            if ($auxiliaire->enfants->isNotEmpty()) {
                // Set headers for children
                $sheet->setCellValue($startColumn . $row, 'Enfants:');
                $sheet->setCellValue($startColumn . ($row + 1), 'Nom (Fr)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 1) . ($row + 1), 'Prénom (Fr)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 2) . ($row + 1), 'Nom (Ar)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 3) . ($row + 1), 'Prénom (Ar)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 4) . ($row + 1), 'Date de Naissance');
    
                // Apply children header styles (bold and blue)
                $childHeaderStyleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF0000FF'], // Blue color
                    ],
                ];
                $sheet->getStyle($startColumn . $row . ':' . $this->getColumnLetter(ord($startColumn) - 65 + 4) . ($row + 1))->applyFromArray($childHeaderStyleArray); // Apply to children header range
    
                // Fill in children data
                $childRow = $row + 2; // Start filling children from the next row
                foreach ($auxiliaire->enfants as $enfant) {
                    $sheet->setCellValue($startColumn . $childRow, $enfant->Nom_Fr);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 1) . $childRow, $enfant->Prenom_Fr);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 2) . $childRow, $enfant->Nom_Ar);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 3) . $childRow, $enfant->Prenom_Ar);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 4) . $childRow, $enfant->Date_De_Naissance);
                    $childRow++;
                }
                $row = $childRow; // Update the main row to the last child row
            }
    
            // Add Spouse Headers
            // Check if the auxiliary has spouses
            if ($auxiliaire->conjoints->isNotEmpty()) {
                // Set headers for spouses
                $sheet->setCellValue($startColumn . $row, 'Conjoints:');
                $sheet->setCellValue($startColumn . ($row + 1), 'Nom (Fr)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 1) . ($row + 1), 'Prénom (Fr)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 2) . ($row + 1), 'Nom (Ar)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 3) . ($row + 1), 'Prénom (Ar)');
                $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 4) . ($row + 1), 'CNIE');
    
                // Apply spouse header styles (bold and blue)
                $spouseHeaderStyleArray = [
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF0000FF'], // Blue color
                    ],
                ];
                $sheet->getStyle($startColumn . $row . ':' . $this->getColumnLetter(ord($startColumn) - 65 + 4) . ($row + 1))->applyFromArray($spouseHeaderStyleArray); // Apply to spouse header range
    
                // Fill in spouse data
                $spouseRow = $row + 2; // Start filling spouses from the next row
                foreach ($auxiliaire->conjoints as $conjoint) {
                    $sheet->setCellValue($startColumn . $spouseRow, $conjoint->Nom_Fr);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 1) . $spouseRow, $conjoint->Prenom_Fr);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 2) . $spouseRow, $conjoint->Nom_Ar);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 3) . $spouseRow, $conjoint->Prenom_Ar);
                    $sheet->setCellValue($this->getColumnLetter(ord($startColumn) - 65 + 4) . $spouseRow, $conjoint->CNIE);
                    $spouseRow++;
                }
                $row = $spouseRow; // Update the main row to the last spouse row
            }
    
            $row++; // Move to the next auxiliary row
        }
    
        // Set Auto Width for all columns
        foreach (range('A', $sheet->getHighestDataColumn()) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Generate the file name
        $fileName = 'Auxiliaires_Export_' . date('Y-m-d') . '.xlsx';
    
        // Use the exportAsExcel method to return the file as a response
        return $this->exportAsExcel($spreadsheet, $fileName);
    }
    

    public function exportCard()
    {
        $auxiliaires = Auxiliaire::all();
    
        // Initialiser DOMPDF avec des options
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
    
        // Créer le contenu HTML pour les cartes
        $html = '<style>
                    body {
                        font-family: DejaVu Sans;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .header h2 {
                        color: #007bff;
                    }
                    .page {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        page-break-after: always;
                    }
                    .card {
                        border: 2px solid #007bff;
                        border-radius: 10px;
                        padding: 20px;
                        width: 300px;
                        background-color: #f8f9fa;
                        text-align: left;
                        color: #333;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    }
                    .card h4 {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }
                    .card p {
                        font-size: 16px;
                        margin: 5px 0;
                        font-weight: bold;
                    }
                </style>';
    
        // En-tête "Ministère de l'Intérieur"
        $html .= '<div class="header">
                    <h2>Ministère de l\'Intérieur</h2>
                    <h4>Cartes des Auxiliaires</h4>
                  </div>';
    
        // Générer une carte par page, centrée
        foreach ($auxiliaires as $auxiliaire) {
            $html .= '<div class="page">';
            $html .= '<div class="card">';
            $html .= '<h4>Nom: ' . $auxiliaire->Nom_Fr . '</h4>';
            $html .= '<h4>Prénom: ' . $auxiliaire->Prenom_Fr . '</h4>';
            $html .= '<p>Date de Naissance: ' . $auxiliaire->date_de_naissance . '</p>';
            $html .= '<p>Grade: ' . $auxiliaire->Grade . '</p>';
            $html .= '<p>Pensionné: ' . ($auxiliaire->pensionne ? 'Oui' : 'Non') . '</p>';
            $html .= '</div>';
            $html .= '</div>';
        }
    
        // Charger le contenu HTML dans DOMPDF
        $dompdf->loadHtml($html);
    
        // Configurer le format du papier en portrait (A4)
        $dompdf->setPaper('A4', 'portrait');
    
        // Rendre le PDF
        $dompdf->render();
    
        // Télécharger le PDF généré
        return $dompdf->stream('auxiliaires_cards.pdf', ['Attachment' => true]);
    }
    
    



}


    // Méthode pour exporter en Excel
    // Export method
    
    // Export method
