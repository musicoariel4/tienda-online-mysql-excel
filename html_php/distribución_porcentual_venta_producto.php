<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener las ventas agrupadas por producto
$query = "
    SELECT 
        prod.nombre AS producto,
        SUM(d.cantidad) AS total_unidades,
        SUM(d.cantidad * COALESCE(pr.precio, prod.precio)) AS total_efectivo
    FROM detalle_pedido d
    JOIN pedidos p ON d.pedido_id = p.id
    JOIN productos prod ON d.producto_id = prod.id
    LEFT JOIN precio pr ON d.producto_id = pr.producto_id
       AND p.fecha >= pr.fecha_inicio
       AND (p.fecha <= pr.fecha_fin OR pr.fecha_fin IS NULL)
    GROUP BY prod.id, prod.nombre
    HAVING total_unidades > 0
    ORDER BY total_efectivo DESC
";

$resultado = $conexion->query($query);

$labels = [];
$cantidades = [];
$efectivo = [];

while ($row = $resultado->fetch_assoc()) {
    $labels[] = $row['producto'];
    $cantidades[] = (int)$row['total_unidades'];
    $efectivo[] = (float)$row['total_efectivo'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Distribución Porcentual con Etiquetas</title>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Plugin de Etiquetas Directas para Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; background-color: #f4f6f9; }
    .container { max-width: 1100px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .charts-grid { display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
    .chart-box { flex: 1; min-width: 320px; max-width: 500px; height: 420px; position: relative; }
  </style>
</head>
<body>

<div class="container">
  <h2>🥧 Distribución Porcentual de Ventas por Producto</h2>

  <div class="charts-grid">
    <!-- Gráfico 1: Porcentaje en Efectivo -->
    <div class="chart-box">
      <canvas id="graficoEfectivo"></canvas>
    </div>
    
    <!-- Gráfico 2: Porcentaje en Cantidades -->
    <div class="chart-box">
      <canvas id="graficoCantidad"></canvas>
    </div>
  </div>
</div>

<script>
  // Registrar el plugin de etiquetas directas
  Chart.register(ChartDataLabels);

  const labels = <?= json_encode($labels) ?>;
  const dataEfectivo = <?= json_encode($efectivo) ?>;
  const dataCantidades = <?= json_encode($cantidades) ?>;

  const coloresBase = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
    '#858796', '#9966ff', '#ff9f40', '#4bc0c0', '#e83e8c'
  ];

  // Configuración de visualización de etiquetas de porcentaje
  const configDatalabels = {
    color: '#fff',
    font: { weight: 'bold', size: 13 },
    formatter: (value, ctx) => {
      let sum = 0;
      let dataArr = ctx.chart.data.datasets[0].data;
      dataArr.map(data => { sum += Number(data); });
      let percentage = (value * 100 / sum).toFixed(1) + "%";
      return percentage; // Muestra el % directamente sobre el pastel
    }
  };

  // 1. Gráfico de Porcentaje por Efectivo ($)
  new Chart(document.getElementById('graficoEfectivo'), {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: dataEfectivo,
        backgroundColor: coloresBase
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Ventas por Efectivo ($) - % Porcentual',
          font: { size: 16 }
        },
        datalabels: configDatalabels
      }
    }
  });

  // 2. Gráfico de Porcentaje por Cantidad (Unidades)
  new Chart(document.getElementById('graficoCantidad'), {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: dataCantidades,
        backgroundColor: coloresBase
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: {
          display: true,
          text: 'Ventas por Unidades - % Porcentual',
          font: { size: 16 }
        },
        datalabels: configDatalabels
      }
    }
  });
</script>

</body>
</html>