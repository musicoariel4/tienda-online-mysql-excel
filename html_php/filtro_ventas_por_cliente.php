
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

if ($cliente_id) {
    $query = "
        SELECT p.nombre, SUM(v.cantidad) AS total
        FROM ventas v
        JOIN productos p ON v.producto_id = p.id
        WHERE v.cliente_id = $cliente_id
        GROUP BY p.id
    ";
    $resultado = $conexion->query($query);
    while ($row = $resultado->fetch_assoc()) {
        $productos[] = $row['nombre'];
        $ventas[] = $row['total'];
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráfico de Ventas por Cliente</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 30px; }
    form { margin-bottom: 20px; }
    canvas { max-width: 800px; margin: 40px auto; display: block; }
  </style>
</head>
<body>

<h2>🔍 Filtro: Ventas por Cliente</h2>

<form method="POST">
  <label for="cliente_id">Selecciona un cliente:</label>
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
  <canvas id="graficoVentasCliente"></canvas>
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
        plugins: {
          title: {
            display: true,
            text: 'Ventas por Producto para Cliente Seleccionado'
          },
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Cantidad Vendida' }
          }
        }
      }
    });
  </script>
<?php endif; ?>

</body>
</html>
