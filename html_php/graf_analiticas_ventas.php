<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Totales
$total_ventas = $conexion->query("SELECT COUNT(*) AS total FROM vista_ventas")->fetch_assoc()['total'];
$ingresos_totales = $conexion->query("SELECT SUM( total) AS total FROM vista_ventas")->fetch_assoc()['total'];
$promedio_venta = $conexion->query("SELECT AVG(total) AS promedio FROM vista_ventas")->fetch_assoc()['promedio'];

// Datos para gráficos
// 1. Ventas por producto
$productos_result = $conexion->query("
   SELECT producto AS producto, SUM(cantidad) AS total
  FROM vista_ventas
  GROUP BY producto
");

$productos = [];
$ventas_por_producto = [];
while ($row = $productos_result->fetch_assoc()) {
    $productos[] = $row['producto'];
    $ventas_por_producto[] = $row['total'];
}

// 2. Ventas por cliente
$clientes_result = $conexion->query("
  SELECT cliente AS cliente, COUNT(*) AS total
  FROM vista_ventas
  GROUP BY cliente
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
  
  <link rel="stylesheet" type="text/css" href="menustyle.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Plugin para mostrar porcentajes -->
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

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
      height: 350px;
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

  <h2>📈 Analíticas Básicas de Ventas</h2>

  <div class="metric">
    <strong>Total de ventas:</strong> <?= $total_ventas ?>
  </div>

  <div class="metric">
    <strong>Total ingresos:</strong>
    $<?= number_format($ingresos_totales, 2) ?>
  </div>

  <div class="metric">
    <strong>Promedio por venta:</strong>
    $<?= number_format($promedio_venta, 2) ?>
  </div>


  <!-- ============================= -->
  <!-- VENTAS POR PRODUCTO -->
  <!-- ============================= -->

  <h3>🧮 Ventas por producto</h3>

  <div class="grafico-productos">
    <canvas id="graficoProductos"></canvas>
  </div>


  <!-- ============================= -->
  <!-- VENTAS POR CLIENTE -->
  <!-- ============================= -->

  <h3>👥 Ventas por cliente</h3>

  <div class="grafico-clientes">
    <canvas id="graficoClientes"></canvas>
  </div>


  <script>

    // ==========================================
    // DATOS DESDE PHP A JAVASCRIPT
    // ==========================================

    const productos = <?= json_encode($productos) ?>;
    const ventasPorProducto =
      <?= json_encode($ventas_por_producto) ?>;

    const clientes = <?= json_encode($clientes) ?>;
    const ventasPorCliente =
      <?= json_encode($ventas_por_cliente) ?>;


    // ==========================================
    // GRÁFICO DE BARRAS
    // VENTAS POR PRODUCTO
    // ==========================================

    new Chart(
      document.getElementById("graficoProductos"),
      {
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

          maintainAspectRatio: false,

          plugins: {

            legend: {
              display: false
            },

            title: {
              display: true,
              text: 'Ventas por Producto'
            }

          }

        }
      }
    );


    // ==========================================
    // GRÁFICO DE PASTEL
    // VENTAS POR CLIENTE
    // ==========================================

    new Chart(
      document.getElementById("graficoClientes"),
      {
        type: 'pie',

        data: {

          labels: clientes,

          datasets: [{

            label: 'Compras por cliente',

            data: ventasPorCliente,

            backgroundColor: [
              '#f6c23e',
              '#e74a3b',
              '#36b9cc',
              '#1cc88a',
              '#858796',
              '#5a5c69'
            ],

            borderColor: '#ffffff',

            borderWidth: 2

          }]

        },

        plugins: [ChartDataLabels],

        options: {

          responsive: true,

          maintainAspectRatio: false,

          plugins: {

            title: {

              display: true,

              text: 'Participación por Cliente',

              font: {
                size: 16
              }

            },

            legend: {

              position: 'right',

              labels: {

                boxWidth: 12,

                font: {
                  size: 11
                }

              }

            },

            // ==================================
            // PORCENTAJES
            // ==================================

            datalabels: {

              color: '#ffffff',

              font: {

                weight: 'bold',

                size: 11

              },

              formatter: function(value, context) {

                const datos =
                  context.chart.data.datasets[0].data;

                const total =
                  datos.reduce(
                    (sum, valor) => sum + Number(valor),
                    0
                  );

                const porcentaje =
                  (value / total) * 100;

                return porcentaje.toFixed(1) + '%';

              }

            }

          }

        }

      }
    );

  </script>

<footer>
  &copy; 2026 Tienda Online - Proyecto Académico
</footer>

 
  <p style="text-align:center;"><a href="menu_graficos.php">⬅ Volver al Menú</a></p>
</body>
</html>