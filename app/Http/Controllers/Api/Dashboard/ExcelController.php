<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Ticket;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    public function export(Request $request){

        $equipos=Equipo::all();
        $spreadsheet=new Spreadsheet();
    
        $sheet=$spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Modelo');
        $sheet->setCellValue('C1', 'Numero de serie');
        $sheet->setCellValue('D1', 'Categoria');
        $sheet->setCellValue('E1', 'oficina');
        $sheet->setCellValue('F1','estado actual');
        


        // $row=2;

        // foreach ($equipos as $equipo) {
        //     $sheet->setCellValue('A' . $row, $equipo->id);
        //     $sheet->setCellValue('B' . $row, " " . $equipo->modelo);
        //     $sheet->setCellValue('C' . $row, " " . $equipo->numero_serie);
        //     $sheet->setCellValue('D' . $row, $equipo->categoria->name);
        //     $sheet->setCellValue('E' . $row, $equipo->oficina->name);
        //     $sheet->setCellValue('F' . $row, $equipo->status->name);
        //     $row++;
        // }

        $writer = new Xlsx($spreadsheet);
        $filename = 'equipos.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        // Devuelve el archivo Excel para descargar
        return response()->download(storage_path('app/public/' . $filename));
    }

    public function exportTicket(Request $request){

        $equipos=Ticket::all();
        $spreadsheet=new Spreadsheet();
        
        $sheet=$spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Modelo');
        $sheet->setCellValue('C1', 'Numero de serie');
        $sheet->setCellValue('D1', 'Categoria');
        $sheet->setCellValue('E1', 'oficina');
        $sheet->setCellValue('F1','estado actual');
        


        $row=2;

        foreach ($equipos as $equipo) {
            $sheet->setCellValue('A' . $row, $equipo->id);
            $sheet->setCellValue('B' . $row, " " . $equipo->modelo);
            $sheet->setCellValue('C' . $row, " " . $equipo->numero_serie);
            $sheet->setCellValue('D' . $row, $equipo->categoria->name);
            $sheet->setCellValue('E' . $row, $equipo->oficina->name);
            $sheet->setCellValue('F' . $row, $equipo->status->name);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'equipos.xlsx';
        $writer->save(storage_path('app/public/' . $filename));

        // Devuelve el archivo Excel para descargar
        return response()->download(storage_path('app/public/' . $filename));
    }
}
