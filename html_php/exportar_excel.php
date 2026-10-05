<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Recoger datos del formulario
$id     = isset($_POST['id']) ? $_POST['id'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$email  = isset($_POST['email']) ? $_POST['email'] : '';

// Crear documento Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Cabeceras
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Email');

// Insertar datos recibidos en la fila 2
$sheet->setCellValue('A2', $id);
$sheet->setCellValue('B2', $nombre);
$sheet->setCellValue('C2', $email);

// Descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="cliente.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
