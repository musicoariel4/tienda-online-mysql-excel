<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Ruta del archivo Excel
$archivo = 'clientes.xlsx';

// Verificar si existe
if (!file_exists($archivo)) {
    die("El archivo $archivo no existe.");
}

// Cargar el archivo
$spreadsheet = IOFactory::load($archivo);
$sheet = $spreadsheet->getActiveSheet();

// Leer datos
$highestRow = $sheet->getHighestRow();       // última fila con datos
$highestCol = $sheet->getHighestColumn();    // última columna con datos

echo "<h2>Clientes registrados en el Excel</h2>";
echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
      </tr>";

// Comenzamos en la fila 2 si la fila 1 son encabezados
for ($fila = 2; $fila <= $highestRow; $fila++) {
    $id     = $sheet->getCell("A".$fila)->getValue();
    $nombre = $sheet->getCell("B".$fila)->getValue();
    $email  = $sheet->getCell("C".$fila)->getValue();

    // Saltar filas vacías
    if ($id == "" && $nombre == "" && $email == "") continue;

    echo "<tr>
            <td>$id</td>
            <td>$nombre</td>
            <td>$email</td>
          </tr>";
}

echo "</table>";
