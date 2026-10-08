<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener lista de clientes
$clientes_result = $conexion->query("SELECT id, nombre FROM clientes");
$clientes = [];
while ($row = $clientes_result->fetch_assoc()) {
    $clientes[] = $row;
}

// Obtener ID del cliente seleccionado
$cliente_id = isset($_POST['cliente_id']) ? (int)$_POST['cliente_id'] : null;
$productos = [];
$ventas = [];
$detalle_compras = []; // Guardará el desglose para la tabla HTML

if ($cliente_id) {
    // Consulta corregida con JOIN a la tabla 'productos' y GROUP BY por producto
    $query = "
        SELECT 
            prod.nombre AS producto, 
            SUM(v.cantidad) AS total_cantidad
        FROM clientes c
        JOIN pedidos pe ON c.id = pe.cliente_id
        JOIN detalle_pedido v ON pe.id = v.pedido_id
        JOIN productos prod ON v.producto_id = prod.id
        WHERE c.id = $cliente_id
        GROUP BY prod.id, prod.nombre
        ORDER BY total_cantidad DESC
    ";

    $resultado = $conexion->query($query);
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row['producto'];
        $ventas[] = (int)$row['total_cantidad'];
        $detalle_compras[] = $row; // Guardamos para listar en la tabla
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráfico y Detalle de Ventas por Cliente</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
     body {
     font-family: Arial, sans-serif;
     padding: 30px;
     background-color: #f9f9f9;
}
 form {
     margin-bottom: 25px;
}
.chart-container {
    position: relative;
    width: 100%;
    height: 500px; /* Controla la altura del gráfico (ajústalo a tu gusto: 500px, 600px, etc.) */
    margin-top: 20px;
}

 table {
     width: 100%;
     border-collapse: collapse;
     margin-top: 25px;
}
 th, td {
     border: 1px solid #ddd;
     padding: 10px 12px;
     text-align: left;
}
 th {
     background-color: #f2f2f2;
}
 tr:nth-child(even) {
     background-color: #fafafa;
}
 .no-data {
     color: #888;
     font-style: italic;
     margin-top: 15px;
}

  </style>
</head>
<body>

<div class="container">
  <h2>🔍 Filtro: Ventas por Cliente</h2>

  <form method="POST">
    <label for="cliente_id"><strong>Selecciona un cliente:</strong></label>
    <select name="cliente_id" id="cliente_id" onchange="this.form.submit()">
      <option value="">-- Seleccionar --</option>
      <?php foreach($clientes as $cliente): ?>
        <option value="<?= $cliente['id'] ?>" <?= $cliente_id == $cliente['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cliente['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <?php if ($cliente_id): ?>
    <?php if (!empty($detalle_compras)): ?>
      
      <!-- Listado/Tabla de Artículos Comprados -->
      <h3>🛒 Listado de Artículos Comprados</h3>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Total Unidades Compradas</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($detalle_compras as $index => $item): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($item['producto']) ?></td>
              <td><strong><?= $item['total_cantidad'] ?></strong></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- Gráfico de Ventas -->
      <h3 style="margin-top: 40px;">📊 Gráfico de Compras</h3>
      <div class="chart-container">
    <canvas id="graficoVentasCliente"></canvas>
      </div>
      <script>
        const productos = <?= json_encode($productos) ?>;
        const ventas = <?= json_encode($ventas) ?>;

       new Chart(document.getElementById('graficoVentasCliente'), {
  type: 'bar',
  data: {
    labels: productos,
    datasets: [{
      label: 'Unidades Vendidas',
      data: ventas,
      backgroundColor: 'rgba(153, 102, 255, 0.7)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false, // Permite que el gráfico use el alto completo de 500px
    plugins: {
      title: {
        display: true,
        text: 'Cantidad de Artículos Comprados por el Cliente',
        font: { size: 18 } // Opcional: aumenta el tamaño del título
      },
      legend: { display: false }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 },
        title: { display: true, text: 'Cantidad Vendida' }
      },
      x: {
        title: { display: true, text: 'Artículos / Productos' }
      }
    }
  }
});
      </script>

    <?php else: ?>
      <p class="no-data">El cliente seleccionado no tiene compras registradas.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>

</body>
</html>