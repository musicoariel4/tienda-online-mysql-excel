<?php
require 'vendor/autoload.php';  // Composer autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// 1. Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// 2. Escribir datos en las celdas
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Email');

// Datos de ejemplo
$datos = [
    [1, 'Juan Pérez', 'juan@example.com'],
    [2, 'María García', 'maria@example.com'],
    [3, 'Carlos López', 'carlos@example.com'],
];

// Insertar datos a partir de la fila 2
$fila = 2;
foreach($datos as $filaDatos){
    $sheet->setCellValue('A'.$fila, $filaDatos[0]);
    $sheet->setCellValue('B'.$fila, $filaDatos[1]);
    $sheet->setCellValue('C'.$fila, $filaDatos[2]);
    $fila++;
}

// 3. Preparar descarga del archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="datos.xlsx"');
header('Cache-Control: max-age=0');

// 4. Crear el archivo xlsx
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
