<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 1. Obtener lista de productos para el filtro
$productos_result = $conexion->query("SELECT id, nombre FROM productos ORDER BY nombre ASC");
$lista_productos = [];
while ($row = $productos_result->fetch_assoc()) {
    $lista_productos[] = $row;
}

// 2. Obtener producto seleccionado
$producto_id = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : null;

$fechas = [];
$cantidades = [];
$totales_ventas = [];
$detalle_tendencia = [];

if ($producto_id) {
    // Consulta agrupada por Mes/Año para ver la tendencia
    $query = "
        SELECT 
            DATE_FORMAT(p.fecha, '%Y-%m') AS periodo,
            DATE_FORMAT(p.fecha, '%M %Y') AS nombre_mes,
            SUM(d.cantidad) AS total_unidades,
            SUM(d.cantidad * COALESCE(pr.precio, prod.precio)) AS total_recaudado
        FROM pedidos p
        JOIN detalle_pedido d ON p.id = d.pedido_id
        JOIN productos prod ON d.producto_id = prod.id
        LEFT JOIN precio pr ON d.producto_id = pr.producto_id
           AND p.fecha >= pr.fecha_inicio
           AND (p.fecha <= pr.fecha_fin OR pr.fecha_fin IS NULL)
        WHERE d.producto_id = $producto_id
        GROUP BY DATE_FORMAT(p.fecha, '%Y-%m')
        ORDER BY periodo ASC
    ";

    $resultado = $conexion->query($query);
    while ($row = $resultado->fetch_assoc()) {
        $fechas[] = $row['periodo'];
        $cantidades[] = (int)$row['total_unidades'];
        $totales_ventas[] = (float)$row['total_recaudado'];
        $detalle_tendencia[] = $row;
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tendencia de Ventas por Producto</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; background-color: #f4f6f9; }
    .container { max-width: 950px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    form { margin-bottom: 25px; }
    .chart-container { position: relative; width: 100%; height: 450px; margin-top: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 25px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #f2f2f2; }
    .no-data { color: #888; font-style: italic; margin-top: 15px; }
  </style>
</head>
<body>

<div class="container">
  <h2>📈 Tendencia Histórica de Ventas por Producto</h2>

  <form method="POST">
    <label for="producto_id"><strong>Selecciona un producto:</strong></label>
    <select name="producto_id" id="producto_id" onchange="this.form.submit()">
      <option value="">-- Seleccionar Producto --</option>
      <?php foreach($lista_productos as $prod): ?>
        <option value="<?= $prod['id'] ?>" <?= $producto_id == $prod['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($prod['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <?php if ($producto_id): ?>
    <?php if (!empty($detalle_tendencia)): ?>

      <!-- Gráfico de Tendencia -->
      <div class="chart-container">
        <canvas id="graficoTendencia"></canvas>
      </div>

      <!-- Tabla de Datos Históricos -->
      <h3>📋 Desglose Mensual</h3>
      <table>
        <thead>
          <tr>
            <th>Período (Año-Mes)</th>
            <th>Unidades Vendidas</th>
            <th>Total Ventas ($)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($detalle_tendencia as $fila): ?>
            <tr>
              <td><?= $fila['periodo'] ?></td>
              <td><strong><?= $fila['total_unidades'] ?></strong></td>
              <td>$<?= number_format($fila['total_recaudado'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <script>
        const fechas = <?= json_encode($fechas) ?>;
        const cantidades = <?= json_encode($cantidades) ?>;
        const totalesVentas = <?= json_encode($totales_ventas) ?>;

        new Chart(document.getElementById('graficoTendencia'), {
          type: 'line',
          data: {
            labels: fechas,
            datasets: [
              {
                label: 'Unidades Vendidas',
                data: cantidades,
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 3,
                tension: 0.3, // Curvatura de la línea de tendencia
                fill: true,
                yAxisID: 'y'
              },
              {
                label: 'Ingresos Totales ($)',
                data: totalesVentas,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: false,
                yAxisID: 'y1'
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: 'Comportamiento y Tendencia de Ventas',
                font: { size: 18 }
              }
            },
            scales: {
              x: {
                title: { display: true, text: 'Período (Año-Mes)' }
              },
              y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                title: { display: true, text: 'Unidades' }
              },
              y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                grid: { drawOnChartArea: false },
                title: { display: true, text: 'Monto ($)' }
              }
            }
          }
        });
      </script>

    <?php else: ?>
      <p class="no-data">El producto seleccionado no tiene ventas registradas.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>

</body>
</html>