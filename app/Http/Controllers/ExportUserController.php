<?php

namespace App\Http\Controllers;

use App\Models\Auxiliaire;
use App\Models\Conjoint;
use App\Models\Enfant;
use App\Models\Entiteterritorielle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExportUserController extends Controller
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

    


    

    // Exportation des Auxiliaires
    public function exportAuxiliaires()
    {
        $auxiliaires = Auxiliaire::where('user_id', Auth::id())->get();

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

        // Apply header styles to cells A1 to J1
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyleArray);

        // Auto-size columns for better readability
        foreach (range('A', 'J') as $columnID) {
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
            $row++;
        }

        // Export as Excel file
        return $this->exportAsExcel($spreadsheet, 'auxiliaires.xlsx');
    }


    // Exportation des Enfants
    public function exportEnfants()
    {
        $enfants = Enfant::where('user_id', Auth::id())->with('auxiliaire')->get();
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
        $sheet->setCellValue('F1', 'Nom du Parent ');
        $sheet->setCellValue('G1', 'Prénom du Parent ');

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
            $sheet->setCellValue('F' . $row, $enfant->auxiliaire->Nom_Fr);
            $sheet->setCellValue('G' . $row, $enfant->auxiliaire->Prenom_Fr);
            $row++;
        }

        // Export as Excel file
        return $this->exportAsExcel($spreadsheet, 'enfants.xlsx');
    }


    // Exportation des Conjoints
    public function exportConjoints()
    {
        $conjoints = Conjoint::where('user_id', Auth::id())->with('auxiliaire')->get();
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
        $sheet->setCellValue('F1', 'Nom Du l\'Auxiliaire');
        $sheet->setCellValue('G1', 'Prenom Du l\'Auxiliaire');
        

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
            $sheet->setCellValue('F' . $row, $conjoint->auxiliaire->Nom_Fr);
            $sheet->setCellValue('G' . $row, $conjoint->auxiliaire->Prenom_Fr);
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

       $auxiliaires = Auxiliaire::with(['enfants', 'conjoints'])
    ->where('user_id', Auth::id())
    ->get();

    
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
}
