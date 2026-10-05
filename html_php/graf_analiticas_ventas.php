<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Totales
$total_ventas = $conexion->query("SELECT COUNT(*) AS total FROM ventas")->fetch_assoc()['total'];
$ingresos_totales = $conexion->query("SELECT SUM( total) AS total FROM ventas")->fetch_assoc()['total'];
$promedio_venta = $conexion->query("SELECT AVG(cantidad * total) AS promedio FROM ventas")->fetch_assoc()['promedio'];

// Datos para gráficos
// 1. Ventas por producto
$productos_result = $conexion->query("
  SELECT p.nombre AS producto, SUM(v.cantidad) AS total
  FROM ventas v
  JOIN productos p ON v.producto_id = p.id
  GROUP BY p.nombre
");

$productos = [];
$ventas_por_producto = [];
while ($row = $productos_result->fetch_assoc()) {
    $productos[] = $row['producto'];
    $ventas_por_producto[] = $row['total'];
}

// 2. Ventas por cliente
$clientes_result = $conexion->query("
  SELECT c.nombre AS cliente, COUNT(*) AS total
  FROM ventas v
  JOIN clientes c ON v.cliente_id = c.id
  GROUP BY c.nombre
");

$clientes = [];
$ventas_por_cliente = [];
while ($row = $clientes_result->fetch_assoc()) {
    $clientes[] = $row['cliente'];
    $ventas_por_cliente[] = $row['total'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Analíticas de Ventas</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 25px; }
    .metric { margin: 5px 0; }
   canvas {
  max-width: 800px;
  width: 100%;
  height: auto;
  margin: auto;
  display: block;
}
  </style>
</head>
<body>

  <h2>📈 Analíticas Básicas de Ventas</h2>

  <div class="metric"><strong>Total de ventas:</strong> <?= $total_ventas ?></div>
  <div class="metric"><strong>Total ingresos:</strong> $<?= number_format($ingresos_totales, 2) ?></div>
  <div class="metric"><strong>Promedio por venta:</strong> $<?= number_format($promedio_venta, 2) ?></div>

  <h3>🧮 Ventas por producto</h3>
  <canvas id="graficoProductos" width="50" height="25"></canvas>

  <h3>👥 Ventas por cliente</h3>
  <canvas id="graficoClientes" width="50" height="25"></canvas>

  <script>
    // Datos desde PHP a JavaScript
    const productos = <?= json_encode($productos) ?>;
    const ventasPorProducto = <?= json_encode($ventas_por_producto) ?>;

    const clientes = <?= json_encode($clientes) ?>;
    const ventasPorCliente = <?= json_encode($ventas_por_cliente) ?>;

    // Gráfico de Barras: Ventas por Producto
    new Chart(document.getElementById("graficoProductos"), {
      type: 'bar',
      data: {
        labels: productos,
        datasets: [{
          label: 'Unidades vendidas',
          data: ventasPorProducto,
          backgroundColor: '#4e73df'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          title: { display: true, text: 'Ventas por Producto' }
        }
      }
    });

    // Gráfico de Pastel: Ventas por Cliente
    new Chart(document.getElementById("graficoClientes"), {
      type: 'pie',
      data: {
        labels: clientes,
        datasets: [{
          label: 'Compras por cliente',
          data: ventasPorCliente,
          backgroundColor: [
            '#f6c23e', '#e74a3b', '#36b9cc', '#1cc88a', '#858796', '#5a5c69'
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: { display: true, text: 'Participación por Cliente' }
        }
      }
    });
  </script>
</body>
</html>
