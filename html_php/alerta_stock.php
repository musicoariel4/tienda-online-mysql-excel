<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Límite configurable para la alerta de stock bajo
$limite_alerta = 5;

$sql_alertas = "
    SELECT 
        p.id, 
        p.nombre AS producto, 
        p.stock, 
        pv.nombre AS proveedor,
        pv.telefono
    FROM productos p
    LEFT JOIN proveedores pv ON p.proveedor_id = pv.id
    WHERE p.stock <= $limite_alerta
    ORDER BY p.stock ASC
";

$resultado = $conexion->query($sql_alertas);
$productos_alertar = [];
$total_agotados = 0;
$total_criticos = 0;

while ($row = $resultado->fetch_assoc()) {
    $productos_alertar[] = $row;
    if ($row['stock'] == 0) {
        $total_agotados++;
    } else {
        $total_criticos++;
    }
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Alertas de Stock</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 25px; background-color: #f4f6f9; }
    .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    
    /* Cajas de Alertas */
    .alert-box { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; }
    .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .alert-warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

    /* Tabla */
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background-color: #f8f9fa; }
    
    /* Badge de Stock */
    .badge { padding: 4px 8px; border-radius: 4px; color: #fff; font-size: 12px; font-weight: bold; }
    .bg-red { background-color: #dc3545; }
    .bg-orange { background-color: #fd7e14; }
  </style>
</head>
<body>

<div class="container">
  <h2>⚠️ Panel de Alertas de Inventario</h2>

  <!-- Banners de Notificación -->
  <?php if ($total_agotados > 0): ?>
    <div class="alert-box alert-danger">
      🚨 Atención: Tienes <strong><?= $total_agotados ?></strong> producto(s) totalmente **AGOTADOS**.
    </div>
  <?php endif; ?>

  <?php if ($total_criticos > 0): ?>
    <div class="alert-box alert-warning">
      ⚠️ Advertencia: Tienes <strong><?= $total_criticos ?></strong> producto(s) en **STOCK CRÍTICO** (≤ <?= $limite_alerta ?> unidades).
    </div>
  <?php endif; ?>

  <?php if (empty($productos_alertar)): ?>
    <div class="alert-box alert-success">
      ✅ ¡Todo en orden! Todos los productos cuentan con suficiente stock.
    </div>
  <?php else: ?>

    <!-- Tabla con detalle de artículos a reposicionar -->
    <h3>📦 Productos que Requieren Reposición</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Producto</th>
          <th>Stock Actual</th>
          <th>Estado</th>
          <th>Proveedor</th>
          <th>Contacto Proveedor</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos_alertar as $item): ?>
          <tr>
            <td><?= $item['id'] ?></td>
            <td><strong><?= htmlspecialchars($item['producto']) ?></strong></td>
            <td><?= $item['stock'] ?></td>
            <td>
              <?php if ($item['stock'] == 0): ?>
                <span class="badge bg-red">AGOTADO</span>
              <?php else: ?>
                <span class="badge bg-orange">CRÍTICO</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($item['proveedor'] ?? 'Sin asignar') ?></td>
            <td><?= htmlspecialchars($item['telefono'] ?? 'N/A') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>
</div>

</body>
</html>