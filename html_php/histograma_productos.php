<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta: Total de unidades vendidas por producto
$sql = "SELECT p.nombre AS producto, SUM(v.cantidad) AS total_vendido
        FROM ventas v
        JOIN productos p ON v.producto_id = p.id
        GROUP BY p.id
        ORDER BY total_vendido DESC";

$resultado = $conexion->query($sql);

$productos = [];
$ventas = [];

while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila['producto'];
    $ventas[] = $fila['total_vendido'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Histograma de Ventas por Producto</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    canvas { max-width: 800px; margin: auto; display: block; }
  </style>
</head>
<body>

  <h2>📊 Histograma: Cantidad de Ventas por Producto</h2>
  <canvas id="histogramaProductos"></canvas>

  <script>
    const productos = <?= json_encode($productos) ?>;
    const cantidades = <?= json_encode($ventas) ?>;

    new Chart(document.getElementById('histogramaProductos'), {
      type: 'bar',
      data: {
        labels: productos,
        datasets: [{
          label: 'Unidades vendidas',
          data: cantidades,
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'x',
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Cantidad Vendida'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Producto'
            }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'Total de Unidades Vendidas por Producto'
          },
          legend: {
            display: false
          }
        }
      }
    });
  </script>

</body>
</html>
