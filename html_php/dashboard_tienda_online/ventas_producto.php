<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas por Producto</title>
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
  <h2>Ventas por Producto</h2>
  <canvas id="ventasProducto"></canvas>

  <?php
  $query = $conexion->query("SELECT p.nombre, SUM(v.total) AS total_vendido
FROM ventas v
JOIN productos p ON v.producto_id = p.id
GROUP BY p.nombre;
");
  $productos = []; $totales = [];
  while($row = $query->fetch_assoc()){
      $productos[] = $row['nombre'];
      $totales[] = $row['total_vendido'];
  }
  ?>

  <script>
    const ctx = document.getElementById('ventasProducto').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($productos); ?>,
        datasets: [{
          label: 'Unidades Vendidas',
          data: <?php echo json_encode($totales); ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: { responsive: true }
    });
  </script>
</body>
</html>