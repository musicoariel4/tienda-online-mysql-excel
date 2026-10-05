<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas por Cliente</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    canvas { max-width: 800px; margin: auto; display: block; }
  </style>
</head>
<body>
  <h2>Participación de Clientes</h2>
  <canvas id="ventasCliente"></canvas>

  <?php
  $query = $conexion->query("SELECT c.nombre, SUM(v.total) as total
                             FROM ventas v 
                             JOIN clientes c ON v.cliente_id = c.id 
                             GROUP BY c.id");
  $clientes = []; $totales = [];
  while($row = $query->fetch_assoc()){
      $clientes[] = $row['nombre'];
      $totales[] = $row['total'];
  }
  ?>

  <script>
    const ctx = document.getElementById('ventasCliente').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($clientes); ?>,
        datasets: [{
          label: 'Total Ventas',
          data: <?php echo json_encode($totales); ?>,
          backgroundColor: ['#ff6384','#36a2eb','#ffce56','#4bc0c0','#9966ff']
        }]
      }
    });
  </script>
</body>
</html>