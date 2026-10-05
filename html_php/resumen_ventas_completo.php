<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Totales
$total_ventas = $conexion->query("SELECT COUNT(*) AS total FROM ventas")->fetch_assoc()['total'];
$total_ingresos = $conexion->query("SELECT SUM(cantidad * precio_unitario) AS total FROM ventas")->fetch_assoc()['total'];
$promedio = $conexion->query("SELECT AVG(cantidad * precio_unitario) AS promedio FROM ventas")->fetch_assoc()['promedio'];

// Ventas por producto
$productos_result = $conexion->query("
    SELECT p.nombre, SUM(v.cantidad) AS total
    FROM ventas v
    JOIN productos p ON v.producto_id = p.id
    GROUP BY p.id
");
$productos = [];
$ventas_producto = [];
while ($row = $productos_result->fetch_assoc()) {
    $productos[] = $row['nombre'];
    $ventas_producto[] = $row['total'];
}

// Ventas por cliente
$clientes_result = $conexion->query("
    SELECT c.nombre, COUNT(*) AS total
    FROM ventas v
    JOIN clientes c ON v.cliente_id = c.id
    GROUP BY c.id
");
$clientes = [];
$ventas_cliente = [];
while ($row = $clientes_result->fetch_assoc()) {
    $clientes[] = $row['nombre'];
    $ventas_cliente[] = $row['total'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resumen de Ventas</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; }
    .resumen { margin-bottom: 20px; }
    canvas { margin: 40px auto; display: block; max-width: 800px; }
  </style>
</head>
<body>

<h2>📊 Resumen General de Ventas</h2>

<div class="resumen"><strong>Total de ventas:</strong> <?= $total_ventas ?></div>
<div class="resumen"><strong>Total de ingresos:</strong> $<?= number_format($total_ingresos, 2) ?></div>
<div class="resumen"><strong>Promedio por venta:</s
