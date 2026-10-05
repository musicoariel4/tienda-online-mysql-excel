<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta: Total de unidades vendidas por producto
$sql = "SELECT producto AS producto, SUM(total) AS total_vendido
        FROM vista_ventas 
        GROUP BY producto";

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
    <link rel="stylesheet" type="text/css" href="menustyle.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
     body {
      font-family: Arial, sans-serif;
      padding: 25px;
    }

    .metric {
      margin: 5px 0;
    }

    /* Gráfico de productos */
    .grafico-productos {
      width: 100%;
      max-width: 800px;
      height: 500px;
      margin: auto;
    }

    /* Gráfico de clientes */
    .grafico-clientes {
      width: 400px;
      height: 280px;
      margin: auto;
    }

    canvas {
      width: 100% !important;
      height: 100% !important;
    }
  </style>
</head>
<body>

  <h2>📊 Histograma: Ingresos por Producto</h2>
   <div class="grafico-productos">
  <canvas id="histogramaProductos"></canvas>
   </div>
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
              text: 'Total de ventas'
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
            text: 'Total de Ingresos por Producto'
          },
          legend: {
            display: false
          }
        }
      }
    });
  </script>

<footer>
  &copy; 2026 Tienda Online - Proyecto Académico
</footer>

 
  <p style="text-align:center;"><a href="menu_graficos.php">⬅ Volver al Menú</a></p>
</body>
</html>