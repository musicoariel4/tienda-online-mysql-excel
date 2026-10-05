
<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 1. Histograma por cliente (total de compras)
$sql_clientes = "SELECT c.nombre AS cliente, COUNT(*) AS total_compras
                 FROM ventas v
                 JOIN clientes c ON v.cliente_id = c.id
                 GROUP BY v.cliente_id";
$resultado_clientes = $conexion->query($sql_clientes);
$clientes = [];
$compras_por_cliente = [];
while ($row = $resultado_clientes->fetch_assoc()) {
    $clientes[] = $row['cliente'];
    $compras_por_cliente[] = $row['total_compras'];
}

// 2. Histograma por fecha (total de ventas por día)
$sql_fechas = "SELECT fecha, COUNT(*) AS ventas
               FROM ventas
               GROUP BY fecha
               ORDER BY fecha";
$resultado_fechas = $conexion->query($sql_fechas);
$fechas = [];
$ventas_por_fecha = [];
while ($row = $resultado_fechas->fetch_assoc()) {
    $fechas[] = $row['fecha'];
    $ventas_por_fecha[] = $row['ventas'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Histogramas de Ventas</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; }
    canvas { max-width: 800px; margin: 40px auto; display: block; }
  </style>
</head>
<body>

<h2>📊 Histograma: Total de Compras por Cliente</h2>
<canvas id="histogramaClientes"></canvas>

<h2>📆 Histograma: Ventas Registradas por Fecha</h2>
<canvas id="histogramaFechas"></canvas>

<script>
const clientes = <?= json_encode($clientes) ?>;
const compras = <?= json_encode($compras_por_cliente) ?>;

const fechas = <?= json_encode($fechas) ?>;
const ventas = <?= json_encode($ventas_por_fecha) ?>;

new Chart(document.getElementById('histogramaClientes'), {
  type: 'bar',
  data: {
    labels: clientes,
    datasets: [{
      label: 'Cantidad de Compras',
      data: compras,
      backgroundColor: 'rgba(255, 99, 132, 0.7)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Total de Compras por Cliente'
      },
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Cantidad' }
      }
    }
  }
});

new Chart(document.getElementById('histogramaFechas'), {
  type: 'bar',
  data: {
    labels: fechas,
    datasets: [{
      label: 'Ventas',
      data: ventas,
      backgroundColor: 'rgba(54, 162, 235, 0.7)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Cantidad de Ventas por Fecha'
      },
      legend: {
        display: false
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Ventas' }
      },
      x: {
        title: { display: true, text: 'Fecha' }
      }
    }
  }
});
</script>

</body>
</html>
