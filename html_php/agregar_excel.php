<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Recibir datos del formulario
$id     = $_POST['id'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$email  = $_POST['email'] ?? '';

$archivo = 'clientes.xlsx';

// ¿Existe ya el archivo?
if (file_exists($archivo)) {
    // Abrir archivo existente
    $spreadsheet = IOFactory::load($archivo);
    $sheet = $spreadsheet->getActiveSheet();
} else {
    // Crear uno nuevo y cabecera
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Email');
}

// Buscar la siguiente fila libre
$fila = $sheet->getHighestRow() + 1;

// Insertar datos
$sheet->setCellValue("A$fila", $id);
$sheet->setCellValue("B$fila", $nombre);
$sheet->setCellValue("C$fila", $email);

// Guardar el archivo nuevamente
$writer = new Xlsx($spreadsheet);
$writer->save($archivo);

echo "Cliente guardado correctamente en $archivo";
?>
