<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas Diarias</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
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
  <h2>Ventas por Día</h2>
  <canvas id="ventasDia"></canvas>

  <?php
  $query = $conexion->query("SELECT  fecha, SUM(total) AS total_vendido
                             FROM ventas 
                             GROUP BY fecha
                             ORDER BY fecha ASC");
  $fechas = []; $totales = [];
  while($row = $query->fetch_assoc()){
      $fechas[] = $row['fecha'];
      $totales[] = $row['total_vendido'];
  }
  ?>

  <script>
    const ctx = document.getElementById('ventasDia').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($fechas); ?>,
        datasets: [{
          label: 'Ventas ($)',
          data: <?php echo json_encode($totales); ?>,
          fill: false,
          borderColor: 'rgba(75,192,192,1)',
          tension: 0.1
        }]
      }
    });
  </script>
</body>
</html>