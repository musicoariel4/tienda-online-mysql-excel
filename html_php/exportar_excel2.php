<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Recibimos los arrays desde el formulario
$ids     = $_POST['id'];
$nombres = $_POST['nombre'];
$emails  = $_POST['email'];

// Crear Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Email');

// Rellenamos filas
$fila = 2;
for($i=0; $i<count($ids); $i++){
    $sheet->setCellValue("A$fila", $ids[$i]);
    $sheet->setCellValue("B$fila", $nombres[$i]);
    $sheet->setCellValue("C$fila", $emails[$i]);
    $fila++;
}

// Descargar Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clientes.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
