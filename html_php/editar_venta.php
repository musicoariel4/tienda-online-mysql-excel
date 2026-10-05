<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("❌ Error: No se especificó el ID de la venta.");
}

// Obtener datos de la venta actual
$sql = "SELECT p.id, p.cliente_id, p.fecha, d.producto_id, d.cantidad
        FROM pedidos p
        JOIN detalle_pedido d ON p.id = d.pedido_id
        WHERE p.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$venta = $resultado->fetch_assoc();
$stmt->close();

if (!$venta) {
    die("❌ Error: La venta especificada no existe.");
}

// Obtener lista de clientes y productos
$clientes = $conexion->query("SELECT id, nombre FROM clientes");
$productos = $conexion->query("SELECT id, nombre FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Venta</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    form { max-width: 400px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
    label { font-weight: bold; }
    select, input[type="number"], input[type="date"], button {
      width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; box-sizing: border-box;
    }
    button { background-color: #28a745; color: white; border: none; font-size: 16px; cursor: pointer; border-radius: 4px; }
    button:hover { background-color: #218838; }
  </style>
</head>
<body>
  <h2>✏️ Editar Venta #<?= htmlspecialchars($venta['id']) ?></h2>
  <form action="update_venta2.php" method="post">
    <!-- IDs necesarios para el procesamiento -->
    <input type="hidden" name="id" value="<?= $venta['id'] ?>">
    <input type="hidden" name="producto_id_antiguo" value="<?= $venta['producto_id'] ?>">
    <input type="hidden" name="cantidad_antigua" value="<?= $venta['cantidad'] ?>">

    <label for="cliente_id">Cliente:</label>
    <select name="cliente_id" id="cliente_id" required>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $c['id'] == $venta['cliente_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <label for="producto_id">Producto:</label>
    <select name="producto_id" id="producto_id" required>
      <?php while($p = $productos->fetch_assoc()): ?>
        <option value="<?= $p['id'] ?>" <?= $p['id'] == $venta['producto_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($p['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <label for="fecha">Fecha de Venta:</label>
    <input type="date" name="fecha" id="fecha" value="<?= $venta['fecha'] ?>" required>

    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" id="cantidad" value="<?= $venta['cantidad'] ?>" min="1" required>

    <button type="submit">💾 Actualizar Venta</button>
  </form>
  <p><a href="mostrar_ventas.php">⬅ Cancelar y Volver</a></p>
</body>
</html>